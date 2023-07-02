<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Presenters\ActivityPresenter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'changes' => 'array',
    ];

    public function project() :BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subject() :MorphTo
    {
        return $this->morphTo();
    }

    public function present()
    {
        return match($this->description) {
            'created' => 'You created a project',
            'updated' =>    "",
            'created_task' => 'You created a task , ' . "'{$this->subject->body}'",
            'completed_task' => 'You completed a task , ' . "'{$this->subject->body}'",
            'incompleted_task' => 'You uncompleted a task, ' . "'{$this->subject->body}'",
            'deleted_task' => 'You deleted a task',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
