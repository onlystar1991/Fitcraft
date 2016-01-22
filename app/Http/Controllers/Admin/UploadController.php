<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\UploadImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Image;

class UploadController extends Controller {


	public function index(UploadImageRequest $imageRequest)
    {
        $file_name = $imageRequest->file('image')->getClientOriginalName();
        $imageRequest->file('image')->move(public_path('uploads/icons'), $file_name );
        Image::make(public_path('uploads/icons/'.$file_name))->greyscale()->save(public_path('uploads/icons/grey_'.$file_name));

//        $img    = Storage::disk('local')->get('icons/'.$file_name);
//        $move   = Storage::disk('s3')->put('icons/' . $file_name, $img, 'public');
//        if ( empty($move) ) {
//            return Response::json([
//                'error_message' => 'Error while saving the image'
//            ], 400);
//        }

        return Response::json([
            'file_name' => $file_name,
            'path'      => iconPath($file_name),
            'module'    => $imageRequest->get('module')
        ],200);

    }

}
