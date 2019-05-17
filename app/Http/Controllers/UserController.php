<?php

namespace App\Http\Controllers;


use App\Models\Img;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Http\Resources\Json\Resource;

class UserController extends Controller
{
    public function create()
    {
        if($model = User::where('openid',request ()->post ('openid'))->first())
        {
            return $model;
        }
        return User::create(request ()->post ());
    }
    public function code()
    {
        $config = [
            'app_id' => 'wxeacd33c85344fb56',
            'secret' => 'fe93bbb9245f91702302b5846efa69b3',

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
//            'response_type' => 'array',
//
//            'log' => [
//                'level' => 'debug',
//                'file' => __DIR__.'/wechat.log',
//            ],
        ];
        $app = Factory::miniProgram($config);
        return $app->auth->session( request ()->get ('code'));
//        User::create(
//          ['avatar'=>]
//        );
    }
}
