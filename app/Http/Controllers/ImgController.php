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
        $http = new Client();
        return $http->get( $request->get( 'url' ) );
    }
}
