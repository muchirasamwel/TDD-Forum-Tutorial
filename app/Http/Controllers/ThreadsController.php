<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    public function index(){

        $threads=Thread::latest()->get();
        return view('threads.index',compact('threads'));
    }

    public function create(){
        return view('threads.create');
    }

    public function show($id){
        $thread=Thread::find($id);
        return view('threads.show',compact('thread'));
    }

    public function store(Request $request){
       $thread= Thread::create([
            'user_id'=>auth()->id(),
            'title'=>request('title'),
            'body'=>request('body')
        ]);
        return redirect($thread->path());
    }
}
