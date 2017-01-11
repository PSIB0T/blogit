<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id'];
    public function post()
    {
      return $this->belongsTo('App\Post', 'post_id'); //One like corresponds to one post
    }

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }
}
