<?php

namespace App\Traits;

use App\Favorite;

trait Favorable {

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        // Prevent from favorite same reply twice.
        if ($this->isFavorited()) return;

        $this->favorites()->create($attributes);
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}