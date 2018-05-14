<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Auth::user()->comments->sortByDesc(function($comment){
            return $comment->created_at;
        });
        return view('comments.index')->with('comments', $comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate
        $this->validate($request, [
                'body' => 'required',
                'post_id' => 'required'
            ]);

        //Create comment
        $comment = new Comment();
        $comment->post_id = $request->input('post_id');
        $comment->user_id = Auth::id();
        $comment->body = $request->input('body');
        $comment->save();

        //Redirect
        return redirect('/posts/'.$request->input('post_id'))->with('success', 'Comment placed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Retrieve comment
        $comment = Comment::findOrFail($id);
        $post_id = $comment->post->id;

        //Authorize
        if(Auth::id() !== $comment->user_id){
            return redirect('/posts/'.$post_id)->with('alert', 'You can only delete your own comments');
        }

        //Destroy comment
        $comment->delete();

        //redirect
        return redirect('/posts/'.$post_id)->with('success', 'Comment Deleted');
    }
}
