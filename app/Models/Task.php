<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean',
    ];


    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function activity() :MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    // project apth
    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete() :void
    {
        $this->update(['completed' => true]);

        $this->saveActivity('completed_task');
    }

    public function incomplete() :void
    {
        $this->update(['completed' => false]);

        $this->saveActivity('incompleted_task');
    }

    public function saveActivity(string $description) :void
    {
        $this->activity()->create([
            'project_id' => $this->project->id,
            'description' => $description,
            'user_id' => auth()->id(),
        ]);
    }

}
