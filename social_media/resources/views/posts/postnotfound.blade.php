@extends('layouts.app')

@section('content')
	<center>
		<h1>Post Not Found</h1>
		<a class="btn btn-primary" href="{{ url('/posts') }}">Go Back</a>
	</center>
@endsection