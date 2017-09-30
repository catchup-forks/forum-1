<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use RecordsActivity;

    protected $appends = ['km_pace'];

    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attendees()
    {
        return $this->belongsToMany('App\User', 'workout_user');
    }

    public function getKmPaceAttribute()
    {
        if ($this->tempo == null) return __('Unspecified');

        $min = $this->tempo/60;
        $sec = $this->tempo - ($min * 60);

        if ($sec < 10) $sec .= '0' + $sec;

        return $min . ':' . $sec . '/km';
    }
}
