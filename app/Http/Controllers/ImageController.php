<?php

namespace App\Http\Controllers;


use App\Libs\Qiniu\Qiniu;
use App\Libs\ucloud\ucloud;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
{


    /**
     * 上传图片
     * @param Request $request
     * @return array|bool
     */
    public function store ( Request $request )
    {


        $validator = Validator::make (
            $request->all (), [
            'img' => 'required|bail|image|mimetypes:image/*|mimes:jpg,png,gif,bmp,jpeg',
        ]);

        if ( $validator->fails () ) {
            return $validator->errors ();
        }
        $path = $request->post ('path', 'static');
        $img = $request->file ('img');

        $url = Qiniu::upload ($path, file_get_contents ($img->getPathname ()));
        return response()->json(['data' => $url]);
    }
}
