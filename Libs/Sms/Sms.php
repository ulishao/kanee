<?php

namespace App\Libs\Sms;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

/**
 * Class Sms
 *
 * @package Libs\Sms
 */
class Sms
{
    public static $client;

    /**
     * Sms constructor.
     *
     * @throws \Exception
     */
    public function __construct ()
    {

    }

    /**
     * 短信验证
     * @param $phone
     * @param $code
     * @param $message
     * @param string $signName
     * @access public send
     * @return false|object
     * @throws \Exception
     * @author shaowei
     */
    public static function send ( $phone, $code, $message, $signName = '嘻哈帮街舞' )
    {
        self::$client = new Client(new App(config ('sms')));
        $req = new AlibabaAliqinFcSmsNumSend;
        $req->setRecNum ($phone)
            ->setSmsParam ([
                'code' => $code,
                'product' => $message
            ])
            ->setSmsFreeSignName ($signName)
            ->setSmsTemplateCode ('SMS_12215776');
        return self::$client->execute ($req);
    }
}