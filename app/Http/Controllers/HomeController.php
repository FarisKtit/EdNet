<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
    public function index()
    {
        $posts = DB::select("SELECT p.id, u.name, p.content, p.created_at FROM posts AS p
        INNER JOIN users AS u ON p.user_id = u.id WHERE p.user_id IN (SELECT ur.requester_id FROM relationships_users
        AS ur WHERE ur.responder_id = ? AND ur.accepted = 1) OR p.user_id IN (SELECT ur.responder_id FROM relationships_users
        AS ur WHERE ur.requester_id = ? AND ur.accepted = 1) OR p.user_id = ? ORDER BY p.id DESC", [Auth::user()->id, Auth::user()->id, Auth::user()->id]);

        $user = Auth::user();
        return view('home', compact('user', 'posts'));
    }
}
