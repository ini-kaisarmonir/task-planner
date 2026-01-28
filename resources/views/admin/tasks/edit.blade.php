@extends('admin.layouts.app')

@section('title', 'Edit Task')

@section('content')
@can('view-dashboard')
<div class=" mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-3xl font-bold mb-8 text-gray-800">Edit Task</h2>

    <form method="POST" action="{{ route('task.update', $task->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
            <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" type="text" id="title" name="title" placeholder="Enter task title" value="{{ old('title', $task->title) }}" required>
            @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
            <textarea class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" id="description" name="description" placeholder="Enter task description" rows="4">{{ old('description', $task->description) }}</textarea>
            @error('description')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="user_id">Assign User</label>
            <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror" id="user_id" name="user_id" required>
                <option value="">-- Select Employee --</option>
                @forelse($employees as $employee)
                <option value="{{ $employee->id }}" {{ old('user_id', $task->user_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->email }})</option>
                @empty
                <option value="" disabled>No employees available</option>
                @endforelse
            </select>
            @error('user_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="priority">Priority</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('priority') border-red-500 @enderror" id="priority" name="priority" required>
                    <option value="">-- Select Priority --</option>
                    @foreach(\App\Enums\Priority::labels() as $value => $label)
                    <option value="{{ $value }}" {{ old('priority', $task->priority->value) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
                @error('priority')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status {{ old('status', $task->status)}}</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" id="status" name="status" required>
                    <option value="">-- Select Status --</option>
                    @foreach(\App\Enums\Status::labels() as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $task->status->value) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>

                    @endforeach
                </select>
                @error('status')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="due_at">Due Date</label>
            <input class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('due_at') border-red-500 @enderror" type="datetime-local" id="due_at" name="due_at" value="{{ old('due_at', $task->due_at->format('Y-m-d\TH:i')) }}" required>
            @error('due_at')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-4">
            <button class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold" type="submit">Update Task</button>
            <a href="{{ route('task.index') }}" class="flex-1 bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition duration-200 font-semibold text-center">Cancel</a>
        </div>
    </form>
</div>
@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection