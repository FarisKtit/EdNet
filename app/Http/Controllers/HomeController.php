<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        $posts = [];

        $user_id = Auth::user()->id;

        $per_page = $request->input("per_page", 5);
        $page = $request->input("page", 1);
        $skip = ($page * $per_page) - $per_page;

        if($skip < 0) {
          $skip = 0;
        }

        $posts = DB::select("
        SELECT *
        FROM (
          SELECT p.id, u.name as poster, uu.name as receiver, p.content, p.created_at FROM posts as p INNER JOIN users as u ON p.poster_id = u.id INNER JOIN users as uu ON p.user_wall_id = uu.id
          WHERE p.poster_id IN (
                                  SELECT requester_id as user_id FROM relationships_users WHERE responder_id = ? AND accepted = 1
                                  UNION ALL
                                  SELECT responder_id as user_id FROM relationships_users WHERE requester_id = ? AND accepted = 1
                                )
          UNION ALL
          SELECT p.id, u.name as poster, uu.name as receiver, p.content, p.created_at FROM posts as p INNER JOIN users as u ON p.poster_id = u.id INNER JOIN users as uu ON p.user_wall_id = uu.id
          WHERE p.user_wall_id IN (
                                  SELECT requester_id as user_id FROM relationships_users WHERE responder_id = ? AND accepted = 1
                                  UNION ALL
                                  SELECT responder_id as user_id FROM relationships_users WHERE requester_id = ? AND accepted = 1
                                )
          UNION ALL
          SELECT p.id, u.name as poster, uu.name as receiver, p.content, p.created_at FROM posts as p INNER JOIN users as u ON p.poster_id = u.id INNER JOIN users as uu ON p.user_wall_id = uu.id
          WHERE p.poster_id = ?
          UNION
          SELECT p.id, u.name as poster, uu.name as receiver, p.content, p.created_at FROM posts as p INNER JOIN users as u ON p.poster_id = u.id INNER JOIN users as uu ON p.user_wall_id = uu.id
          WHERE p.user_wall_id = ?
        ) A
        ORDER BY id DESC
        ", [$user_id, $user_id, $user_id, $user_id, $user_id, $user_id]);

        $total_count = count($posts);

        $posts = new LengthAwarePaginator(array_slice($posts, $skip, $per_page, true), $total_count, $per_page, $page, ['path' => '/home']);

        return view('home', compact('user', 'posts'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_home_wall_posts(Request $request)
    {


      return $posts;
    }
}
