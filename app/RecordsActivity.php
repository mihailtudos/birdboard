<?php


namespace App;


use Illuminate\Support\Arr;


trait RecordsActivity
{
    /**
     *
     * Project's old attributes
     * @var array
     */

    public $oldAttributes = [];

    /**
     * Boot the trait
     */

    public static function bootRecordsActivity()
    {

        foreach (self::recordableEvents() as $event){
            static::$event(function ($model) use ($event){
                $model->recordActivity($model->activityDescription($event)); //uses this convention created_task
            });
        }
        if ($event === 'updated' or 'updated_task') {
            static::updating(function ($model){
                $model->oldAttributes = $model->getOriginal();
            });
        }
    }

    /**
     * Get description of activity
     *
     * @param $description
     * @return string
     */

    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this)); //created/update or deleted and the name of the model ex: updated_task
    }

    /**
     * Fetches the model events that should trigger the activity
     * @return array
     */

    protected static function recordableEvents(): array
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;

        } else {
            return ['created', 'updated', 'deleted'];
        }
    }


    /**
     * Record activities for a project
     *
     * @param $description
     */

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
        ]);
    }


    /**
     * Fetches the changes to the model
     * @return array/null
     */

    protected function activityChanges()
    {
        if ($this->wasChanged()){
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at'),
            ];
        }
    }

    /**
     * The activity feed for the project
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

}
