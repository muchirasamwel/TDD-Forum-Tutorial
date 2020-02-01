@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Create a new thread</div>
                    <div class="card-body">
                        <form action="/threads" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Choose a Channel</label>
                                <select name="channel_id" id="" class="form-control" required>
                                    <option value=""> Choose a channel </option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{ old('$channel->id') == $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" placeholder="title" required
                                       value="{{old('title')}}">
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control" required>
                                    {{old('body')}}
                                </textarea>
                                <br>
                                <input type="submit" class="btn btn-primary" value="Publish">
                                <div class="form-group mt-2">
                                    @if(count($errors))
                                        <ul class="alert alert-danger">
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
