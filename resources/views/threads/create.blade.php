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
                            <div>
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" placeholder="title">
                            </div>
                            <div>
                                <label>Body</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control" >

                                </textarea>
                                <br>
                                <input type="submit" class="btn btn-primary" value="Publish">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
