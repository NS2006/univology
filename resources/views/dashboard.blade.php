<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>Welcome back, {{ auth()->user()->name }}</x-slot:header>

    {{-- Show current user's name --}}
    <h1>Welcome back, {{ auth()->user()->name }}</h1>

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

    <h1>Faculty</h1>
    <ul>
    @foreach ($faculties as $faculty)
            <li>{{ $faculty->name }}</li>
    @endforeach
    </ul>

    <form action="/register/faculty" method="POST">
        @csrf

        <h3>Register Faculty</h3>
        <label for="name">Name</label>
        <input type="text" id="name" name="name">

        <br>
        <button type="submit">Submit</button>
    </form>

    <br><br>

    <h1>Student</h1>
    <ul>
    @foreach ($students as $student)
            <li>{{$student->student_id}} - {{ $student->user->name }}</li>
    @endforeach
    </ul>

    <br>
    <h1>Lecturer</h1>
    <ul>
    @foreach ($lecturers as $lecturer)
            <li>{{$lecturer->lecturer_id}} - {{ $lecturer->user->name }}</li>
    @endforeach
    </ul>
    <form action="/register/user" method="POST">
        @csrf

        <h3>Register User</h3>
        <label for="name">Name</label>
        <input type="text" id="name" name="name">

        <br>
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="placeholder">input role</option>
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select>

        <br>
        <label for="faculty">Faculty</label>
        <select name="faculty" id="faculty">
            <option value="placeholder">input faculty</option>
            @foreach ($faculties as $faculty)
                <option value="{{$faculty->id}}">{{$faculty->name}}</option>
            @endforeach
        </select>

        <br>
        <button type="submit">Submit</button>
    </form>

    <br><br>
    <form action="/register/course" method="POST">
        @csrf

        <label for="course">course</label>
        <select name="course" id="course">
            <option value="placeholder">input course</option>
            @foreach ($courses as $course)
                <option value="{{$course->id}}">{{$course->name}}</option>
            @endforeach
        </select>
    </form>
    @endadmin

    {{-- Lecturer --}}
    @lecturer
    <h1>Lecturer Page</h1>


    <form action="/user/report" method="POST">
        @csrf
        <h1>Report</h1>
        <label for="description">Do you want to report something?</label><br>
        <input type="text" name="description" id="description">
        <button type="submit">Submit</button>
    </form>
    @endlecturer

    {{-- Student --}}
    @student
    <h1>Student Page</h1>


    {{-- footer --}}
    <form action="/user/report" method="POST">
        @csrf
        <h1>Report</h1>
        <label for="description">Do you want to report something?</label><br>
        <input type="text" name="description" id="description">
        <button type="submit">Submit</button>
    </form>
    @endstudent
</x-layout>
