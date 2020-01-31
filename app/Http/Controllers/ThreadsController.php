<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    /**
     * Shows all Threads
     *
     **/
    public function index(){

        $threads=Thread::latest()->get();
        return view('threads.index',compact('threads'));
    }

    /**
     * Shows a specific Thread
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $thread=Thread::find($id);
        return view('threads.show',compact('thread'));
    }
}
