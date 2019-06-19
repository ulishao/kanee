<?php

namespace App\Http\Controllers;


use App\Models\Bizhi;
use App\Models\Img;
use App\Models\ImgLabel;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

class ImgController extends Controller
{
    public function index()
    {
        return Resource::collection (Img::when (\request ()->get ('category_id'), function ( $query ) {
            return $query->where (['category_id' => request ()->get ('category_id')]);
        })
            ->where ('source_url', 'like', '%2019%')
            ->when(\request ()->get ('serach'),function ( $q){
                $q->where('title','like','%'.\request ()->get ('serach').'%');
            }
            )->orderBydesc ( 'created_at' )
            ->paginate( 2 ) );
    }

    public function bizhi ()
    {
        return \DB::select ("SELECT * FROM `bizhis` ORDER BY RAND() limit 4");
        return Bizhi::orderBydesc ('created_at')
            ->paginate (4);
    }

    public function list ()
    {
        $ids = [3, 4];
        if ( !empty(request ()->get ('category_id')) ) {
            $ids = explode (",", request ()->get ('category_id'));
            $ids = array_filter ($ids);
//            $ids[] = 3;
        }
        if ( \request ()->get ('name') ) {
            $id = ImgLabel::where (['label' => \request ()->get ('name')])->pluck ('img_id')->toArray ();
            $query = Img::whereIn ('id', $id);
        } else {
            $query = Img::whereIn ('category_id', $ids);
        }
//        if(\request ()->get ('category_id'))

        $data = $query->orderBydesc ('created_at')
            ->paginate (2);
        return Resource::collection ($data);
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
        $data = Img::whereIn ('category_id', $ids)->where ('imgs', 'like', '%2019%')->pluck ('id')->toArray ();
        $a        = array_rand( $data , 1 );
        return Img::where (['id' => $data[ $a ]])->with ('imgLabel')->select (['id', 'imgs', 'title'])->first ();
        //$return;
    }
}
