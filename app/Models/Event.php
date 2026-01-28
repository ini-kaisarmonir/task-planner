<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function scopeForUser($query, User $user)
    {
        if ($user->isAdmin()) {
            return $query->with('tasks');
        }

        return $query
            ->whereHas('tasks', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['tasks' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }]);
    }
}
