@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h2>Your Posts</h2>
                    <a class="btn btn-secondary" href="{{ url('/posts/create') }}">Create Post</a>
                    <a class="btn btn-secondary" href="{{ url('/votes') }}">Your Votes</a>
                    @if(count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th>Created At</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                    <td><a href="{{url('/posts/'.$post->id)}}">{{$post->title}}</a></td>
                                    <td>{{$post->created_at}}</td>
                                    <td><a href="{{ url('posts/'.$post->id.'/edit') }}" class="btn btn-secondary">Edit</a></td>
                                    <td>
                                        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                                            {{Form::hidden('_method','DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <h3>No Posts Found!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
