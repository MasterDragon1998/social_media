<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Vote;

class VotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $votes = auth()->user()->votes;
        return view('votes.index')->with('votes', $votes);
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
    public function store(Request $request, $post_id)
    {
        //Validate
        $this->validate($request, [
                'vote' => 'required'
            ]);

        //Check Authorization
        if(!Auth::check()){
            return redirect('/posts/'.$post_id)->with('alert', 'You need to be loged in to vote');
        }

        //Check if user already voted on this post
        $userVote = auth()->user()->votes->where('post_id',$post_id);
        if(count($userVote) > 0){
            return $this->update($userVote[0]->id,$request->input('vote'));
        }

        //Create Vote
        $vote = new Vote();
        $vote->post_id = $post_id;
        $vote->user_id = Auth::id();
        $vote->isUpvote = $request->input('vote');
        $vote->save();

        //return redirect
        return redirect('/posts/'.$post_id)->with('success', 'Thank you for voting!');
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
    public function update($id,$vote)
    {
        //Receive Vote
        $voteModel = Vote::find($id);

        //Update Vote
        $voteModel->isUpvote = $vote;
        $voteModel->save();

        //Return redirect
        return redirect('/posts/'.$voteModel->post->id)->with('success', 'Thank you for voting!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
