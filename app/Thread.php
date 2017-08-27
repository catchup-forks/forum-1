<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->activity()->delete();
            $thread->replies->each->delete();
        });
    }

    public function path()
    {
        return '/threads/' . $this->channel->name . '/' . $this->id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        $this->subscriptions->filter(function ($subscriber) use ($reply) {
            return $subscriber->user_id != $reply->user_id;
        })->each->notify($reply);
/*
        each(function($subscription) use ($reply) {
            $subscription->user->notify(new ThreadWasUpdated($this, $reply));
        });*/

        foreach ($this->subscriptions as $subscription) {
            if ($subscription->user_id != $reply->user_id) {
            }
        }

        return $reply;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id(),
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        return $this->subscriptions()->delete([
            'user_id' => $userId ?: auth()->id(),
        ]);
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }
}
