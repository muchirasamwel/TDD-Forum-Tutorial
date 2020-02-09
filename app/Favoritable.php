<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function foo\func;

trait Favoritable
{
    protected static function bootFavoritable(){
        static::deleting(function ($model){
                $model->favorites->each->delete();
            }
        );
    }

    public function favorites()
    {
        return $this->morphMany(Favourite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}
