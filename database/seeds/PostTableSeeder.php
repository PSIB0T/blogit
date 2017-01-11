<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $post = new \App\Post([
        'title' => 'Learning Laravel',
        'content' => 'This blog post will get you right on track with laravel',
        'user_id' => '1'
      ]);
      $post->save();
      $post = new \App\Post([
        'title' => 'Some title',
        'content' => 'Some other content',
        'user_id' => '1'
      ]);
      $post->save();
    }
}
