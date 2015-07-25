<?php namespace App\Services\Eloquent;

use App\Event;
use App;
use Auth;

trait HasEvents {

    /**
     * Define relation to App\Event
     *
     * @return void
     */
    public function events()
    {
        return $this->morphMany('App\Event', 'entity');
    }

    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function boot()
    {
        self::created([__CLASS__, 'insertCreateEvent']);
        self::updated([__CLASS__, 'insertUpdateEvent']);
    }

    /**
     * Insert new record to events table. Called after a model related to App\Event has been created.
     * @param  Illuminate\Database\Eloquent\Model $entity Entity related to the event
     * @return void
     */
    protected static function insertCreateEvent($entity)
    {
        $event = new Event([
            'user_id' => App::runningInConsole() ? 1 : Auth::user()->id,
            'action' => 'create',
        ]);

        $entity->events()->save($event);
    }

    /**
     * Insert new record to events table. Called after a model related to App\Event has been created.
     * @param  Illuminate\Database\Eloquent\Model $entity Entity related to the event
     * @return void
     */
    protected static function insertUpdateEvent($entity)
    {
        foreach ($entity->watchedFieldInEvent as $fieldName) {
            $fieldValueFrom = $entity->getOriginal($fieldName);
            $fieldValueTo = $entity->$fieldName;

            if ($fieldValueFrom != $fieldValueTo) {
                $event = new Event([
                    'user_id' => App::runningInConsole() ? 1 : Auth::user()->id,
                    'action' => 'update',
                    'field_name' => $fieldName,
                    'field_value_from' => $fieldValueFrom,
                    'field_value_to' => $fieldValueTo,
                ]);

                $entity->events()->save($event);
            }
        }
    }
}