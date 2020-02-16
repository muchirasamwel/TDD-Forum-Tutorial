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

//        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
//
//        $names=$matches[1];
//
//        foreach ($names as $name)
//        {
//            $user=User::whereName($name)->first();
//
//            if ($user){
//                $user->notify(new YouWereMentioned($reply));
//            }
//        }

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
        try {
            $this->validate(request(), ['body' => 'required|spam_free']);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply seems to be a spam.', 422
            );
        }
    }

}
