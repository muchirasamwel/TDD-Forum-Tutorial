@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Forum Threads</div>
                    <div class="card-body">
                        @forelse($threads as $thread)
                            <article>
                                <div class="card">
                                    <div class="card-header level">
                                        <a href="{{$thread->path()}}" class="flex">
                                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                                <strong>
                                                    {{ $thread->title }}
                                                </strong>
                                            @else
                                                {{ $thread->title }}
                                            @endif
                                        </a>
                                        <div>
                                           {{$thread->replies_count}} {{Str::plural('Comment',$thread->replies_count)}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            {{$thread->body}}
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <br>
                        @empty
                            <p>No Threads Available for this Channel</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
