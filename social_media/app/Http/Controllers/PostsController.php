<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Request
        $this->validate($request, [
                'title' => 'required',
                'body' => 'required'
            ]);

        //Check if loged in
        if(!Auth::check()){
            return redirect('/')->with('alert', 'You need to log in to create a post')->with('alert', 'you need to be loged in to post a Post');
        }

        //Create Post
        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = Auth::id();
        $post->save();

        //Sends the user to /post page
        return redirect('/posts')->with('success', 'Post '.$post->title.' Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$post = Post::find($id)){
            return view('posts.postnotfound');
        }
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Find Post
        if(!$post = Post::find($id)){
            return redirect('posts/postnotfound');
        }

        //Authorize edit
        if(Auth::id() !== $post->user_id){
            return redirect('/posts/'.$post->id)->with('alert', 'You can only edit your own posts');
        }

        //Returns view
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validate form inputs
        $this->validate($request, [
                'title' => 'required',
                'body' => 'required'
            ]);

        //Find Post
        $post = Post::find($id);

        //Authorize
        if(Auth::id() != $post->user_id){
            return redirect('/posts/'.$post->id)->with('alert', 'You can only edit your own posts!');
        }

        //Update Post
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts/'.$post->id)->with('success', 'Post Edited Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Receive Post
        $post = Post::find($id);
        $votes = $post->votes;

        //Authorize
        if(Auth::id() !== $post->user_id){
            return redirect('/posts/'.$post->id)->with('alert', 'You can only delete your own posts!');
        }

        //Destroy post
        $post->delete();
        foreach($votes as $vote){
            $vote->delete();
        }

        //return redirect
        return redirect('/dashboard')->with('success', 'Post Deleted!');
    }
}
