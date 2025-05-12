<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>Register Page</x-slot:header>

    <a href="/register/classroom/choose-faculty">Register Classroom</a>

    <a href="/register/course/choose-faculty">Register Course</a>

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
</x-layout>
