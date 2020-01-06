<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCommentReply extends Model
{
  protected $fillable = [
    'post_id',
    'user_id',
    'content'
  ];

  public function post_comment() {
    return $this->belongsTo('App\PostComment');
  }
}
