<div class="card">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#">
                    {{$reply->owner->name}}</a> Said
                {{$reply->created_at->diffForHumans()}}
            </h5>
            <div>

                <form action="/replies/{{$reply->id}}/favorites" method="POST">
                   {{csrf_field()}}
                    <button type="submit" class="btn btn-secondary" {{$reply->isFavorited() ? 'disabled':''}}>
                        {{$reply->favorites()->count()}} Favorite(s)
                    </button>
                </form>
            </div>
        </div>


    </div>
    <div class="card-body">

        <div>
            {{$reply->body}}
        </div>
    </div>
</div>
<br>
