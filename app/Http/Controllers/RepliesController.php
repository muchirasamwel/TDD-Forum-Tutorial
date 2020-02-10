<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index');
    }
    public function index($channel_id,Thread $thread){
        return $thread->replies()->paginate(10);
    }
    public function store($channel_id,Thread $thread){
        $this->validate(request(),[
            'body'=>'required'
            ]);
        $reply = $thread->addReply([
            'body'=>request('body'),
            'user_id'=>auth()->id()
        ]);
        //dd($reply);
        if(request()->expectsJson())
        {
            return $reply->load('owner');
        }
        return back()->with('flash', 'Your reply has been left.');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required']);

        $reply->update(request(['body']));
    }
}
