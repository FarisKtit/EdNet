<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCommentLike extends Model
{
  protected $fillable = [
    'post_comment_id',
    'user_id'
  ];

  public function post_comment() {
    return $this->belongsTo('App\PostComment');
  }
}
