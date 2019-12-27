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
      return view('dashboard.profile.user_profile', compact('user', 'posts'));
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
      $user->save();
      $occupation_id = $request->occupation;
      $user_id = $user->id;
      DB::update('UPDATE occupations_users SET occupation_id = ? WHERE user_id = ?', [$occupation_id, $user_id]);
      return redirect()->back()->with('success', 'Successfully updated your profile information.');
    }
}
