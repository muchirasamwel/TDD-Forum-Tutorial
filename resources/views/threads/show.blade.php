@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </span>

                            @if (Auth::check())
                                @can ('update', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            @endif

                        </div>
                        <div class="card-body">
                            <div>
                                {{$thread->body}}
                            </div>
                        </div>
                    </div>
                    <hr>

                    <replies @added="repliesCount++"
                             @removed="repliesCount--"></replies>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <p>
                                    Thread was published {{$thread->created_at->diffForHumans()}}
                                    by <a href="#">{{$thread->creator->name}}</a>, and
                                    currently
                                    has <span
                                        v-text="repliesCount"></span> {{\Illuminate\Support\Str::plural('Comment',$thread->replies_count)}}
                                </p>
                                <p>
                                    <subscribe-button
                                        :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
