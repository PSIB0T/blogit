<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    public function posts()
    {
      return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }
}
