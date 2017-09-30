<?php namespace App\Traits;

use App\Activity;
use Illuminate\Support\Facades\Log;

trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            Log::info('Tried record activity, but user was not logged in.');
            return;
        }

        foreach (static::getRecordEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function($model) {
            $model->activity()->delete();
        });
    }

    public static function getRecordEvents()
    {
        return ['created', 'updated'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return $event . '_' . $type;
    }
}