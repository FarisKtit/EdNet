<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Occupation;
use App\Post;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
    * Return authenticated user' profile.
    *
    */
    public function index()
    {
      $user = Auth::user();
      $user_id = $user->id;
      $visited_id = $user_id;
      // $posts = $user->posts;
      // $posts = $posts->sortByDesc('id');

      $user = DB::select("SELECT u.name, u.birthdate, u.about, u.profile_image_filename, o.name AS 'occupation' FROM users AS u
      INNER JOIN occupations AS o ON u.occupation_id = o.id WHERE u.id = ?", [$user_id]);
      $user = $user[0];

      $posts = DB::table('posts')->join('users', 'posts.poster_id', '=', 'users.id')->join('occupations', 'users.occupation_id', '=', 'occupations.id')
      ->select('users.name as user_name', 'users.birthdate', 'posts.created_at', 'occupations.name as user_occupation', 'posts.content', 'users.profile_image_thumbnail_filename')
      ->where('posts.user_wall_id', '=', $visited_id)
      ->orderByRaw('posts.id DESC')
      ->paginate(5);

      return view('dashboard.profile.user_profile', compact('user', 'posts', 'visited_id'));
    }

    public function edit_profile()
    {
      $user = Auth::user();
      $occupations = Occupation::all();
      return view('dashboard.profile.user_profile_edit', compact('user', 'occupations'));
    }

    public function update_profile(Request $request)
    {
      $user = Auth::user();
      $user->name = $request->name;
      $user->birthdate = $request->birthdate;
      $user->about = $request->about;
      $user->occupation_id = $request->occupation;
      $user->save();

      return redirect()->back()->with('success', 'Successfully updated your profile information.');
    }

    /**
     * Visit other user profiles.
     *
     *
     */
    public function view_user_profile($id)
    {
        $visited_id = $id;
        $visitor_id = Auth::user()->id;

        $user = User::findOrFail($id);

        $posts = DB::table('posts')->join('users', 'posts.poster_id', '=', 'users.id')->join('occupations', 'users.occupation_id', '=', 'occupations.id')
        ->select('users.name as user_name', 'users.birthdate', 'posts.created_at', 'occupations.name as user_occupation', 'posts.content', 'users.profile_image_thumbnail_filename')
        ->where('posts.user_wall_id', '=', $visited_id)
        ->orderByRaw('posts.id DESC')
        ->paginate(5);


        $res = DB::select("SELECT id FROM relationships_users WHERE ((requester_id = ? AND responder_id = ?) OR (requester_id = ? AND responder_id = ?)) AND accepted = 1",
        [$visited_id, $visitor_id, $visitor_id, $visited_id]);

        $user = DB::select("SELECT u.name, u.birthdate, u.about, u.profile_image_filename, o.name AS 'occupation' FROM users AS u
        INNER JOIN occupations AS o ON u.occupation_id = o.id WHERE u.id = ?", [$visited_id]);
        $user = $user[0];

        $count = count($res);

        if($count == 0) {
          $res = DB::select("SELECT id FROM relationships_users WHERE ((requester_id = ? AND responder_id = ?) OR (requester_id = ? AND responder_id = ?))",
          [$visited_id, $visitor_id, $visitor_id, $visited_id]);

          $count = count($res);
          return view('dashboard.profile.user_profile_relationship_not_formed', compact('user', 'count', 'visited_id'));
        }



        return view('dashboard.profile.user_profile_relationship_formed', compact('user', 'posts', 'visitor_id', 'visited_id'));

    }
}
