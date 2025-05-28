<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>View All {{ $header }}</x-slot:header>

    @if ($header == 'Classrooms')
        <div class="container mx-auto px-4 py-6">
            <!-- Search and Action Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar route="/view-all/classrooms" placeholder="Search classrooms..."/>
                </div>
                <a href="/register/classroom/choose-faculty" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Classroom
                </a>
            </div>

            <!-- Classroom Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($classrooms as $classroom)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <!-- Classroom Header -->
                        <div class="bg-blue-600 px-4 py-3">
                            <h3 class="text-lg font-bold text-white">{{ $classroom->class_code }}</h3>
                        </div>

                        <!-- Classroom Body -->
                        <div class="p-4">
                            <!-- Course Info -->
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Course</h4>
                                <p class="text-lg font-medium text-gray-900">{{ $classroom->course->course_id }} - {{ $classroom->course->name }}</p>
                                <p class="text-sm text-gray-500">{{ $classroom->course->credit }} credits</p>
                            </div>

                            <!-- Schedule -->
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Schedule</h4>
                                <p class="text-gray-700">{{ $classroom->schedule }}</p>
                            </div>

                            <!-- Lecturer -->
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Lecturer</h4>
                                <div class="flex items-center mt-2">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                        {{ substr($classroom->lecturer->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $classroom->lecturer->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $classroom->lecturer->lecturer_id }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Students Count -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    {{ $classroom->enrollments->count() ?? 0 }} students
                                </span>
                                {{-- SOON --}}
                                {{-- <a href="{{ route('classrooms.show', $classroom->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    View Details →
                                </a> --}}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No classrooms found</h3>
                        <p class="mt-1 text-gray-500">Get started by creating a new classroom.</p>
                        <div class="mt-6">
                            <a href="/register/classroom/choose-faculty" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                New Classroom
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    @if ($header == 'Courses')
        <div class="container mx-auto px-4 py-6">
            <!-- Search and Action Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar route="/view-all/courses" placeholder="Search courses..."/>
                </div>
                <a href="/register/course/choose-faculty" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Course
                </a>
            </div>

            <!-- Course Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($courses as $course)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <!-- Card Header -->
                        <div class="bg-blue-600 px-4 py-3">
                            <h3 class="text-lg font-bold text-white">{{ $course->course_id }}</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 space-y-4">
                            <!-- Course Name -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Course Name</h4>
                                <p class="text-gray-900 text-base font-medium">{{ $course->name }}</p>
                            </div>

                            <!-- Faculty -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Faculty</h4>
                                <p class="text-gray-700">{{ $course->faculty->name }}</p>
                            </div>

                            <!-- Credits -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Credits</h4>
                                <p class="text-gray-700">{{ $course->credit }}</p>
                            </div>

                            <!-- Classrooms Count -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4"/>
                                    </svg>
                                    {{ $course->classrooms->count() }} classroom{{ $course->classrooms->count() != 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center col-span-full py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h4l2 2h6a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No courses found</h3>
                        <p class="mt-1 text-gray-500">Get started by adding a new course.</p>
                        <div class="mt-6">
                            <a href="/register/course/choose-faculty" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                New Course
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    @if ($header == 'Faculties')
        <div class="container mx-auto px-4 py-6">
            <!-- Search and Action Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar route="/view-all/faculties" placeholder="Search faculties..."/>
                </div>
                <a href="/register/faculty/faculty-information" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Faculty
                </a>
            </div>

            <!-- Course Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($faculties as $faculty)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <!-- Card Header -->
                        <div class="bg-blue-600 px-4 py-3">
                            <h3 class="text-lg font-bold text-white">{{ $faculty->name }}</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 space-y-4">
                            <!-- Courses Count -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 100-4H7a2 2 0 100 4m10 4H7a2 2 0 100 4h10a2 2 0 100-4z" />
                                    </svg>
                                    {{ $faculty->courses->count() }} course{{ $faculty->courses->count() !== 1 ? 's' : '' }}
                                </span>
                            </div>

                            <!-- Lecturers Count -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.33 0 4.493.632 6.379 1.73M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $faculty->lecturers->count() }} lecturer{{ $faculty->lecturers->count() !== 1 ? 's' : '' }}
                                </span>
                            </div>

                            <!-- Students Count -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-5-4m-6 6v-2a4 4 0 00-5-4H2v6h11zM9 8a4 4 0 110-8 4 4 0 010 8zM17 8a4 4 0 110-8 4 4 0 010 8z" />
                                    </svg>
                                    {{ $faculty->students->count() }} student{{ $faculty->students->count() !== 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center col-span-full py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h4l2 2h6a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No faculties found</h3>
                        <p class="mt-1 text-gray-500">Get started by adding a new faculty.</p>
                        <div class="mt-6">
                            <a href="/register/faculty/faculty-information" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                New Faculty
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    @if ($header == 'Lecturers')
        <div class="container mx-auto px-4 py-6">
            <!-- Search and Action Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar route="/view-all/lecturers" placeholder="Search lecturers..."/>
                </div>
                <a href="/register/user/choose-faculty" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Lecturer
                </a>
            </div>

            <!-- Lecturer Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($lecturers as $lecturer)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <!-- Card Header -->
                        <div class="bg-blue-600 px-4 py-3">
                            <h3 class="text-lg font-bold text-white">{{ $lecturer->lecturer_id }}</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 space-y-4">
                            <!-- Lecturer Name -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Lecturer Name</h4>
                                <p class="text-gray-900 text-base font-medium">{{ $lecturer->user->name }}</p>
                            </div>

                            <!-- Faculty -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Faculty</h4>
                                <p class="text-gray-700">{{ $lecturer->faculty->name }}</p>
                            </div>

                            <!-- Credits -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Email</h4>
                                <p class="text-gray-700">{{ $lecturer->email }}</p>
                            </div>

                            <!-- Classrooms Count -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4"/>
                                    </svg>
                                    {{ $lecturer->classrooms->count() }} classroom{{ $lecturer->classrooms->count() != 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center col-span-full py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h4l2 2h6a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No lecturers found</h3>
                        <p class="mt-1 text-gray-500">Get started by adding a new lecturer.</p>
                        <div class="mt-6">
                            <a href="/register/user/choose-faculty" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                New Lecturer
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    @if ($header == 'Students')
        <div class="container mx-auto px-4 py-6">
            <!-- Search and Action Buttons -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div class="w-full md:w-1/2">
                    <x-search-bar route="/view-all/students" placeholder="Search students..."/>
                </div>
                <a href="/register/user/choose-faculty" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add New Student
                </a>
            </div>

            <!-- Lecturer Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($students as $student)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <!-- Card Header -->
                        <div class="bg-blue-600 px-4 py-3">
                            <h3 class="text-lg font-bold text-white">{{ $student->student_id }}</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 space-y-4">
                            <!-- Student Name -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Student Name</h4>
                                <p class="text-gray-900 text-base font-medium">{{ $student->user->name }}</p>
                            </div>

                            <!-- Faculty -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Faculty</h4>
                                <p class="text-gray-700">{{ $student->faculty->name }}</p>
                            </div>

                            <!-- Credits -->
                            <div>
                                <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Email</h4>
                                <p class="text-gray-700">{{ $student->email }}</p>
                            </div>

                            <!-- Classrooms Count -->
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21h8m-4-4v4"/>
                                    </svg>
                                    {{ $student->enrollments->count() }} classroom{{ $student->enrollments->count() != 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center col-span-full py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-5-4m-6 6v-2a4 4 0 00-5-4H2v6h11zM9 8a4 4 0 110-8 4 4 0 010 8zM17 8a4 4 0 110-8 4 4 0 010 8z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">No students found</h3>
                        <p class="mt-1 text-gray-500">Get started by adding a new student.</p>
                        <div class="mt-6">
                            <a href="/register/user/choose-faculty" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                New Student
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

</x-layout>
