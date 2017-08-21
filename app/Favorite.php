<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'user_id',
        'favorite_id',
        'favorite_type',
    ];

    public function favorited()
    {
        return $this->morphTo();
    }
}
