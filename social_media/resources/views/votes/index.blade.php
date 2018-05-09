@extends('layouts.app')

@section('content')
	<h1>Votes</h1>
	@if(count($votes) > 0)
		<table class="table table-striped">
			<tr>
				<th>Post Title</th>
				<th>Vote</th>
			</tr>
			@foreach($votes as $vote)
				<tr>
					<td><a href="{{ url('/posts/'.$vote->post->id) }}">{{$vote->post->title}}</a></td>
					<td>
						@if($vote->isUpvote)
							<span class="text-success">Upvote</span>
						@else
							<span class="text-danger">Downvote</span>
						@endif
					</td>
				</tr>
			@endforeach
		</table>
	@else
		<h2>No votes found</h2>
	@endif
@endsection