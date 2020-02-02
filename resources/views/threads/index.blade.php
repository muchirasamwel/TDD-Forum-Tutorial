@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Forum Threads</div>
                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="card">
                                    <div class="card-header level">
                                        <a href="{{$thread->path()}}" class="flex">{{$thread->title}}</a>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
