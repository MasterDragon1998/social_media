@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h2>Your Posts</h2>
                    @if(count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th>Created At</th>
                                <th>Edit</th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                    <td><a href="{{url('/posts/'.$post->id)}}">{{$post->title}}</a></td>
                                    <td>{{$post->created_at}}</td>
                                    <td><a href="{{ url('posts/'.$post->id.'/edit') }}" class="btn btn-secondary">Edit</a></td>
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
