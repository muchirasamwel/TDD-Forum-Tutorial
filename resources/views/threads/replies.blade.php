<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}...
                </h5>
                @if(\Illuminate\Support\Facades\Auth::check())
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endif
            </div>

        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="edit" id="" cols="0" rows="3" class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else>
                {{$reply->body}}
            </div>
            @can ('update', $reply)
                <div class="card-footer level">
                    <button class="btn btn-xs mr-2 btn-primary" @click="editing=true">Edit</button>
                    <button class="btn btn-xs btn-danger mr-1" @click="destroy">Delete</button>
                </div>
            @endcan
        </div>
        <br>
    </div>
</reply>
