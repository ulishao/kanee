<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index ()
    {
        if ( request('name') ) {
            $d = \DB::table('demo')->where('name', 'like', '%' . request('name') . '%')->get();
            $count = \DB::table('demo')->where('name', 'like', '%' . request('name') . '%')->count();
        } else {
            $d = \DB::table('demo')->limit(20)->get();
            $count = \DB::table('demo')->count();
        }

        return view('home', [
            'd' => $d,
            'name' => request('name'),
            'count' => $count
        ]);
    }
}
