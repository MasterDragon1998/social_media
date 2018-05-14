@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-header">
			<h1>Comments</h1>
		</div>
		<div class="card-body">
			@if(count($comments) > 0)
				<table class="table table-striped">
					<tr>
						<th>Post</th>
						<th>Comment</th>
						<th>Created at</th>
						<th>Delete</th>
					</tr>
					@foreach($comments as $comment)
						<tr>
							<td><a href="{{url('/posts/'.$comment->post->id)}}">{{$comment->post->title}}</a></td>
							<td>{{$comment->body}}</td>
							<td>{{$comment->created_at}}</td>
							<td>
								{{Form::open(['action' => ['CommentsController@destroy', $comment->id]])}}
									{{Form::hidden('_method', 'DELETE')}}
									{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
								{{Form::close()}}
							</td>
						</tr>
					@endforeach
				</table>
			@else
				<h2>You don't have comments</h2>
			@endif
		</div>
	</div>
@endsection