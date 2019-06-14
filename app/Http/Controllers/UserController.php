<?php

namespace App\Http\Controllers;


use App\Libs\Qiniu\Qiniu;
use App\Models\Collect;
use App\Models\Img;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Http\Resources\Json\Resource;

class UserController extends Controller
{
    public function create()
    {
        $avatar = str_replace('/132' , '/0' , request()->post('avatar'));
        $dat    = self::getImage($avatar);
        // dd($dat);
        //$data = file_get_contents('https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLp7ZpiciawtKExmiaxQGvOoAlvUmclgG8ktK9pOSqMZqicLujSbKDX2Cr1Sxl0BicxsPiahAZOSiaVGXyAg/132');
//        $url = Qiniu::upload('user' , $dat);

        if($model = User::where('openid',request ()->post ('openid'))->first()) {
            $model->avatar = request()->post('avatar');
//            $model->url    = $url[ 'host_url' ];
            $model->save();
            return $model;
        }
        $data          = request()->post();
//        $data[ 'url' ] = $url[ 'host_url' ];
        return User::create($data);
    }

//curl 没有做错误处理
    static public function getImage( string $url )
    {
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL , $url);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);
        curl_setopt($ch , CURLOPT_ENCODING , ""); //加速 这个地方留空就可以了
        curl_setopt($ch , CURLOPT_HEADER , 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function index ()
    {
//        $data = User::get()->toArray();
//
//        foreach ($data as $key=>$datum){
//            $avatar = str_replace('/132' , '/0' , $datum['avatar']);
//            $dat    = self::getImage($avatar);
//
//            //$data = file_get_contents('https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLp7ZpiciawtKExmiaxQGvOoAlvUmclgG8ktK9pOSqMZqicLujSbKDX2Cr1Sxl0BicxsPiahAZOSiaVGXyAg/132');
//            $url = Qiniu::upload('user' , $dat);
//
//            if($model = User::where('openid','=',$datum['openid'])->first()) {
//                $model->url = $url[ 'host_url' ];
//                $model->save();
//
//            }
//
//        }
//        dd(1);
        return User::orderBydesc ('created_at')->paginate (10);
    }

    public function show()
    {
        return User::where ('openid', request ()->get ('openid'))->first ();
    }

    public function update ()
    {
//        $str = "";
//        for ($i=1; $i<=65; $i++){
//            if($i>9){
//                $num=$i;
//            }else{
//                $num = "0".$i;
//            }
//            $str.="https://i.meizitu.net/2019/05/04c".$num.".jpg,";
//        }
//        echo $str;die();
        $model = User::where ('openid', request ()->post ('openid'))->first ();

        $model->content = request ()->post ('content');
        $model->save ();
        return $model;
    }
    public function code()
    {
        $config = [
            'app_id' => 'wxeacd33c85344fb56' ,
            'secret' => 'fe93bbb9245f91702302b5846efa69b3' ,

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            //            'response_type' => 'array',
            //
            //            'log' => [
            //                'level' => 'debug',
            //                'file' => __DIR__.'/wechat.log',
            //            ],
        ];
        $app    = Factory::miniProgram($config);
        return $app->auth->session( request ()->get ('code'));
//        User::create(
//          ['avatar'=>]
//        );
    }

    /**
     *
     * @param string $prefix
     * @access public uuid
     * @return string
     * @author shaowei
     */
    public function uuid( $prefix = '' )
    {
        $chars = md5( uniqid( mt_rand() , true ) );
        $uuid  = substr( $chars , 0 , 8 ) . '-';
        $uuid  .= substr( $chars , 8 , 4 ) . '-';
        $uuid  .= substr( $chars , 12 , 4 ) . '-';
        $uuid  .= substr( $chars , 16 , 4 ) . '-';
        $uuid  .= substr( $chars , 20 , 12 );
        return $prefix . $uuid;
    }


    public function collect()
    {

        $data         = request()->post();
        $data[ 'id' ] = $this->uuid();
        return Collect::create( $data );
    }
}
