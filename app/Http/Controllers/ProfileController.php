<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Occupation;
use App\Post;

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
      $posts = $user->posts;
      $posts = $posts->sortByDesc('id');

      $occupation = DB::select("SELECT o.name FROM occupations AS o INNER JOIN users
      AS u ON o.id = u.occupation_id WHERE u.id = ?", [Auth::user()->id]);
      $occupation = $occupation[0]->name;
      return view('dashboard.profile.user_profile', compact('user', 'posts', 'occupation'));
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
}
