<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Post;

class PostController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Store a newly created post for user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
       $post = new Post();
       $post->user_id = Auth::user()->id;
       $post->content = $request->post;
       $post->save();
       return redirect()->back()->with('success', 'Post successfully created.');

     }
}
