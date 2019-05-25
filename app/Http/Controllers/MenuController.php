<?php

namespace App\Http\Controllers;


use App\Models\Img;
use App\Models\User;
use DB;
use EasyWeChat\Factory;
use Illuminate\Http\Resources\Json\Resource;

class MenuController extends Controller
{
    public function index ()
    {
        return DB::table ( 'menus' )->where ( [ 'status' => 1 ] )->get ();
    }
}
