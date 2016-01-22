<?php namespace App\BikeCraft;

use App\BikeCraft\Parser\ParserFIT;
use App\BikeCraft\Parser\ParserTCX;
use App\BikeCraft\Parser\ParserGPX;
use App\Models\Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;

/**
 * Class Processing
 * @package App\BikeCraft
 */
class Processing {

    /**
     * @var
     */
    private $parserTCX;
    /**
     * @var ParseFit
     */
    private $parseFit;

    /**
     * @var ParserFIT
     */
    private $parserFIT;

    /**
     * @var ParserGPX
     */
    private $parserGPX;

    /**
     * Accepted extension for upload
     * @var array
     */
    private $acceptFiles = ['fit','tcx','gpx'];

    /**
     * @param ParserTCX $parserTCX
     * @param ParserFIT $parserFIT
     * @param parserGPX $parserGPX
     */
    public function __construct(ParserTCX $parserTCX,
                                 ParserFIT $parserFIT,
                                 ParserGPX $parserGPX
                                )
    {

        $this->parserTCX    = $parserTCX;
        $this->parserFIT    = $parserFIT;
        $this->parserGPX    = $parserGPX;
    }


    /**
     * Processing File
     * @param $file
     */
    public function doProcessing($file)
    {
        switch(strtolower($file->ext)) {
            case 'fit':
                $this->parserFIT->parserActivity($file);
                break;
            case 'tcx':
                $this->parserTCX->parserActivity($file);
                break;
            case 'gpx':
                $this->parserGPX->parserActivity($file);
                break;                
        }
    }


    /**
     * @param $request
     * @return mixed
     */
    public function doUpload($request)
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $ext = $file->getClientOriginalExtension();

            if ( !in_array(strtolower($ext), $this->acceptFiles )) {
                return Response::json([
                    'message'   => 'You can upload only fit, gpx or tcx file'
                ],400);
            }

            $orginal_name    = $file->getClientOriginalName();

            $getFile        = Files::getFileStatus(['files.original_filename'=>$orginal_name,'files.user_id'=>Auth::client()->user()->id]);

            if ( !empty($getFile) ) {
                return Response::json([
                    'success'   => false,
                    'type'      => 'danger',
                    'message'   => Lang::get('app.error.upload_file_already_exist')
                ],400);
            }

            $fileName       = time();
            $newFileName    = $fileName.'.'.$ext;

            $request->file('file')->move(public_path() . '/uploads/rides/', $newFileName);

            if ( strtolower($ext) == 'fit' ) {
                exec('java -jar '.APPLICATION_PATH.'/resources/sdk/java/FitCSVTool.jar -b '.APPLICATION_PATH.'/public/uploads/rides/' . $newFileName.' '.APPLICATION_PATH.'/public/uploads/rides/' .$fileName.'.csv' );
            }

            switch(strtolower($ext)) {
                case 'fit':
                    $result = $this->parserFIT->doUpload($fileName);
                    break;
                case 'tcx':
                    $result = $this->parserTCX->doUpload($newFileName);
                    break;
                case 'gpx':
                    $result = $this->parserGPX->doUpload($newFileName);
                    break;                    
            }

            $model = Files::add([
               'user_id'                => Auth::client()->user()->id,
                'filename'              => $fileName,
                'original_filename'     => $orginal_name,
                'path'                  => '/rides/'.$newFileName,
                'ext'                   => $ext,
                'session_timestamp'     => $result['timestamp'],
                'total_elapsed_time'    => $result['total_elapsed_time'],
                'start'                 => $result['start'],
                'end'                   => $result['end']
            ]);

            $result['uploadParsing']->file_id = $model->id;
            $result['uploadParsing']->save();

            $geocoder = $this->geoCoder($result['lat'], $result['lng']);
            
            // $user = Auth::client()->user();
            // if(strtotime($model->start) < strtotime($user->created_at)) {
            //     return Response::json([
            //         'success'   => false,
            //         'type'      => 'danger',
            //         'message'   => 'The ride creation date ('.date('m/d/y',strtotime($model->start)).') is before your account creation date (' .date('m/d/y',strtotime($user->created_at)) .')'
            //     ],400);                
            // }
            
            return Response::json([
                'id'        => $model->id,
                'title'     => $geocoder['locality'],
                'date'      => date('m/d/y',strtotime($model->start)),
                'time'      => date('h:i A',strtotime($model->start)).'-'.date('h:i A',strtotime($model->end))
            ],200);

        }
    }


    /**
     * @param $lat
     * @param $lng
     * @return array
     */
    protected function geoCoder($lat, $lng)
    {
        $geocoder = \Geocoder::geocode('json', ["latlng"=>"$lat,$lng" ]);

        $reponse    = json_decode($geocoder,true);
        if(isset($reponse['results'][0]['address_components'])) {

            foreach($reponse['results'][0]['address_components'] as $key=>$value) {

                if ( $value['types'][0] == 'locality' ) {
                    $locality = $value['long_name'];
                }
                if ( $value['types'][0] == 'country' ) {
                    $country = $value['long_name'];
                }
                if ( $value['types'][0] == 'postal_code' ) {
                    $postal_code = $value['long_name'];
                }
                if ( $value['types'][0] == 'administrative_area_level_1' ) {
                    $administrative_area_level_1 = $value['long_name'];
                }
            }
        }

        return [
            'locality'                      => isset($locality) ? $locality : '',
            'country'                       => isset($country) ? $country : '',
            'postal_code'                   => isset($postal_code) ? $postal_code : '',
            'administrative_area_level_1'   => isset($administrative_area_level_1) ? $administrative_area_level_1 : '',
        ];
    }




} 