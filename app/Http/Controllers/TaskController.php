<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Enums\Role;
use App\Models\User;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->taskService->getTasksForUser(Auth::user());
    
        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $employees = User::employees()->get();
        return view('admin.tasks.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);

        try {
            $this->taskService->storeTask($request->validated());

            return redirect()->route('task.index')
                ->with('success', 'Task created successfully!');
        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Could not create task. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $employees = User::employees()->get();
        return view('admin.tasks.edit', compact('task', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        try {
            $this->taskService->updateTask($task, $request->validated());

            return redirect()->route('task.index')
                ->with('success', 'Task updated successfully!');
        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'Could not update task. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
{
    $this->authorize('delete', $task);

    $task->delete();

    return redirect()
        ->route('task.index')
        ->with('success', 'Task deleted successfully.');
}

}
