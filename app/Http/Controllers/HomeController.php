<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index ()
    {
        $d = \DB::table('demo')->limit(20)->get();
        return view('home', [
            'd' => $d
        ]);
    }
}
