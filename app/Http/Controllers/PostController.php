<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\Tag;
use App\User;
use App\Comment;

use Illuminate\Http\Request;

use Illuminate\Session\Store;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getIndex(){
      $posts = Post::orderBy('created_at', 'desc')->with('tags')->paginate(2);
      return view('blog.index', ['posts' => $posts]);
    }
    public function getAdminIndex()
    {
      $posts = User::find(Auth::user()->id)->posts;
      // $posts = Post::orderBy('title', 'asc')->get();
      return view('admin.index', ['posts' => $posts]);
    }

    public function getPost($id)
    {   //Eager loading
        $post = Post::where('id', '=', $id)->with('likes', 'comments')->first();
        // Alternate way
        // $post = Post::find($id);
        return view('blog.post', ['post' => $post]);
    }

    public function getAdminCreate()
    {
        $tags = Tag::all();
        return view('admin.create', ['tags' => $tags]);
    }

    public function getAdminEdit($id)
    {
        $post = Post::find($id);
        $tags = Tag::all();
        return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' => $tags]);
    }

    public function postAdminCreate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = new Post([
          'title' => $request->input('title'),
          'content' => $request->input('content')
        ]);
        $user = User::find(Auth::user()->id);
        $user->posts()->save($post);

        //Alternative
        // $post->title = $request->input('title');
        // $post->content = $request->input('content');

        // $post->save();
        $post->tags()->attach($request->input('tags') == null? []:$request->input('tags') );

        return redirect()->route('admin.index')->with('info', 'Post created, Title is: ' . $request->input('title'));
    }

    public function postAdminUpdate(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = Post::find($request->input('id'));
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        // Bad approach
        // $post->tags()->detach();
        // $post->tags()->attach($request->input('tags') == null? []:$request->input('tags') );
        //Better approach
        $post->tags()->sync($request->input('tags') == null? []:$request->input('tags') );
        return redirect()->route('admin.index')->with('info', 'Post edited, new Title is: ' . $request->input('title'));
    }
    public function getAdminDelete($id)
    {
      $post = Post::find($id);
      $post->likes()->delete();
      $post->comments()->delete();
      $post->tags()->detach();
      $post->delete();
      return redirect()->route('admin.index')->with('info', 'Post Deleted!');
    }
    public function getLikePost($id)
    {
      $post = Post::where('id', $id)->first();
      $user_id = Auth::id();
      if($likeCond = Like::where('user_id', '=', $user_id)->where('post_id', '=', $id)->first()){
        $likeCond->delete();
        return redirect()->back();
      }
      $like = new Like([
        'user_id' => $user_id
      ]);
      $post->likes()->save($like);
      return redirect()->back();
    }

    public function postCommentPost(Request $request)
    {
      $this->validate($request, [
        'comment' => 'required'
      ]);
      $user_id = Auth::id();
      $post = Post::where('id', $request->input('id'))->first();
      $comment = new Comment([
        'user_id' =>  $user_id,
        'comment' => $request->input('comment')
      ]);
      $post->comments()->save($comment);
      return redirect()->back();
    }
}
