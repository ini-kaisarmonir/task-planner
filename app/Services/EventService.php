<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\Priority;
use App\Enums\Status;
use Exception;

class EventService
{
public function getTasksForUser($user)
{
    if ($user->isAdmin()) {
        return Event::all();
    }

    return Event::all();
}
    public function storeEvent(array $data): Event
    {
        DB::beginTransaction();

        try {
            $event = new Event();

            $event->name            = $data['name'];
            $event->date      = $data['date'] ?? null;
            $event->start_time          = $data['start_time'] ?? null;
            $event->end_time         = $data['end_time'] ?? null;
            
            

            $event->save();

            if (!empty($data['tasks']) && is_array($data['tasks'])) {
                Task::whereIn('id', $data['tasks'])->update(['event_id' => $event->id]);
            }

            DB::commit();

            return $event;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Event Creation Failed: " . $e->getMessage());

            throw $e;
        }
    }

    public function updateEvent(Event $event, array $data): bool
    {
        DB::beginTransaction();

        try {
            $updated = $event->update($data);

            if (array_key_exists('tasks', $data)) {
                $newTaskIds = is_array($data['tasks']) ? $data['tasks'] : [];

                Task::where('event_id', $event->id)
                    ->whereNotIn('id', $newTaskIds)
                    ->update(['event_id' => null]);

                if (!empty($newTaskIds)) {
                    Task::whereIn('id', $newTaskIds)->update(['event_id' => $event->id]);
                }
            }

            DB::commit();

            return $updated;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Event Update Failed: " . $e->getMessage());
            throw $e;
        }
    }
    public function getCalendarEvents()
    {
         $events = Event::all();
        $tasks = Task::all();
        
        $formattedData = [];

        // Format Events
        foreach ($events as $event) {
            $formattedData[] = [
                'title' => $event->name,
                'date' => $event->date,
                'start' => \Carbon\Carbon::parse($event->date)->format('Y-m-d').'T'.\Carbon\Carbon::parse($event->start_time)->format('H:i:s'),
                'end'   => \Carbon\Carbon::parse($event->date)->format('Y-m-d').'T'.\Carbon\Carbon::parse($event->end_time)->format('H:i:s'),
                'color' => '#3788d8',
                'extendedProps' => ['type' => 'event']
            ];
        }

        // Format Tasks as calendar entries
        foreach ($tasks as $task) {
            $formattedData[] = [
                'title' => 'TASK: ' . $task->title,
                'start' => $task->due_at,
                'allDay' => false,
                'color' => '#e67e22',
                'extendedProps' => ['type' => 'task']
            ];
        }

        return $formattedData;
    }
}
