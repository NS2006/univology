<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>System Administration</x-slot:header>

    <div class="container mx-auto px-4 py-8">
        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Faculty Card -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 dark:border dark:border-gray-700 border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium dark:text-gray-500 text-gray-400">Faculties</p>
                        <p class="text-2xl font-bold text-white dark:text-gray-900">{{ $faculties->count() }}</p>
                    </div>
                    <div class="p-3 rounded-full dark:bg-indigo-100 bg-indigo-900 dark:text-indigo-600 text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <a href="/register/faculty/faculty-information" class="mt-4 inline-flex items-center text-sm font-medium dark:text-indigo-600 text-indigo-400 hover:text-indigo-300 dark:hover:text-indigo-800">
                    Register New Faculty
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Course Card -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 dark:border dark:border-gray-700 border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium dark:text-gray-500 text-gray-400">Courses</p>
                        <p class="text-2xl font-bold text-white dark:text-gray-900">{{ $courses->count() }}</p>
                    </div>
                    <div class="p-3 rounded-full dark:bg-blue-100 bg-blue-900 dark:text-blue-600 text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <a href="/register/course/choose-faculty" class="mt-4 inline-flex items-center text-sm font-medium dark:text-blue-600 text-blue-400 hover:text-blue-300 dark:hover:text-blue-800">
                    Register New Course
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Classroom Card -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 dark:border dark:border-gray-700 border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium dark:text-gray-500 text-gray-400">Classrooms</p>
                        <p class="text-2xl font-bold text-white dark:text-gray-900">{{ $classrooms->count() }}</p>
                    </div>
                    <div class="p-3 rounded-full dark:bg-green-100 bg-green-900 dark:text-green-600 text-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                </div>
                <a href="/register/classroom/choose-faculty" class="mt-4 inline-flex items-center text-sm font-medium dark:text-green-600 text-green-400 hover:text-green-300 dark:hover:text-green-800">
                    Register New Classroom
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- User Card -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 dark:border dark:border-gray-700 border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium dark:text-gray-500 text-gray-400">Users</p>
                        <p class="text-2xl font-bold text-white dark:text-gray-900">{{ $lecturers->count() + $students->count() }}</p>
                    </div>
                    <div class="p-3 rounded-full dark:bg-purple-100 bg-purple-900 dark:text-purple-600 text-purple-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <a href="/register/user/choose-faculty" class="mt-4 inline-flex items-center text-sm font-medium dark:text-purple-600 text-purple-400 hover:text-purple-300 dark:hover:text-purple-800">
                    Register New User
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Main Content Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Classrooms Section -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow overflow-hidden dark:border dark:border-gray-700 border-gray-200">
                <div class="px-6 py-4 dark:border dark:border-gray-700 border-gray-200">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-900">Recent Classrooms</h3>
                </div>
                <div class="divide-y dark:divide-gray-700 divide-gray-200">
                    @forelse ($classrooms->take(5) as $classroom)
                        <div class="p-4 hover:bg-gray-700 dark:hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-white dark:text-gray-900">{{ $classroom->class_code }}</p>
                                    <p class="text-sm dark:text-gray-500 text-gray-400">{{ $classroom->course->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-white dark:text-gray-900">{{ $classroom->enrollments->count() }} students</p>
                                    <p class="text-xs dark:text-gray-500 text-gray-400">{{ $classroom->schedule }}</p>
                                </div>
                            </div>
                            <div class="mt-2 flex items-center text-sm dark:text-gray-500 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $classroom->lecturer->user->name }} ({{ $classroom->lecturer->lecturer_id }})
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto dark:text-gray-500 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                            <p class="mt-2 dark:text-gray-500 text-gray-400">No classrooms found</p>
                            <a href="/register/classroom/choose-faculty" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-indigo-300 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Classroom
                            </a>
                        </div>
                    @endforelse
                </div>
                <div class="px-6 py-3 dark:bg-gray-50 bg-gray-700 text-right text-sm">
                    <a href="/view-all/classrooms" class="font-medium dark:text-indigo-600 text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                        View all classrooms
                    </a>
                </div>
            </div>

            <!-- Courses Section -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow overflow-hidden dark:border dark:border-gray-700 border-gray-200">
                <div class="px-6 py-4 dark:border dark:border-gray-700 border-gray-200">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-900">Recent Courses</h3>
                </div>
                <div class="divide-y dark:divide-gray-700 divide-gray-200">
                    @forelse ($courses->take(5) as $course)
                        <div class="p-4 hover:bg-gray-700 dark:hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-white dark:text-gray-900">{{ $course->course_id }} - {{ $course->name }}</p>
                                    <p class="text-sm dark:text-gray-500 text-gray-400">{{ $course->faculty->name }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full dark:bg-blue-100 bg-blue-900 dark:text-blue-800 text-blue-200">
                                    {{ $course->credit }} credits
                                </span>
                            </div>
                            <div class="mt-2 flex items-center text-sm dark:text-gray-500 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $course->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto dark:text-gray-500 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="mt-2 dark:text-gray-500 text-gray-400">No courses found</p>
                            <a href="/register/course/choose-faculty" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-blue-300 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Course
                            </a>
                        </div>
                    @endforelse
                </div>
                <div class="px-6 py-3 dark:bg-gray-50 bg-gray-700 text-right text-sm">
                    <a href="/view-all/courses" class="font-medium dark:text-blue-600 text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                        View all courses
                    </a>
                </div>
            </div>

            <!-- Users Section -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow overflow-hidden dark:border dark:border-gray-700 border-gray-200 lg:col-span-2">
                <div class="px-6 py-4 dark:border dark:border-gray-700 border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white dark:text-gray-900">User Accounts</h3>
                        <div class="flex space-x-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full dark:bg-purple-100 bg-purple-900 dark:text-purple-800 text-purple-200">
                                {{ $lecturers->count() }} Lecturers
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full dark:bg-green-100 bg-green-900 dark:text-green-800 text-green-200">
                                {{ $students->count() }} Students
                            </span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x dark:divide-gray-700 divide-gray-200">
                    <!-- Lecturers Column -->
                    <div class="p-4">
                        <h4 class="font-medium dark:text-gray-700 text-gray-300 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 dark:text-purple-600 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            Lecturers
                        </h4>
                        <div class="space-y-3">
                            @forelse ($lecturers->take(3) as $lecturer)
                                <div class="flex items-center p-2 hover:bg-gray-700 dark:hover:bg-gray-100 dark:border-gray-700 dark:border rounded-lg transition-colors">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full dark:bg-purple-100 bg-purple-900 flex items-center justify-center dark:text-purple-600 text-purple-300 font-medium">
                                        {{ substr($lecturer->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-white dark:text-gray-900">{{ $lecturer->user->name }}</p>
                                        <p class="text-xs dark:text-gray-500 text-gray-400">{{ $lecturer->lecturer_id }} • {{ $lecturer->faculty->name }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto dark:text-gray-500 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <p class="mt-2 text-sm dark:text-gray-500 text-gray-400">No lecturers found</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-3 text-right">
                            <a href="/view-all/lecturers" class="text-xs font-medium dark:text-purple-600 text-purple-400 hover:text-purple-500 dark:hover:text-purple-300">
                                View all lecturers →
                            </a>
                        </div>
                    </div>

                    <!-- Students Column -->
                    <div class="p-4">
                        <h4 class="font-medium dark:text-gray-700 text-gray-300 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 dark:text-green-600 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Students
                        </h4>
                        <div class="space-y-3">
                            @forelse ($students->take(3) as $student)
                                <div class="flex items-center p-2 hover:bg-gray-700 dark:hover:bg-gray-100 dark:border dark:border-gray-700 rounded-lg transition-colors">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full dark:bg-green-100 bg-green-900 flex items-center justify-center dark:text-green-600 text-green-300 font-medium">
                                        {{ substr($student->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-white dark:text-gray-900">{{ $student->user->name }}</p>
                                        <p class="text-xs dark:text-gray-500 text-gray-400">{{ $student->student_id }} • {{ $student->faculty->name }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto dark:text-gray-500 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="mt-2 text-sm dark:text-gray-500 text-gray-400">No students found</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-3 text-right">
                            <a href="/view-all/students" class="text-xs font-medium dark:text-green-600 text-green-400 hover:text-green-500 dark:hover:text-green-300">
                                View all students →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faculties Section -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow overflow-hidden dark:border dark:border-gray-700 border-gray-200 lg:col-span-2">
                <div class="px-6 py-4 dark:border dark:border-gray-700 border-gray-200">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-900">Faculties</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @forelse ($faculties as $faculty)
                        <div class="p-4 border rounded-lg hover:shadow-md dark:hover:bg-gray-100 transition-shadow dark:border-gray-700">
                            <h4 class="font-medium text-white dark:text-gray-900">{{ $faculty->name }}</h4>
                            <div class="mt-2 flex justify-between text-sm dark:text-gray-500 text-gray-400">
                                <span>{{ $faculty->courses->count() }} courses</span>
                                <span>{{ $faculty->lecturers->count() + $faculty->students->count() }} users</span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto dark:text-gray-500 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <p class="mt-2 dark:text-gray-500 text-gray-400">No faculties found</p>
                            <a href="/register/faculty/faculty-information" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-900 bg-indigo-300 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Faculty
                            </a>
                        </div>
                    @endforelse
                </div>
                <div class="px-6 py-3 dark:bg-gray-50 bg-gray-700 text-right text-sm">
                    <a href="/view-all/faculties" class="font-medium dark:text-indigo-600 text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                        View all faculties
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
