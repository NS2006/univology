<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>My Courses</x-slot:header>

    <x-search-bar route="/courses" placeholder="Search courses..."></x-search-bar>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6 mt-4">
        @student
        @foreach ($enrollments as $enrollment)
            <x-course-card :enrollment="$enrollment"></x-course-card>
        @endforeach
        @endstudent

        @lecturer
        @foreach ($classrooms as $classroom)
            <x-course-card :classroom="$classroom"></x-course-card>
        @endforeach
        @endlecturer
    </div>
</x-layout>
