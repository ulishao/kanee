<?php

namespace App\Http\Controllers;


use App\Libs\Qiniu\Qiniu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class ImageController extends Controller
{
    public function post(Request $request)
    {
//        $user_id = Auth::id();
        $avatar = $request->file('image')->store('/public/' . date('Y-m-d') . '/transformation');
        //上传的头像字段avatar是文件类型地址
        $avatar = Storage::url($avatar);//就是很简单的一个步骤
        //

        dd($avatar);
//        $resource = Resource::create(['type' => 1, 'resource' => $avatar, 'user_id' => $user_id]);
//        if ($resource) {
//            return $this->responseForJson(ERR_OK, 'upload success');
//        }
//        return $this->responseForJson(ERR_EDIT, 'upload fails');
//        dd( $request->file('image'),$request->file());
    }
    public function home()
    {
        return view('home');
    }

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
