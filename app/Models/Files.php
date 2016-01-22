<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model {

	protected $table = 'files';

    /**
     * @param $fields
     * @return Files
     */
    public static function add($fields)
    {
        $model = new Files();
        foreach ($fields as $key=>$value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getWhere($where)
    {
        return parent::where($where)
                        ->get();
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getFirst($where)
    {
        return parent::where($where)
                        ->first();
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getFileStatus($where)
    {
        return parent::select('upload_parsings.completed_all as status')
                        ->leftJoin('upload_parsings','upload_parsings.file_id','=','files.id')
                        ->where($where)
                        ->where('upload_parsings.completed_all','Y')
                        ->first();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public static function getListWithStatus($user_id)
    {
       return parent::select('files.id',
                                'files.start',
                                'files.end',
                                'upload_parsings.completed_all as status')
                        ->leftJoin('upload_parsings','upload_parsings.file_id','=','files.id')
                        ->where('files.user_id',$user_id)
                        ->get();

    }

    /**
     * @param $file_id
     * @return mixed
     */
    public static function getDetails($file_id)
    {
        return parent::select('files.*','upload_parsings.completed_all')
                        ->leftJoin('upload_parsings','upload_parsings.file_id','=','files.id')
                        ->where('files.id',$file_id)
                        ->first();
    }
   
}
