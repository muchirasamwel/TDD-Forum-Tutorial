<?php

namespace App\Http\Controllers;
use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index($channel_slug = null,ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel_slug) {
            $channel_id = Channel::where('slug', $channel_slug)->first()->id;
            $threads->where('channel_id', $channel_id);
        }

        $threads = $threads->get();
        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function show($channel_id, Thread $thread)
    {

        return view('threads.show', compact('thread'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);
        return redirect($thread->path());
    }

}
