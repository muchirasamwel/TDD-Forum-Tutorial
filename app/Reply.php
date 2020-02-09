<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;
    protected $with = ['owner', 'favorites'];
    protected $guarded=[];
    protected $appends = ['favoritesCount', 'isFavorited'];

    public function owner()
    {
     return $this->belongsTo(User::class,'user_id');
    }
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
