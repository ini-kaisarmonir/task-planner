<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Enums\Role;
use App\Models\User;
use App\Http\Requests\EventRequest;
use App\Models\Task;
use App\Services\EventService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct(protected EventService $eventService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      //  $this->authorize('create', Event::class);

        $tasks = Task::all();
        return view('admin.events.create', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
      //  $this->authorize('create', Event::class);

       
            $this->eventService->storeEvent($request->validated());

            return redirect()->route('event.index')
                ->with('success', 'Event created successfully!');
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);

        return view('admin.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $employees = User::employees()->get();
        return view('admin.event.edit', compact('event', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
{
    $this->authorize('delete', $event);

    $event->delete();
    return redirect()
        ->route('event.index')
        ->with('success', 'Task deleted successfully.');
}

public function calendar()
    {
        return view('admin.events.calendar');
    }

    public function calendarEvents()
    {
        $events = Event::all();
        $tasks = Task::all();
        
        $formattedData = [];

        // Format actual Events
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

        return response()->json($formattedData);
    }
}
