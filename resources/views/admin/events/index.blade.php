@extends('admin.layouts.app')

@section('title', 'Events')

@section('content')
@can('view-dashboard')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Events</h2>
    @can('create', App\Models\Task::class)
    <a href="{{ route('event.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">+ Create Event</a>
    @endcan
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($events->count() > 0)
    <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Start Time</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">End Time</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $event->name }}</td>
                            <td class="px-6 py-4">{{ $event->date }}</td>
                            <td class="px-6 py-4">{{ $event->start_time }}</td>
                            <td class="px-6 py-4">{{ $event->end_time }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('event.show', $event->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">View</a>
                                <a href="{{ route('event.edit', $event->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    @else
    <div class="p-6 text-center">
        <p class="text-gray-500 mb-4">No events found.</p>
        @can('create', App\Models\Task::class)
        <a href="{{ route('event.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">Create First Event</a>
        @endcan
    </div>
    @endif
</div>

@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection