@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@can('view-dashboard')
<div class=" mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Create New Event</h2>

    <form action="{{ route('event.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-2">Event Name</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="date" class="block text-sm font-medium mb-2">Date</label>
            <input type="date" id="date" name="date" class="w-full px-4 py-2 border rounded" required>
            @error('date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="start_time" class="block text-sm font-medium mb-2">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="w-full px-4 py-2 border rounded" required>
            @error('start_time')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="end_time" class="block text-sm font-medium mb-2">End Time</label>
            <input type="time" id="end_time" name="end_time" class="w-full px-4 py-2 border rounded" required>
            @error('end_time')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label for="tasks" class="block text-sm font-medium mb-2">Select Tasks</label>
            <select id="tasks" name="tasks[]" multiple class="w-full px-4 py-2 border rounded">
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                @endforeach
            </select>
            @error('tasks')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Create Event</button>
            <a href="{{ route('event.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</a>
        </div>
    </form>
</div>
@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection