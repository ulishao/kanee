<?php

namespace App\Http\Controllers;


use App\Models\Content;

class ContentController extends Controller
{
    public function store ()
    {
        $data = request ()->post ();
        $data[ 'urls' ] = json_encode (request ()->post ('urls'));
        return Content::create ($data);
    }

}
