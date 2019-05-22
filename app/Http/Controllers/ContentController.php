<?php

namespace App\Http\Controllers;


use App\Models\Content;

class ContentController extends Controller
{
    public function create ()
    {
        return Content::create (request ()->post ());
    }

}
