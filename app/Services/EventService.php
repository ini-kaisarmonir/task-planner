<?php

namespace App\Services;

use Exception;
use App\Models\Task;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventService
{
    public function getEventsForUser($user)
    {
        if ($user->isAdmin()) {
            $events = Event::all();
        } else {
            $events = Event::whereHas('tasks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        }

        return $events;
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

    public function getCalendarEvents()
    {
        $events = Event::forUser(Auth::user())
            ->latest()
            ->get();

        $tasks = $events
            ->pluck('tasks')
            ->flatten()
            ->values();

        $formattedData = [];

        // Format Events
        foreach ($events as $event) {
            $formattedData[] = [
                'title' => 'EVENT: ' . $event->name,
                'date' => $event->date,
                'start' => \Carbon\Carbon::parse($event->date)->format('Y-m-d') . 'T' . \Carbon\Carbon::parse($event->start_time)->format('H:i:s'),
                'end'   => \Carbon\Carbon::parse($event->date)->format('Y-m-d') . 'T' . \Carbon\Carbon::parse($event->end_time)->format('H:i:s'),
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
