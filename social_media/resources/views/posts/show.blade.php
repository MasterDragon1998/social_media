@extends('layouts.app')

@section('content')
	<a href="{{url('/posts')}}" class="btn btn-default">Go Back</a>
	<div>
		<h2>{{$post->title}}</h2>
		<div>
			{{$post->body}}
		</div>
		<small>Created at: {{$post->created_at}} Created by: {{$post->user->name}}</small>
	</div>
@endsection