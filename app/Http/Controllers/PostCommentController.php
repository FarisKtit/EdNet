<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PostComment;
use App\PostCommentLike;

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

      $comments = PostComment::with(['user', 'post_comment_likes', 'post'])->where('post_id', '=', $post_id)->orderBy('id', 'DESC')->get();

      $count = count($comments);

      $html = view('snippets.dashboard.profile.user_profile_post_comments', compact('comments'))->render();
      return response()->json(array('status' => 'success', 'comments' => $comments, 'html' => $html, 'count' => $count));
    } catch(Exception $e) {
      return response()->json(array('status' => 'error'));
    }
  }

  /**
   * Delete comments from a post.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function delete_comment_from_post(Request $request)
  {
    try {
      $num_rows_affected = PostComment::where([['id', '=', $request->post_comment_id], ['user_id', '=', Auth::user()->id]])->delete();
      if($num_rows_affected) {
        return response()->json(array('status' => 'success'));
      }

      return response()->json(array('status' => 'error'));
    } catch(Exception $e) {
      return response()->json(array('status' => 'error'));
    }
  }
}
