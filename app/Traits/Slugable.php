<?php

namespace App\Traits;

use App\Page;
use App\Thread;
use App\User;

trait Slugable
{
    protected $models = [
        Page::class,
        User::class,
        Thread::class,
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function checkModelSlugs($value)
    {
        foreach ($this->models as $model) {
            if ($model::whereSlug($slug = str_slug($value))->exists()) return true;
        }
        return false;
    }

    public function setSlugAttribute($value)
    {
        if ($this->checkModelSlugs($slug = str_slug($value))) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug)
    {
        $original = $slug;
        $count = 2;

        while ($this->checkModelSlugs($slug)) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}