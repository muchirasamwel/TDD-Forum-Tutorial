@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4><a href="#">{{$thread->creator->name}}</a> Posted {{$thread->title}}
                        </h4></div>
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
            @if(auth()->check())
                <div class="col-md-8">
                    <form method="POST" action="{{$thread->path().'/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="body" id="" cols="30" rows="10"
                                      placeholder="Comment ...." class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-light">Post</button>
                    </form>
                </div>
            @else
                <div class="col-md-8 text-center">
                    Please <a href="{{route('login')}}">Sign in</a> to participate
                </div>
            @endif
        </div>
    </div>
@endsection
