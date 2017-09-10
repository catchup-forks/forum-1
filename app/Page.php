<?php

namespace App;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Slugable;

    protected $guarded = [];
}
