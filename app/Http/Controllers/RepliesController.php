<?php

namespace App\Http\Controllers;

use App\Http\Forms\CreatePostRequest;
use App\Inspections\Spam;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channel_id, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($channel_id, Thread $thread, CreatePostRequest $form)
    {
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return $reply->load('owner');

    }

    public function destroy(Reply $reply)
    {
        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back();
    }

    public function update(Reply $reply)
    {
        $this->validate(request(), ['body' => 'required|spam_free']);

        $reply->update(request(['body']));

    }

}
