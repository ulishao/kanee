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

    public function kan ()
    {
        return \DB::table ('contents')->where (['id' => request ()->get ('id')])->increment ('kan_num', 1, ['kan_num' => \DB::raw ('`kan_num`+1')]);
    }
    public function show ()
    {
        return Content::where ('id', request ()->get ('id'))->with ([
            'user',
            'comment',
            'comment.user'
        ])->first ();
    }

    public function index ()
    {
        $data = Content::with ([
            'user',
            'comment',
            'comment.user'
        ])->where(['user_id' => request()->get('openid')])->orderByDesc('created_at')->paginate(10);
        return new Response($data);
    }

    public function create ()
    {
        return Comment::create (request ()->post ());
    }

}
