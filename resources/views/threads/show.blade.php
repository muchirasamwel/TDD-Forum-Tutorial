@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header"><h4>{{$thread->title}}</h4></div>
                    <div class="card-body">
                        <div>
                            {{$thread->body}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
