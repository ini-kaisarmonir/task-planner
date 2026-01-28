@extends('admin.layouts.app')

@section('title', 'Calendar')

@section('content')
@can('view-dashboard')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold">Calendar</h2>
    <div class="flex gap-2">
        <button id="view-day" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200 font-semibold">Day</button>
        <button id="view-week" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold">Week</button>
        <button id="view-month" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition duration-200 font-semibold">Month</button>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden p-4">
    <div id="calendar"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: {
                url: '{{ route("event.calendar.events") }}',
                failure: function() {
                    alert('Error fetching events');
                }
            },
            height: 'auto',
            contentHeight: 'auto',
            eventDisplay: 'block'
        });

        calendar.render();

        // View toggle buttons
        document.getElementById('view-day').addEventListener('click', function() {
            calendar.changeView('timeGridDay');
            updateButtonStates('day');
        });

        document.getElementById('view-week').addEventListener('click', function() {
            calendar.changeView('timeGridWeek');
            updateButtonStates('week');
        });

        document.getElementById('view-month').addEventListener('click', function() {
            calendar.changeView('dayGridMonth');
            updateButtonStates('month');
        });

        function updateButtonStates(active) {
            document.getElementById('view-day').classList.remove('bg-blue-500', 'hover:bg-blue-600');
            document.getElementById('view-day').classList.add('bg-gray-500', 'hover:bg-gray-600');
            document.getElementById('view-week').classList.remove('bg-blue-500', 'hover:bg-blue-600');
            document.getElementById('view-week').classList.add('bg-gray-500', 'hover:bg-gray-600');
            document.getElementById('view-month').classList.remove('bg-blue-500', 'hover:bg-blue-600');
            document.getElementById('view-month').classList.add('bg-gray-500', 'hover:bg-gray-600');

            if (active === 'day') {
                document.getElementById('view-day').classList.remove('bg-gray-500', 'hover:bg-gray-600');
                document.getElementById('view-day').classList.add('bg-blue-500', 'hover:bg-blue-600');
            } else if (active === 'week') {
                document.getElementById('view-week').classList.remove('bg-gray-500', 'hover:bg-gray-600');
                document.getElementById('view-week').classList.add('bg-blue-500', 'hover:bg-blue-600');
            } else if (active === 'month') {
                document.getElementById('view-month').classList.remove('bg-gray-500', 'hover:bg-gray-600');
                document.getElementById('view-month').classList.add('bg-blue-500', 'hover:bg-blue-600');
            }
        }
    });
</script>

@else
<p class="text-red-600">You are not authorized to view this dashboard.</p>
@endcan
@endsection