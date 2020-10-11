<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Content;
use App\Models\Plus;
use Illuminate\Http\Response;

class PlusController extends Controller
{
    public function index()
    {
          return Plus::query()->orderBy('source_url')->paginate();
    }

}
