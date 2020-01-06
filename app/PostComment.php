<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
  protected $fillable = [
    'post_id',
    'user_id',
    'content'
  ];

  public function user() {
    return $this->belongsTo('App\User');
  }

  public function post() {
    return $this->belongsTo('App\Post');
  }

  public function post_comment_replies() {
    return $this->hasMany('App\PostCommentReply');
  }
}
