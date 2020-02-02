<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use RecordsActivity;
    protected $guarded = [];

    public function favorited()
    {
        return $this->morphTo();
    }
}
