@extends('layouts.app')

@section('content')
	<a href="{{url('/posts')}}" class="btn btn-secondary">Go Back</a>
	<div class="card">
		<div class="card-header">
			<h2>{{$post->title}}</h2>
		</div>
		<div class="card-body">
			{!!$post->body!!}
		</div>
		<div class="card-footer">
			<small>Created at: {{$post->created_at}}</small>
			<br />
			<small>Created by: {{$post->user->name}}</small>
			<br />
			{!!Form::open(['action' => ['VotesController@store', $post->id], 'method' => 'POST'])!!}
				{{Form::button('Upvotes: '.count($post->votes->where('isUpvote',true)), ['name' => 'vote', 'value' => 1,'type' => 'submit', 'class' => 'btn btn-success'])}}
				{{Form::button('Downvotes: '.count($post->votes->where('isUpvote',false)), ['name' => 'vote', 'value' => 0,'type' => 'submit', 'class' => 'btn btn-danger'])}}
			{!!Form::close()!!}
			@if(Auth::id() === $post->user_id || Auth::user()->isAdmin)
				<br />
				<a href="{{ url('/posts/'.$post->id.'/edit') }}" class="btn btn-secondary float-left">Edit</a>
				{!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                    {{Form::hidden('_method','DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}
			@endif
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h2>Comments</h2>
		</div>
		<div class="card-body">
			@if(count($post->comments) > 0)
				<?php
					$comments = $post->comments->sortByDesc(function($comment){
						return $comment->created_at;
					})
				?>
				@foreach($comments as $comment)
					<div class="card">
						<div class="card-header">
							{{$comment->user->name}}
						</div>
						<div class="card-body">
							{!!nl2br($comment->body)!!}
						</div>
						<div class="card-footer">
							Created at: {{$comment->created_at}}
						</div>
					</div>
				@endforeach
			@else
				<h3>No comments found</h3>
			@endif
			<div class="card">
				<div class="card-header">
					{{Auth::user()->name}}
				</div>
				<div class="card-body">
					{{Form::open(['action' => 'CommentsController@store', 'method' => 'POST'])}}
						<div class="form-group">
							{{Form::label('body', 'Comment')}}
							{{Form::textarea('body', '', ['class' => 'form-control', 'style' => 'height:60px;resize:none;'])}}
						</div>
						{{Form::hidden('post_id', $post->id)}}
						{{Form::submit('Comment!', ['class' => 'btn btn-success'])}}
					{{Form::close()}}
				</div>
			</div>
		</div>
	</div>
@endsection