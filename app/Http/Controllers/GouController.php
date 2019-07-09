<?php

namespace App\Http\Controllers;


use App\Models\Gous;

class GouController extends Controller
{
    public function create()
    {
        if ( Gous::where ([ 'source_url'=>request ()->post ('source_url') ])->first () ) {

        } else {
            return Gous::create (request ()->post ());
        }
    }

    public function index()
    {
        return Gous::paginate (40);
    }
}
