<?php

namespace App\Http\Controllers;


use App\Models\Img;
use Illuminate\Http\Resources\Json\Resource;

class ImgController extends Controller
{
    public function index()
    {
        return Resource::collection( Img::paginate( 10 ) );
    }
}
