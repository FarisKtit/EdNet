<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    protected $fillable = [
      'name'
    ];

    public function users()
    {
      return $this->belongsToMany('App\User', 'occupations_users');
    }
}
