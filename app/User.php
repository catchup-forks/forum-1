<?php

namespace App;

use App\Traits\Slugable;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Slugable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
        'gender',
        'facebook_token',
        'google_token',
        'phone',
        'latitude',
        'longitude',
        'slug',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'facebook_token'
    ];

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_user');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    public function getAvatarPathAttribute($value)
    {
        if (strpos($value, 'http')) {
            return $value;
        }

        if ($value) $value = 'storage/'.$value;

        return asset($value ?: 'images/avatars/default.jpg');
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf('user.%s.visited.thread.%s', $this->id, $thread->id);
    }
}
