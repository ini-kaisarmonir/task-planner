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
        $this->authorize('viewAny', Event::class);
        try {
            $events = $this->eventService->getEventsForUser(Auth::user());
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Could not fetch events. Please try again.']);
        }

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Event::class);

        $tasks = Task::all();
        return view('admin.events.create', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        $this->authorize('create', Event::class);

        try {
            $this->eventService->storeEvent($request->validated());

            return redirect()->route('event.index')
                ->with('success', 'Event created successfully!');
        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Could not create event. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->authorize('view', $event);
        $event->load('tasks');
        return view('admin.events.show', compact('event'));
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
        try {
            $data = $this->eventService->getCalendarEvents();
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not fetch calendar events.'], 500);
        }
    }
}
