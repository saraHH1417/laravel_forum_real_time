<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Question;
use App\Models\Reply;
use App\Notifications\NewReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt' , ['except' => ['index' , 'show']]);
    }
    /**
     * Display a listing of the resource.
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    public function index(Question $question)
    {
        return ReplyResource::collection($question->replies);
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
    public function store(Question $question, Request $request)
    {
        $reply = $question->replies()->create($request->all());
        $user = $question->user;
        if($reply->user_id !== $question->user_id){
            $user->notify(new NewReplyNotification($reply));
        }

        return response(['reply' => new ReplyResource($reply)] , Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question $question;
     * @param \App\Models\Reply $reply
     * @return ReplyResource
     */

    public function show(Question $question, Reply $reply)
    {
        return new ReplyResource($reply);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Question $question, Reply $reply , Request $request)
    {
        $reply->update($request->all());
        return response('Updated' , Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Reply $reply)
    {
        $reply->delete();

        return response(null , Response::HTTP_NO_CONTENT);
    }
}
