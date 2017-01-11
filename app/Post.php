<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Post extends Model{
    use SoftDeletes;

    protected $fillable = ['title', 'content'];
    protected $dates = ['deleted_at'];

    public function likes(){
      return $this->hasMany('App\Like', 'post_id'); // One post has may likes
    }

    public function user(){
      return $this->belongsTo('App\User', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment', 'post_id');
    }

    public function tags(){
      //Format => (Model_name, pivot_table_name, first_col, second_col)
      // Laravel will take default values if the latter 3 args are not specified
      return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id')->withTimestamps();
    }

    public function setTitleAttribute($value)
    {
      $this->attributes['title'] = strtolower($value);
    }

    public function getTitleAttribute($value)
    {
      return strtoupper($value);
    }

}
