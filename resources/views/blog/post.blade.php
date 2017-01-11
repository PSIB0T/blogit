@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p class="quote">{{ $post->title }}</p>
        </div>
    </div>
    @if(!Auth::guest())
    <div class="row">
        <div class="col-md-12">
            <p>{{ count($post->likes) }} Likes | <a href="{{route('blog.post.like', ['id' => $post->id])}}">Like</a></p>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $post->content }}</h3>
        </div>
    </div>
    @if(!Auth::guest())
    <div class="row">
        <div class="col-md-12">
            <h2>{{ count($post->comments) }} Comments </h2>
            @foreach($post->comments as $comment)
              <p> {{ $comment->comment }}</p>
              <p>{{ $comment->user->name }}</p>
              <br>

            @endforeach
        </div>
        <form action="{{route('blog.post.comment')}}" method="post">
          <div class="form-group">
            <label for="comment">Comment</label>
            <input type="text" class="form-control" id="comment" name="comment">
          </div>
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $post->id }}">
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    @endif
@endsection
