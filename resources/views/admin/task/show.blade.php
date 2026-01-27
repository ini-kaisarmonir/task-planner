@extends('admin.layouts.app')

@section('title', 'View Task')

@section('content')
@can('view-dashboard')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Task Details</h2>
    <a href="{{ route('task.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200 font-semibold">Back to Tasks</a>
</div>

<div class="bg-white rounded-lg shadow-md p-8">
    <div class="grid grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Title</h3>
            <p class="text-lg text-gray-800">{{ $task->title }}</p>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Assigned To</h3>
            <p class="text-lg text-gray-800">{{ $task->assignee->name ?? 'Unassigned' }}</p>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-sm font-semibold text-gray-600 mb-2">Description</h3>
        <p class="text-gray-800 whitespace-pre-wrap">{{ $task->description ?? 'No description provided' }}</p>
    </div>

    <div class="grid grid-cols-3 gap-8 mb-8">
        <div>
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Priority</h3>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                @if($task->priority == 0) bg-green-100 text-green-800
                @elseif($task->priority == 1) bg-yellow-100 text-yellow-800
                @else bg-red-100 text-red-800
                @endif">
                {{ \App\Enums\Priority::labels()[$task->priority->value] }}
            </span>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Status</h3>
            <span class="px-3 py-1 rounded-full text-sm font-semibold
                @if($task->status == 0) bg-blue-100 text-blue-800
                @elseif($task->status == 1) bg-orange-100 text-orange-800
                @else bg-green-100 text-green-800
                @endif">
                {{ \App\Enums\Status::labels()[$task->status->value] }}
            </span>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Due Date</h3>
            <p class="text-gray-800">{{ \Carbon\Carbon::parse($task->due_at)->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Created At</h3>
            <p class="text-gray-800">{{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y H:i') }}</p>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Last Updated</h3>
            <p class="text-gray-800">{{ \Carbon\Carbon::parse($task->updated_at)->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <div class="flex gap-4 border-t pt-6">
        @can('update', $task)
        <a href="{{ route('task.edit', $task->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">Edit Task</a>
        @endcan
        @can('delete', $task)
        <form method="POST" action="{{ route('task.destroy', $task->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this task?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-200 font-semibold">Delete Task</button>
        </form>
        @endcan
        <a href="{{ route('task.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200 font-semibold">Back</a>
    </div>
</div>

@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection
