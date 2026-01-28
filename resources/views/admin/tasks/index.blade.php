@extends('admin.layouts.app')

@section('title', 'Tasks')

@section('content')
@can('view-dashboard')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Tasks</h2>
    @can('create', App\Models\Task::class)
    <a href="{{ route('task.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">+ Create Task</a>
    @endcan
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($tasks->count() > 0)
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Assigned To</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Priority</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Due Date</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($tasks as $task)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm text-gray-800">{{ $task->title }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $task->assignee->name ?? 'Unassigned' }}</td>
                <td class="px-6 py-4 text-sm">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($task->priority == 0) bg-green-100 text-green-800
                        @elseif($task->priority == 1) bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                      {{ \App\Enums\Priority::labels()[$task->priority->value] }}

                    </span>
                </td>
                <td class="px-6 py-4 text-sm">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($task->status == 0) bg-blue-100 text-blue-800
                        @elseif($task->status == 1) bg-orange-100 text-orange-800
                        @else bg-green-100 text-green-800
                        @endif">
                        {{ \App\Enums\Status::labels()[$task->status->value] ?? 'Unknown' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($task->due_at)->format('M d, Y H:i') }}</td>
                <td class="px-6 py-4 text-sm flex gap-2">
                    @can('view', $task)
                    <a href="{{ route('task.show', $task->id) }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 transition duration-200 text-xs font-semibold">View</a>
                    @endcan
                    @can('update', $task)
                    <a href="{{ route('task.edit', $task->id) }}" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 transition duration-200 text-xs font-semibold">Edit</a>
                    @endcan
                    @can('delete', $task)
                    <form method="POST" action="{{ route('task.destroy', $task->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 transition duration-200 text-xs font-semibold">Delete</button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="p-6 text-center">
        <p class="text-gray-500 mb-4">No tasks found.</p>
        @can('create', App\Models\Task::class)
        <a href="{{ route('task.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">Create First Task</a>
        @endcan
    </div>
    @endif
</div>

@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection