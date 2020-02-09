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
            <div class="card-header">All Activities</div>
            <div class="card-body">
                @forelse($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @if (view()->exists("profiles.activities.{$record->type}"))
                            @include ("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                            <br>
                    @endforeach
                    <hr>
                @empty
                    <p>No Activities Yet</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
