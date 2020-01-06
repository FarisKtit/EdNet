<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PostComment;

class PostCommentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Add new comment to post.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function add_comment_to_post(Request $request)
  {
    try {
      $comment = new PostComment();
      $comment->user_id = Auth::user()->id;
      $comment->post_id = $request->post_id;
      $comment->content = $request->content;
      $comment->save();

      if($request->ajax()) {
        return response()->json(array('status' => 'success'));
      }

    } catch(Exception $e) {
      return response()->json(array('status' => 'error'));
    }

  }


  /**
   * Get all comments for a post.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function get_all_comments_for_post(Request $request)
  {
    try {
      $post_id = $request->post_id;
      $comments = PostComment::with(['user', 'post' => function($query) use($post_id) {
        $query->where('id', '=', $post_id);
      }])->get();
      return response()->json(array('status' => 'success', 'comments' => $comments));
    } catch(Exception $e) {
      return response()->json(array('status' => 'error'));
    }
  }
}
