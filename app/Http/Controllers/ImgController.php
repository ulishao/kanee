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
        return Resource::collection( Img::where( [ 'category_id' => request()->get( 'category_id' ) ] )
            ->where( 'imgs' , 'like' , '%2019%' )
            ->when(\request ()->get ('serach'),function ($q){
                $q->where('title','like','%'.\request ()->get ('serach').'%');
            })
            ->paginate( 2 ) );
    }

    public function show()
    {
        return Img::where( 'id' , \request()->get( 'id' ) )->first();
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
        $ids = [1];
        if(!empty(request ()->get ('ids'))){
            $ids = explode (",",request ()->get ('ids'));
            $ids = array_filter  ($ids);
        }
        $data = Img::whereIn ('category_id', $ids)->get ()->toArray ();
        $a        = array_rand( $data , 1 );
        return $data[ $a ];
        //$return;
    }
}
