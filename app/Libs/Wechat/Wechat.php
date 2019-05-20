<?php

namespace App\Libs\Wechat;

use App\Models\Student;
use App\Models\StudentPassword;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\Text;

class Wechat
{
    public static $app;
    public static $appMini;

    public function __construct ()
    {
        self::$app = EasyWeChat::officialAccount ();
        self::$appMini = EasyWeChat::miniProgram ();
    }

    /**
     * 小程序
     * @return mixed
     * @author shaowei
     * @access public mini
     */
    public static function mini ()
    {
        new self();
        return self::$appMini;
    }

    /**
     * 发送消息
     * @param $message 消息
     * @param $open_id openid
     * @access public sendOne
     * @return array|bool|EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws EasyWeChat\Kernel\Exceptions\RuntimeException
     * @author shaowei
     */
    public static function sendOne ( $message, $open_id )
    {
        if ( empty($student_id) ) {
            return false;
        } else {
            $message = new Text($message);
            return self::app ()->customer_service->message ($message)->to ($open_id)->send ();
        }
    }

    /**
     * 公众号
     * @return EasyWeChat\OfficialAccount\Application
     * @author shaowei
     * @access public app
     */
    public static function app ()
    {
        new self();
        return self::$app;
    }

    /**
     * 创建用户绑定二维码
     * @param $student_id
     * @access public bind_qrcode
     * @return array
     * @author shaowei
     */
    public static function bind_qrcode ( $student_id )
    {
        $data = serialize ([
            'type' => 'bind_user',
            'data' => $student_id
        ]);
        //{'type':'bind_user','data':"id"}
        return [
            'url' => self::app ()->qrcode->url (self::$app->qrcode->forever ($data)[ 'ticket' ]),
            'content' => $data
        ];
    }

}