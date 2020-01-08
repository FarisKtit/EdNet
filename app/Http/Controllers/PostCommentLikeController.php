<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PostCommentLike;


class PostCommentLikeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Store a like on a post comment by a user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function add_like_to_post_comment(Request $request) {
     try {
       $post_comment_like = new PostCommentLike();
       $post_comment_like->user_id = Auth::user()->id;
       $post_comment_like->post_comment_id = $request->post_comment_id;
       $post_comment_like->save();
       $post_comment_likes = PostCommentLike::where('post_comment_id', '=', $request->post_comment_id)->get();
       $count = count($post_comment_likes);

       return response()->json(array('status' => 'success', 'count' => $count));
     } catch(Exception $e) {
       return response()->json(array('status' => 'error'));
     }
   }

   /**
    * Remove a like on a post comment by a user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function remove_like_from_post_comment(Request $request) {
     try {
       $num_rows_affected = PostCommentLike::where([['post_comment_id', '=', $request->post_comment_id], ['user_id', '=', Auth::user()->id]])->delete();
       if($num_rows_affected) {
         $post_comment_likes = PostCommentLike::where('post_comment_id', '=', $request->post_comment_id)->get();
         $count = count($post_comment_likes);

         return response()->json(array('status' => 'success', 'count' => $count));
       }
       return response()->json(array('status' => 'error'));

     } catch(Exception $e) {
       return response()->json(array('status' => 'error'));
     }
   }

}
