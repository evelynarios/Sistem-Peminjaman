@extends('layouts.main')

@section('container')
    <div class="container my-5">
        <h1>Jadwal Fasilitas Saya</h1>
        <div id='calendar'></div>
    </div>
@endsection

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: '{{ route('schedules.list') }}',
                    failure: function() {
                        alert('Error fetching events!');
                    }
                }
            });
            calendar.render();
        });
    </script>
@endpush
