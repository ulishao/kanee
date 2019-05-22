<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\Content;
use Illuminate\Http\Response;

class ContentController extends Controller
{
    public function store ()
    {
        $data = request ()->post ();
        $data[ 'urls' ] = json_encode (request ()->post ('urls'));
        return Content::create ($data);
    }

    public function index ()
    {
        $data = Content::with ('user', 'comment', 'comment.user')->orderByDesc ('created_at')->paginate (10);
        return new Response($data);
    }

    public function create ()
    {
        return Comment::create (request ()->post ());
    }

}
