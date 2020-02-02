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
                @foreach ($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach ($activity as $record)
                        @include ("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
