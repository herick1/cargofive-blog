@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('content')
@if ( !$posts->count() )
There is no post till now. Login and write a new post now!!!
@else
<div class="">
  @foreach( $posts as $post )
  <div class="list-group">
    <div class="list-group-item">
      <h3><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a>
        @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
        @if($post->status == 'published')
          <a href="{{ url('edit/'.$post->slug)}}"><button class="btn" style="float: right">Edit Post</button></a>
        @elseif($post->status == 'draft')
          <a href="{{ url('edit/'.$post->slug)}}"><button class="btn" style="float: right">Edit Draft</button></a>
        @else
          <a href="{{ url('edit/'.$post->slug)}}"><button class="btn" style="float: right">Edit Inactive post</button></a>
        @endif
        @endif
      </h3>
      <p>Created at: {{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></p>
      <p>Last updated at: {{ $post->updated_at->format('M d,Y \a\t h:i a') }}</p>
      <strong>{{ $post->status }}</strong>
    </div>
    <div class="list-group-item">
      <article>
        {!! Str::limit($post->body, $limit = 1500, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
      </article>
    </div>
  </div>
  @endforeach
  {!! $posts->render() !!}
</div>
@endif
@endsection
