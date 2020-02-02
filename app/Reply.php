<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;
    protected $with = ['owner', 'favorites'];
    protected $guarded=[];

    public function owner()
    {
     return $this->belongsTo(User::class,'user_id');
    }
}
