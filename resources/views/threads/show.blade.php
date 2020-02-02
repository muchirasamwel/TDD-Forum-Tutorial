@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4><a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> Posted: {{$thread->title}}
                        </h4></div>
                    <div class="card-body">
                        <div>
                            {{$thread->body}}
                        </div>
                    </div>
                </div>
                <hr>
                @foreach($replies as $reply)
                    @include('threads.replies')
                @endforeach
                {{$replies->links()}}
                @if(auth()->check())

                    <form method="POST" action="{{$thread->path().'/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <textarea name="body" id="" cols="30" rows="10"
                                      placeholder="Comment ...." class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary">Post</button>
                    </form>

                @else
                    <div class="text-center">
                        Please <a href="{{route('login')}}">Sign in</a> to participate
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div>
                            Thread was published {{$thread->created_at->diffForHumans()}}
                            by <a href="#">{{$thread->creator->name}}</a>, and
                            currently has {{$thread->replies_count}} Comment(s)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
