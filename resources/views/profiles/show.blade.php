@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h2>
                {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h2>
        </div>
        <div class="card">
            <div class="card-header">All Threads</div>
            <div class="card-body">
                @foreach($threads as $thread)

                    <article>
                        <div class="level">
                            <h4 class="flex">
                                <a href="{{$thread->path()}}">
                                    {{$thread->title}}
                                </a>
                            </h4>
                            <strong><a href="{{$thread->path()}}">{{$thread->replies_count}} comment(s)</a></strong>
                        </div>
                        <div>
                            {{$thread->body}}
                        </div>
                    </article>
                    <hr>

                @endforeach
            </div>
        </div>

        {{ $threads->links() }}
    </div>
@endsection
