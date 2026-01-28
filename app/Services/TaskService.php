<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\Priority;
use App\Enums\Status;
use Exception;

class TaskService
{
public function getTasksForUser($user)
{
    if ($user->isAdmin()) {
        return Task::with('assignee')->latest()->get();
    }

    return Task::where('user_id', $user->id)->with('assignee')->latest()->get();
}
    public function storeTask(array $data): Task
    {
        DB::beginTransaction();

        try {
            $task = new Task();

            $task->title            = $data['title'];
            $task->description      = $data['description'] ?? null;
            $task->user_id          = $data['user_id'];
            $task->priority         = $data['priority'] ?? Priority::MEDIUM;
            $task->status           = $data['status'] ?? Status::PENDING;
            $task->due_at           = $data['due_at'];

            $task->save();

            DB::commit();

            return $task;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Task Creation Failed: " . $e->getMessage());

            throw $e;
        }
    }

    public function updateTask(Task $task, array $data): bool
    {
        return $task->update($data);
    }
}
