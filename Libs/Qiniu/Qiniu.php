<?php

namespace App\Libs\Qiniu;

use Storage;


class Qiniu
{
    public static $niu;

    public function __construct ()
    {
        self::$niu = Storage::disk('public');
    }

    /**
     * 上传图片
     *
     * @param string $path 图片
     * @param string $contents 二进制
     * @param string $type 文件类型
     * @param int $size 大小
     * @access public upload
     * @return array|object|bool
     * @author shaowei
     */
    public static function upload ( $path, $contents )
    {
        new self();
        $name = self::getName ($path);
        dd($name);
//        $url = Qiniu::upload ($path, $contents);
//        $url = \Storage::disk('public')->put($name,$contents);
//        return $url;
        if ( self::$niu->put ($name, $contents) ) {
            return self::$niu->getUrl ($name);
            $data = [
                'url' => $name,
                'host_url' => $url,
                'postfix' => $type,
                'size' => $size,
            ];
            return $data;
        }
        return false;
    }


    /**
     * 文件名字生成
     * @param $path
     * @access public getName
     * @return string
     * @author shaowei
     */
    public static function getName ( $path )
    {
        return self::uuid() . '.jpg';
    }

    /**
     * UUID生成
     * @param string $prefix
     * @access public uuid
     * @return string
     * @author shaowei
     */
    public static function uuid ( $prefix = '' )
    {
        $chars = md5 (uniqid (mt_rand (), true));
        $uuid = substr ($chars, 0, 8) . '-';
        $uuid .= substr ($chars, 8, 4) . '-';
        $uuid .= substr ($chars, 12, 4) . '-';
        $uuid .= substr ($chars, 16, 4) . '-';
        $uuid .= substr ($chars, 20, 12);
        return $prefix . $uuid;
    }

    /**
     * 删除文件
     * @param $url
     * @access public delete
     * @return bool
     * @author shaowei
     */
    public static function delete ( $url )
    {
        new self();
        return self::$niu->delete ($url);
    }
}