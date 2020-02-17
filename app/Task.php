<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected  $casts = [
        'completed' => 'boolean'
    ];
    protected $touches = ['project'];


    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('uncompleted_task');
    }

    public function project()
    {
       return $this->belongsTo(Project::class);
    }

    public function path()
    {
       return "/projects/{$this->project->id}/tasks/{$this->id}";
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * the activity feed for the project
     * @param $description
     */

    public function recordActivity($description){

        $this->activity()->create([
            'project_id' => $this->project->id,
            'description'=> $description,
        ]);

    }

}
