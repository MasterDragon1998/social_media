@extends('layouts.app')

@section('content')
	<h1>Posts</h1>
	@if(count($posts) > 0)
		@foreach($posts as $post)
			<div style="margin:5px;" class="card">
				<div class="card-header">
					<h2><a href="{{url('/posts/'.$post->id)}}">{{$post->title}}</a></h2>
				</div>
				<div class="card-footer">
					<small>Created at: {{$post->created_at}}</small>
					<small class="float-right">Created by: {{$post->user->name}}</small>
				</div>
			</div>
		@endforeach
		{{$posts->links()}}
	@else
		<h2>No Posts Found!</h2>
	@endif
@endsection