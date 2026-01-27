@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@can('view-dashboard')
<h2 class="text-2xl font-bold mb-4">My Tasks</h2>

<div class="bg-white rounded shadow divide-y">
    <div class="p-4">Task A</div>
    <div class="p-4">Task B</div>
    <div class="p-4">Task C</div>
</div>
@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection