<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Libs\Qiniu\Qiniu;
use Illuminate\Http\Request;
use Validator;

class ImageController extends Controller
{


    /**
     * 上传图片
     * @param Request $request
     * @access public store
     * @return Resource
     * @throws ApiException
     * @author shaowei
     */
    public function store ( Request $request )
    {

        $validator = Validator::make (
            $request->all (), [
            'img' => 'required|bail|image|mimetypes:image/*|mimes:jpg,png,gif,bmp,jpeg',
        ]);
        if ( $validator->fails () ) {
            return false;
        }
        $path = $request->post ('path', 'static');
        $img = $request->file ('img');
        $url = Qiniu::upload ($path, file_get_contents ($img->getPathname ()));
        return ['data' => $url];
    }
}
