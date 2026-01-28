<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Priority;
use App\Enums\Status;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'priority',
        'status',
        'due_date',
    ];

    protected $casts = [
        'priority' => Priority::class,
        'status' => Status::class,
        'due_at' => 'datetime',
    ];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
