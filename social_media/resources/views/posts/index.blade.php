@extends('layouts.app')

@section('content')
	<h1>Posts</h1>
	@if(count($posts) > 0)
		@foreach($posts as $post)
			<div>
				<h2><a href="{{url('/posts/'.$post->id)}}">{{$post->title}}</a></h2>
				<small>Created at: {{$post->created_at}}</small>
			</div>
		@endforeach
		{{$posts->links()}}
	@else
		<h2>No Posts Found!</h2>
	@endif
@endsection