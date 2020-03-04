<?php

namespace App\Http\Controllers\H5;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index ()
    {
        $goods[ 'cates' ] = '149,562';
        $couponData[ 'limitgoodcateids' ] = '560';
        $cates = explode(',', $goods[ 'cates' ]);
        $cates[] = 11;
        $array = explode(',', $couponData[ 'limitgoodcateids' ]);
        dd(count(array_intersect($cates, $array)) > 0);

        return view('home.index');
    }
}
