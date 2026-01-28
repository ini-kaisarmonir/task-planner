@extends('admin.layouts.app')

@section('title', 'Event Details')

@section('content')
@can('view-dashboard')
<div class="container mx-auto py-8">
    <div class="bg-white rounded shadow p-6 mb-6">
        <h1 class="text-2xl font-bold mb-2">{{ $event->title }}</h1>
        <p class="mb-1"><strong>Date:</strong> {{ $event->date?->format('Y-m-d') }}</p>
        <p class="mb-1"><strong>Description:</strong> {{ $event->description }}</p>
    </div>

    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Related Tasks</h2>
        @if($event->tasks && $event->tasks->count())
            <ul class="divide-y divide-gray-200">
                @foreach($event->tasks as $task)
                    <li class="py-3">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-medium">{{ $task->title }}</span>
                                <span class="ml-2 text-xs text-gray-500">({{ $task->status->name ?? $task->status }})</span>
                                <div class="text-sm text-gray-600">Due: {{ $task->due_date ?? $task->due_at }}</div>
                            </div>
                            <a href="{{ route('task.show', $task) }}" class="text-blue-600 hover:underline text-sm">View</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No tasks related to this event.</p>
        @endif
    </div>
</div>
@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection
