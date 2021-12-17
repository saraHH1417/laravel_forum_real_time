<?php

namespace App\Http\Controllers;

use App\Events\LikeEvent;
use App\Models\Like;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{


    public function __construct()
    {
        $this->middleware('jwt' , ['except' => ['index' , 'show']]);
    }


    public function likeIt(Reply $reply)
    {

        $reply->likes()->create([
            'user_id' => auth()->id()
        ]);
        broadcast(new LikeEvent($reply->id , 1))->toOthers();
        return response()->json([
            'message' => 'Reply liked successfully',
            'status' => Response::HTTP_ACCEPTED
        ], Response::HTTP_ACCEPTED);
    }

    public function unLikeIt(Reply $reply)
    {
        $reply->likes()->where('user_id' , auth()->id())->first()->delete();
        broadcast(new LikeEvent($reply->id , 0))->toOthers();
    }
}
