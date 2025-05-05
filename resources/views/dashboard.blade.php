<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Univology | Dashboard</title>

    {{-- tailwind --}}
    {{-- @vite('resources/css/app.css') --}}
</head>
<body>
    {{-- Testing --}}
    {{-- <h1 class="text-3xl font-bold underline">
    Hello world!
    </h1> --}}


    {{-- navbar --}}
    <h3>{{ auth()->user()->name }}</h3>

    {{-- <form action="/changepassword" method="POST">
        @csrf
    </form> --}}

    <form action="/logout" met="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    {{-- Show current user's name --}}
    <h1>Welcome back, {{ auth()->user()->name }}</h1>

    {{-- Admin --}}
    @admin
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
    @endadmin

    {{-- Lecturer --}}
    @lecturer
    <h1>Lecturer Page</h1>
    @endlecturer

    {{-- Student --}}
    @student
    <h1>Student Page</h1>
    @endstudent
</body>
</html>
