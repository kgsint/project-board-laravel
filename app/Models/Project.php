<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public array $old = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks() :HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function addTask(string $body)
    {
        return $this->tasks()->create(['body' => $body]);
    }

    public function activity() :HasMany
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function saveActivity(string $description)
    {
        $project = ['title' => $this->title, 'description' => $this->description, 'notes' => $this->notes]; // without created_at and updated_at

        $attributes = [
            'description' => $description,
            'user_id' => $this->user->id
        ];

        if($this->wasChanged()) {
            $attributes['changes'] = [
                'before' => array_diff($this->old, $project),
                'after' => array_diff($project, $this->old)
            ];
        }

        $this->activity()->create($attributes);
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members');
    }
}
