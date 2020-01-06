<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;

class LikeController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Store a like on a post by a user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function add_like_to_post(Request $request)
  {
    try {
      $like = new Like();
      $like->user_id = Auth::user()->id;
      $like->post_id = $request->post_id;
      $like->save();
      $likes = Like::where('post_id', '=', $request->post_id)->get();
      $count = $likes->count();
      return response()->json(array('status' => 'success', 'count' => $count));
    } catch(Exception $e) {
      return response()->json(array('status' => 'error'));
    }
  }

  /**
   * Remove a like on a post by a user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function remove_like_from_post(Request $request)
  {
    try {
      $num_rows_affected = Like::where([['user_id', '=', Auth::user()->id], ['post_id','=', $request->post_id]])->delete();
      if($num_rows_affected > 0) {
        $likes = Like::where('post_id', '=', $request->post_id)->get();
        $count = $likes->count();
        return response()->json(array('status' => 'success', 'count' => $count));
      }
      return response()->json(array('status' => 'error'));
    } catch(Exception $e) {
      return response()->json(array('status' => 'error'));
    }
  }


}
