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



         return response()->json(array('status'=>'success'));
       } catch(Exception $e) {
         return response()->json(array('status'=>'error'));
       }

     }

     public function get_user_posts(Request $request)
     {
       try {
         $visited_id = $request->visited_id;
         $user = User::findOrFail($visited_id);
         $posts = DB::table('posts')->join('users', 'posts.poster_id', '=', 'users.id')->join('occupations', 'users.occupation_id', '=', 'occupations.id')
         ->select('users.name as user_name', 'users.birthdate', 'posts.created_at', 'occupations.name as user_occupation', 'posts.content', 'users.profile_image_thumbnail_filename')
         ->where('posts.user_wall_id', '=', $visited_id)
         ->orderByRaw('posts.id DESC')
         ->paginate(5);

         $html = view('snippets.dashboard.profile.user_profile_posts', compact('posts', 'user', 'visited_id'))->render();

         return response()->json(array('status'=>'success', 'html' => $html, 'visited_id' => $visited_id));
       } catch(Exception $e) {
         return response()->json(array('status'=>'error'));
       }

     }

}
