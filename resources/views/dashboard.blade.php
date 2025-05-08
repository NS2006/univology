<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>Welcome back, {{ auth()->user()->name }}</x-slot:header>

    {{-- Admin --}}
    @admin
    <h1>Report</h1>
    @forelse ($reports as $report)
        @if ($report->user->role->name == 'student')
            <p>{{ $report->user->student->student_id }} - {{ $report->user->name }}: <b>{{ $report->description }}</b></p>
        @else
            <p>{{ $report->user->lecturer->lecturer_id }} - {{ $report->user->name }}: <b>{{ $report->description }}</b></p>
        @endif
    @empty
    <h3>There's no report</h3>
    <h3>You can relax</h3>
    @endforelse


    <h1>Today's Activity Log</h1>
    @forelse ($logs as $log)
        @if ($log->user->role->name == 'student')
            <h4>{{ $log->user->student->student_id }} - {{ $log->user->name }} {{ $log->type }} at {{ $log->created_at }}</h4>
        @else
            <h4>{{ $log->user->lecturer->lecturer_id }} - {{ $log->user->name }} {{ $log->type }} at {{ $log->created_at }}</h4>
        @endif
    @empty
        <h4>There is no activity logs for today</h4>
    @endforelse


    @endadmin

    {{-- Lecturer --}}
    @lecturer
    <h1>Lecturer Page</h1>
    @endlecturer

    {{-- Student --}}
    @student
    <h1>Student Page</h1>
    @endstudent
</x-layout>
