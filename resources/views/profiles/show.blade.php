@extends('layouts.app')

@section('content')
    <div class="container col-md-8 offset-2">
        <div class="page-header">
            <h2>
                {{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h2>
        </div>
        <div class="card">
            <div class="card-header">All Threads</div>
            <div class="card-body">
                @foreach ($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @include ("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach
                @endforeach
                @foreach($threads as $thread)
                    <article>
                        <div class="card-header level">
                            <h4 class="flex">
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                            </h4>
                            <strong><a href="{{$thread->path()}}">
                                    {{$thread->replies_count}}
                                    {{\Illuminate\Support\Str::plural('Comment',$thread->replies_count)}}
                                </a></strong>
                        </div>
                        <div class="card-body">
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
