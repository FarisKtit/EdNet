<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\User;

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
       try {
         $post = new Post();
         $post->poster_id = $request->visitor_id;
         $post->user_wall_id = $request->visited_id;
         $post->content = $request->content;
         $post->save();

         $visited_id = $request->visited_id;

         $user = User::findOrFail($visited_id);

         $posts = DB::select("SELECT u.name AS 'user_name', u.birthdate, p.created_at, o.name AS 'user_occupation', p.content FROM posts AS p
         INNER JOIN users AS u ON p.poster_id = u.id INNER JOIN occupations AS o ON u.occupation_id = o.id
         WHERE p.user_wall_id = ? ORDER BY p.id DESC", [$visited_id]);


         $html = view('snippets.dashboard.profile.user_profile_posts', compact('posts', 'user', 'visited_id', 'visitor_id'))->render();

         return response()->json(array('status'=>'success', 'html' => $html));
       } catch(Exception $e) {
         return response()->json(array('status'=>'error'));
       }

     }

}
