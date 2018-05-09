@extends('layouts.app')

@section('content')
	<a href="{{url('/posts')}}" class="btn btn-secondary">Go Back</a>
	<div class="card">
		<div class="card-header">
			<h2>{{$post->title}}</h2>
		</div>
		<div class="card-body">
			{{$post->body}}
		</div>
		<div class="card-footer">
			<small>Created at: {{$post->created_at}}</small>
			<br />
			<small>Created by: {{$post->user->name}}</small>
			@if(Auth::id() === $post->user_id)
				<br />
				<a href="{{ url('/posts/'.$post->id.'/edit') }}" class="btn btn-secondary">Edit</a>
			@endif
		</div>
	</div>
@endsection