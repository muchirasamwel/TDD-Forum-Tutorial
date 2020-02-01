<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
//    public function getKeyName()
//    {
//        return 'slug';
//    }

    public function threads(){
        return $this->hasMany(Thread::class);
    }
}
