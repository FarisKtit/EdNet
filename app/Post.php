<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
      'poster_id',
      'user_wall_id',
      'content'
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }
}
