<?php

namespace App\Http\Controllers;

use App\Models\Collect;
use App\Models\Ka;
use App\Models\Like;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use EasyWeChat\Factory;

class UserController extends Controller
{
    public function ka()
    {
        Ka::create(request()->post());
        return true;
    }

    /**
     * 活跃用户
     */
    public function h ()
    {
        return Like::query()->select(['*', \DB::raw('count(id) as num')])
            ->with('user')
            ->where('openid', '<>', '')
            ->whereDate('created_at', Carbon::parse()->toDateString())
            ->groupBy('openid')
            ->orderBy('num', 'desc')->limit(12)->get();
    }

    public function form ()
    {
        return Message::create(request()->post());
    }

    public function send ()
    {
        $config = [
            'app_id' => 'wxeacd33c85344fb56',
            'secret' => 'fe93bbb9245f91702302b5846efa69b3',
        ];
        $app = Factory::miniProgram($config);
        return $app->template_message->send([
            'touser'     =>'og0kA5USbNHUyDBR6PY0oFYKmMU0' ,
            'template_id'=> 'OJYekjV9bzjgBI2EGpm7g-r9JT7Xl1ZRgmGp82kO_tQ' ,
            'page'       => 'pages/home/home' ,
            'form_id'    =>'17ac91929f5e4f32ad43c998eb5da193' ,
            'data'       => [
                'keyword1'=>'咋样；哈喽' ,
                'keyword2'=>'5201314' ,
                'keyword3'=> Carbon::parse() ,
                'keyword4'=>'不。这是随即头像消息推送' ,
            ] ,
        ]);
    }

    public function tag ()
    {
        return [
            [
                'url' => 'https://api.kanee.top/1.png',
                'tag' => '蜡笔小新'
            ],
            [
                'url' => 'https://api.kanee.top/1.png',
                'tag' => '蜡笔小新'
            ],
            [
                'url' => 'https://api.kanee.top/1.png',
                'tag' => '蜡笔小新'
            ],
            [
                'url' => 'https://api.kanee.top/1.png',
                'tag' => '蜡笔小新'
            ],
        ];
    }
    public function dd()
    {

        $data=User::whereNull ('longitude')->whereNotNull ('ip')->get ()->toArray ();
        foreach ($data as $key=>$datum) {
//            try{
            $url = 'http://api.map.baidu.com/location/ip?v=2.0&ak=hmHVRwKE6r8IpmAKWGhgxiF6QVvQhs7s&ip=' . $datum[ 'ip' ] . '&coor=gcj02';
            $dd = json_decode(file_get_contents($url), true);
            $id = $datum[ 'id' ] - 10000;
            if ( empty($dd[ 'content' ][ 'point' ]) ) {
                dd($dd);
            }
            User::where(['id' => $id])->update([
                'longitude' => $dd[ 'content' ][ 'point' ][ 'x' ],
                'latitude' => $dd[ 'content' ][ 'point' ][ 'y' ],
            ]);
            sleep(2);
//            }catch (\ErrorException $exception){
//                echo $datum['id'].'err';
//            }

//            dd();
        }


    }

    public function info()
    {
        return [
            [
                'name'=>'卜枫',
                'title'=>'奔腾T77',
                'mobile'=>'15003742861',
                'share_image'=>'https://dss2.bdstatic.com/8_V1bjqh_Q23odCf/pacific/1892624473.jpg',
                'share_title'=>'卜枫 专业汽车销售',
                'avatar'=>'https://dss2.bdstatic.com/8_V1bjqh_Q23odCf/pacific/1892624473.jpg',
                'desc'=>'联系本人减100元',
                'qrcode'=>'https://pic.969009.com/hong/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20200106133639.jpg',
                'price'=>'9.2w',
                'xprice'=>'10w',
                'cat'=>[
                    [
                        'color'=>'blue',
                        'name'=>'奔腾',
                    ],
                ],
            ],
            [
                'name'=>'卜枫',
                'title'=>'奔腾T99',
                'mobile'=>'15003742861',
                'share_image'=>'https://img.cheshi-img.com/product/1_720/p/59300/59347/5d80829b5f150.jpg',
                'share_title'=>'卜枫 专业汽车销售',
                'avatar'=>'https://img.cheshi-img.com/product/1_720/p/59300/59347/5d80829b5f150.jpg',
                'desc'=>'联系本人减100元',
                'qrcode'=>'https://pic.969009.com/hong/%E5%BE%AE%E4%BF%A1%E5%9B%BE%E7%89%87_20200106133639.jpg',
                'price'=>'13.2w',
                'xprice'=>'20w',
                'cat'=>[
                    [
                        'color'=>'blue',
                        'name'=>'奔腾',
                    ],
                ],
            ]
        ];
    }
    public function title ()
    {
//        $h=date ("H");

//        if ( $h < 11 ) $titl="早上好!";
//        else if ( $h < 13 ) $titl="中午好！";
//        else if ( $h < 17 ) $titl="下午好！";
//        else $titl="晚上好！";

        return ['title' => '有事请联系微信号:zxmxoxo'];
    }
    public function create()
    {
//        $avatar = str_replace('/132' , '/0' , request()->post('avatar'));
//        $dat    = self::getImage($avatar);
        // dd($dat);
        //$data = file_get_contents('https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLp7ZpiciawtKExmiaxQGvOoAlvUmclgG8ktK9pOSqMZqicLujSbKDX2Cr1Sxl0BicxsPiahAZOSiaVGXyAg/132');
//        $url = Qiniu::upload('user' , $dat);

        if($model = User::where('openid',request ()->post ('openid'))->first()) {
            if ( request ()->post ('avatar') ) {
                $model->avatar=request ()->post ('avatar');
                $model->ip    =request ()->getClientIp ();
                $model->save ();
            }

            return $model;
        }
        $data         = request()->post();
        $data[ 'ip' ] = request ()->getClientIp ();
//        $data[ 'url' ] = $url[ 'host_url' ];
        return User::create($data);
    }

    public function like ()
    {
        $add=request ()->post ();
        if ( $model=Like::where ([
            'openid'=>request ()->post ('openid') ,
            'url'   =>request ()->post ('url'),
        ])->first () ) {
            return $model;
        }
        $add[ 'ip' ] = request()->getClientIp();
        return Like::create( $add );
    }

    public function getlike ()
    {
        if ( request ()->get ('openid') ) {
            return Like::where (['openid' => request ()->get ('openid')])->orderBydesc ('created_at')->paginate (20);
        } else {
            return Like::orderBydesc('created_at')->paginate(40);
        }
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
        if ( request ()->get ('page') == 1 || empty(request ()->get ('page')) ) {
            $data          =User::orderBydesc ('created_at')->paginate (10)->toArray ();
            $user          =User::where ([ 'id'=>1 ])->first ()->toArray ();
            $user[ 'id' ]  ='温馨小提示';
            $user[ 'name' ]='';
//            $aaa = [
//                '友情提示!重新授权可更换主题颜色。😹' ,
//                '💸由于昨天广告收益0.02分,广告已被全部关闭' ,
//
//            ];
//            $user[ 'content' ] = $aaa[ array_rand([0, 1, 2], 1) ];
            array_unshift ($data[ 'data' ] , $user);
            return $data;
        } else {
            return User::orderBydesc('created_at')->paginate(10);
        }
    }

    public function show1 ()
    {
        $id = request()->get('id') - 10000;
        return User::where('id', $id)->first();
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

    public function ditu ()
    {
        $model = User::where('openid', request()->post('openid'))->first();

        $model->latitude = request()->post('lat');
        $model->longitude= request()->post('lng');
        $model->type     =2;
        $model->save();
        return $model;
    }

    public function qing_code()
    {
        $config=[
            'app_id'=>'wxf7a14bdb37908ebf' ,
            'secret'=>'2c047148280e63d9b49020504de6a527' ,
        ];
        $app   =Factory::miniProgram ($config);
        return $app->auth->session (request ()->get ('code'));
    }
    public function code()
    {
        $config = [
            'app_id' => 'wxeacd33c85344fb56' ,
            'secret' => 'fe93bbb9245f91702302b5846efa69b3' ,
        ];
        $app    = Factory::miniProgram($config);
        return $app->auth->session( request ()->get ('code'));
    }

    public function code_ka ()
    {
        $config = [
            'app_id' => 'wxbcbb56b323164e45',
            'secret' => '2b16b97431a2e38f993d62fe09310187',
        ];
        $app = Factory::miniProgram($config);
        return $app->auth->session(request()->get('code'));
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

    public function getIndex ()
    {

        return User::select(['id', 'openid', 'latitude', 'longitude', 'sex'])->whereNotNull('latitude')->get();
    }
    public function collect()
    {

        $data         = request()->post();
        $data[ 'id' ] = $this->uuid();
        return Collect::create( $data );
    }
}
