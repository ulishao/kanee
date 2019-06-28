<?php

namespace App\Libs\ucloud;
require_once 'proxy.php';

class ucloud
{
    public function __construct ()
    {
    }

    public function put ( $key, $file )
    {

//存储空间名
        $bucket = "kanee-img";

        return UCloud_PutFile($bucket, $key, $file);
//        if ($err) {
//            echo "error: " . $err->ErrMsg . "\n";
//            echo "code: " . $err->Code . "\n";
//            exit;
//        }
//        echo "ETag: " . $data['ETag'] . "\n";
    }
}