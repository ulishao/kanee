<?php

namespace App\Http\Controllers;


use App\Models\Img;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class ImgController extends Controller
{
    public function index()
    {
        return Resource::collection( Img::where(['category_id'=>request()->get('category_id')])->paginate( 2 ) );
    }

    public function url( Request $request )
    {
        //使用图片头输出浏览器
        header( "Content-Type: image/jpeg;text/html; charset=utf-8" );
        $http = new Client();
        $a    = $http->get( $request->get( 'url' ) )->getBody()->getContents();
        echo $a;
    }

    public function sui()
    {
        $data = Img::pluck( 'id' )->toArray();

        $a        = array_rand( $data , 1 );
        $return   = [];
        $return[] = $data[$a];
        return Img::whereIn( 'id' , $return )->first();
        //$return;
    }
}
