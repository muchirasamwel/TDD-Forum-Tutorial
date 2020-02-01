@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4><a href="#">{{$thread->creator->name}}</a> Posted {{$thread->title}}</h4></div>
                    <div class="card-body">
                        <div>
                            {{$thread->body}}
                        </div>
                    </div>
                </div>
                <hr>
                @foreach($thread->replies as $reply)
                   @include('threads.replies')
                @endforeach
            </div>
        </div>
    </div>
@endsection
