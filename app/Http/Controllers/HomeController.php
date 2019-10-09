<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index ()
    {
        if ( request('name') ) {
            $d = \DB::table('demo')->where('name', 'like', '%' . request('name') . '%')->get();
        } else {
            $d = \DB::table('demo')->limit(20)->get();
        }
        return view('home', [
            'd' => $d,
            'name' => request('name')
        ]);
    }
}
