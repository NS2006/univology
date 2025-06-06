<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>{{ $title }}</x-slot:header>

    @php
        $classroomUrl = url("/classroom/{$classroom->class_id}");
    @endphp

    @lecturer
    <!-- Additional Material Button -->
    @if ($page == 'session')
        <div id="additional-material-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Do you want to add new material?
                        </h3>
                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-modal-hide="additional-material-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                        <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="{{ $classroomUrl }}/session/{{ $classroom_session->classroom_session_id }}/add-material" method="POST">
                        @csrf

                            <div>
                                <label for="material_link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Material Link</label>
                                <input type="text" name="material_link" id="material_link" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Material LInk" required />
                            </div>

                            <div>
                                <label for="material_topic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Material Topic</label>
                                <input type="text" name="material_topic" id="material_topic" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Material Topic" required />
                            </div>

                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">Add New Material</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endlecturer

    <div class="container mx-auto px-4 py-2">
        <!-- Navigation Menu -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Session Card -->
            <a href="{{ session()->get('classroom.current.session') }}"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-blue-500 hover:border-blue-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-blue-100 bg-blue-900/50 dark:text-blue-600 text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-blue-600 group-hover:text-blue-400">Session</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">View classroom sessions</p>
                    </div>
                </div>
            </a>

            <!-- About Card -->
            <a href="{{ $classroomUrl }}/about"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-purple-500 hover:border-purple-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-purple-100 bg-purple-900/50 dark:text-purple-600 text-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-purple-600 group-hover:text-purple-400">About</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">Classroom details</p>
                    </div>
                </div>
            </a>

            @student
            <!-- View Score Card -->
            <a href="{{ $classroomUrl }}/view-score"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-green-500 hover:border-green-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-green-100 bg-green-900/50 dark:text-green-600 text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-green-600 group-hover:text-green-400">View Score</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">Check your grades</p>
                    </div>
                </div>
            </a>

            <!-- Shop Card -->
            <a href="{{ $classroomUrl }}/shop"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-yellow-500 hover:border-yellow-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-yellow-100 bg-yellow-900/50 dark:text-yellow-600 text-yellow-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-yellow-600 group-hover:text-yellow-400">Shop</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">Spend your coins</p>
                    </div>
                </div>
            </a>
            @endstudent

            @lecturer
            <!-- Submit Score Card -->
            <a href="{{ $classroomUrl }}/submit-score"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-yellow-500 hover:border-yellow-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-yellow-100 bg-yellow-900/50 dark:text-yellow-600 text-yellow-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-yellow-600 group-hover:text-yellow-400">Submit Score</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">Grade students</p>
                    </div>
                </div>
            </a>

            <!-- Score Statistics Card -->
            <a href="{{ $classroomUrl }}/score-statistics"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-red-500 hover:border-red-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-red-100 bg-red-900/50 dark:text-red-600 text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-red-600 group-hover:text-red-400">Score Statistics</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">View class performance</p>
                    </div>
                </div>
            </a>
            @endlecturer
        </div>

        {{-- Session Page --}}
        @if ($page == 'session')
            <div class="rounded-xl shadow-lg overflow-hidden @if($classroom_session->is_finished) border-4 border-green-200 @endif bg-gray-800 dark:bg-white">
                <!-- Session Navigation Tabs -->
                <div class="border-b border-gray-700 dark:border-gray-200">
                    <nav class="flex overflow-x-auto px-4 -mb-px">
                    @foreach ($classroom->classroom_sessions as $classroom_session_loop)
                        <a href="{{ $classroomUrl }}/session/{{ $classroom_session_loop->classroom_session_id }}"
                        class="@if($classroom_session_loop->classroom_session_id == $classroom_session->classroom_session_id) border-blue-500 dark:text-blue-600 text-blue-400 @else border-transparent dark:hover:text-gray-700 dark:hover:border-gray-300 hover:text-gray-300 hover:border-gray-700 @endif whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors">
                        Session {{ $classroom_session_loop->course_session->session_number }}
                        </a>
                    @endforeach
                    </nav>
                </div>

                <!-- Current Session Content -->
                <div class="p-6">
                    <!-- Session Header -->
                    <div class="mb-6 pb-6 border-b border-gray-700 dark:border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-white dark:text-gray-800">
                                    Session {{ $classroom_session->course_session->session_number }}: {{ $classroom_session->course_session->title }}
                                </h2>

                                <div class="flex items-center text-sm mt-1">
                                    @if ($classroom_session->is_finished)
                                        <span class="inline-flex items-center px-2 py-1 bg-green-600 text-white text-xs font-medium rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Finished
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center mt-2 text-sm text-gray-400 dark:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $classroom_session->date }} •
                                    {{ \Carbon\Carbon::parse($classroom_session->start_time)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::parse($classroom_session->end_time)->format('g:i A') }}
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                @lecturer
                                <!-- Attendance Button -->
                                <a href="{{ $classroomUrl }}/session/{{ $classroom_session->classroom_session_id }}/attendance"
                                    class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $classroom_session->is_finished == 0 ? 'Take' : 'View' }} Attendance
                                </a>
                                @endlecturer

                                <!-- Online Link Section -->
                                @if($classroom->online_link && $valid_session == true)
                                    <a href="{{ $classroomUrl }}/session/{{ $classroom_session->classroom_session_id }}/online-link" target="_blank"
                                        class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        Join Online Class
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Lecturer Section -->
                    <div class="mb-6 p-4 bg-gray-700 dark:bg-gray-100 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ substr($classroom->lecturer->user->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                        <h4 class="text-lg font-medium text-white dark:text-gray-800">Lecturer</h4>
                        <p class="text-sm text-gray-300 dark:text-gray-600">
                            {{ $classroom->lecturer->lecturer_id }} - {{ $classroom->lecturer->user->name }}
                        </p>
                        </div>
                    </div>
                    </div>

                    <!-- Main Materials Section -->
                    <div class="mb-8">
                    <h3 class="text-lg font-semibold text-white dark:text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Main Materials
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($classroom_session->course_session->main_materials as $main_material)
                            <x-material-card :classroomUrl="$classroomUrl" :material="$main_material->material" :classroom="$classroom" />
                        @endforeach
                    </div>
                    </div>

                    <!-- Additional Materials Section -->
                    <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-white dark:text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Additional Materials
                        </h3>

                        @lecturer
                        <button type="button" data-modal-target="additional-material-modal" data-modal-toggle="additional-material-modal"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Material
                        </button>
                        @endlecturer
                    </div>

                    @if($classroom_session->additional_materials->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($classroom_session->additional_materials as $additional_material)
                            <x-material-card :classroomUrl="$classroomUrl" :material="$additional_material->material" :classroom="$classroom" />
                        @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-700 dark:bg-gray-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-2 text-gray-400 dark:text-gray-500">No additional materials added yet</p>
                        @lecturer
                        <button type="button" data-modal-target="additional-material-modal" data-modal-toggle="additional-material-modal"
                                class="mt-4 inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Your First Material
                        </button>
                        @endlecturer
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($page == 'about')
            <div class="container mx-auto px-4 py-8">
            <!-- Course Information Card -->
            <div class="dark:bg-white bg-gray-800 rounded-xl shadow-md overflow-hidden mb-8 border dark:border-gray-200 border-gray-700">
                <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                    <h1 class="text-2xl font-bold dark:text-gray-800 text-white">
                        {{ $classroom->course->course_id }} - {{ $classroom->course->name }}
                    </h1>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="px-3 py-1 rounded-full text-sm font-medium dark:bg-blue-100 bg-blue-900 dark:text-blue-800 text-blue-200">
                        {{ $classroom->course->credit }} Credits
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium dark:bg-green-100 bg-green-900 dark:text-green-800 text-green-200">
                        Class {{ $classroom->class_code }}
                        </span>
                    </div>
                    </div>
                    <div class="md:text-right">
                    <h3 class="text-lg font-medium dark:text-gray-800 text-white">Faculty</h3>
                    <p class="dark:text-gray-600 text-gray-300">{{ $classroom->course->faculty->name }}</p>
                    </div>
                </div>
                </div>
            </div>

            <!-- Lecturer Card -->
            <div class="dark:bg-white bg-gray-800 rounded-xl shadow-md overflow-hidden mb-8 border dark:border-gray-200 border-gray-700">
                <div class="p-6">
                <h2 class="text-xl font-semibold dark:text-gray-800 text-white mb-4">Lecturer Information</h2>
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full dark:bg-indigo-100 bg-indigo-900 flex items-center justify-center dark:text-indigo-600 text-indigo-300 font-bold">
                    {{ substr($classroom->lecturer->user->name, 0, 1) }}
                    </div>
                    <div>
                    <h3 class="text-lg font-medium dark:text-gray-800 text-white">
                        {{ $classroom->lecturer->user->name }}
                    </h3>
                    <p class="dark:text-gray-600 text-gray-300">{{ $classroom->lecturer->lecturer_id }}</p>
                    <p class="dark:text-gray-600 text-gray-300">{{ $classroom->lecturer->email }}</p>
                    </div>
                </div>
                </div>
            </div>

            <!-- Students Card -->
            <div class="dark:bg-white bg-gray-800 rounded-xl shadow-md overflow-hidden border dark:border-gray-200 border-gray-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold dark:text-gray-800 text-white">
                        Students
                        </h2>
                        <span class="px-3 py-1 rounded-full text-sm font-medium dark:bg-purple-100 bg-purple-900 dark:text-purple-800 text-purple-200">
                        {{ $classroom->enrollments->count() }} Students
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($classroom->enrollments as $enrollment)
                            <div class="dark:bg-gray-50 bg-gray-700 rounded-lg p-4 flex items-center gap-3">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full dark:bg-green-100 bg-green-900 flex items-center justify-center dark:text-green-600 text-green-300 font-bold">
                                    {{ substr($enrollment->student->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-medium dark:text-gray-800 text-white">
                                        {{ $enrollment->student->user->name }}
                                    </h4>
                                    <p class="text-sm dark:text-gray-600 text-gray-300">{{ $enrollment->student->student_id }}</p>
                                    <p class="text-xs dark:text-gray-500 text-gray-400 truncate">{{ $enrollment->student->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        @endif

        @student
        @if ($page == 'view_score')
            <div class="dark:bg-white bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="dark:bg-blue-600 bg-blue-800 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white">Your Grades</h1>
                    <p class="text-blue-100">Detailed breakdown of your scores</p>
                </div>

                <!-- Final Grade Summary -->
                <div class="p-6 border-b dark:border-gray-200 border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <h2 class="text-lg font-medium dark:text-gray-800 text-white">Final Result</h2>
                            <p class="dark:text-gray-600 text-gray-300">Combined from all score components</p>
                        </div>
                        <div class="text-center">
                            <div class="text-5xl font-bold dark:text-blue-600 text-blue-400">
                            {{ $enrollment->final_grade() ?? 'N/A' }}
                            </div>
                            <div class="dark:text-gray-600 text-gray-400">
                            ({{ $enrollment->final_score ?? 0}} points)
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Score Components -->
                <div class="p-6">
                    <h2 class="text-xl font-semibold dark:text-gray-800 text-white mb-4">Score Components</h2>

                    <div class="space-y-4">
                        @foreach ($user_scores as $user_score)
                        <div class="dark:bg-gray-50 bg-gray-700 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium dark:text-gray-800 text-white">
                                    {{ $user_score->score_component->name }}
                                    </h3>
                                    <p class="text-sm dark:text-gray-600 text-gray-400">
                                    Weight: {{ $user_score->score_component->weight }}%
                                    </p>
                                </div>
                                <div class="text-right">
                                    @php
                                    $percentage = $user_score->score;
                                    $scoreColor = match(true) {
                                        $percentage >= 90 => 'dark:text-green-600 text-green-400',
                                        $percentage >= 70 => 'dark:text-blue-600 text-blue-400',
                                        $percentage >= 50 => 'dark:text-yellow-600 text-yellow-400',
                                        $percentage >= 40 => 'dark:text-orange-600 text-orange-400',
                                        default => 'dark:text-red-600 text-red-400'
                                    };
                                    @endphp
                                    <div class="text-2xl font-bold {{ $scoreColor }}">
                                        {{ $user_score->score ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs dark:text-gray-500 text-gray-400">
                                        {{ $user_score->score * $user_score->score_component->weight / 100 }} / {{ $user_score->score_component->weight }} points
                                    </div>
                                </div>
                                </div>

                                <!-- Progress bar -->
                                <div class="mt-3 w-full dark:bg-gray-200 bg-gray-600 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full"
                                    style="width: {{ $user_score->score ?? 0 }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($page == 'shop')
            <div class="container mx-auto px-4 py-6 relative">
                @if ($attendance_percentage < 50)
                    <div class="absolute inset-0 z-40 bg-black/60 backdrop-blur-sm flex items-center justify-center rounded-lg">
                        <div class="bg-white dark:bg-gray-900 text-center px-6 py-8 rounded-xl shadow-lg border border-gray-300 dark:border-gray-700 max-w-md">
                            <h2 class="text-2xl font-bold text-red-600 dark:text-red-400 mb-2">Feature Locked</h2>
                            <p class="text-gray-800 dark:text-gray-300 mb-4">You need at least <strong>50% attendance</strong> to access the shop.</p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-yellow-400 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                            </svg>
                        </div>
                    </div>
                @endif


                <!-- Coin Balance Display -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold dark:text-gray-800 text-white">Your Coin Balance</h2>
                            <p class="dark:text-gray-600 text-gray-400">Earn more coins by completing assignments</p>
                        </div>
                        <div class="flex items-center">
                            <div class="p-3 rounded-full dark:bg-yellow-100 bg-yellow-900/50 dark:text-yellow-600 text-yellow-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="ml-3 text-2xl font-bold dark:text-gray-800 text-white">{{ $enrollment->coin }}</span>
                        </div>
                    </div>
                </div>

                <!-- Purchasable Items -->
                @php
                $color_points = [
                    '1' => 'dark:bg-blue-100 bg-blue-900/50 dark:text-blue-800 text-blue-400',
                    '2' => 'dark:bg-purple-100 bg-purple-900/50 dark:text-purple-800 text-purple-400',
                    '3' => 'dark:bg-green-100 bg-green-900/50 dark:text-green-800 text-green-400'
                ];

                $color_buttons = [
                    '1' => 'bg-blue-600 hover:bg-blue-700',
                    '2' => 'bg-purple-600 hover:bg-purple-700',
                    '3' => 'bg-green-600 hover:bg-green-700'
                ];
                @endphp


                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach ($boosters as $booster)
                        <form action="{{ $classroomUrl }}/shop/{{ $booster['id'] }}"  method="POST" class="dark:bg-white bg-gray-800 rounded-lg shadow-md overflow-hidden border dark:border-gray-200 border-gray-700 hover:shadow-lg transition-shadow">
                            @csrf
                            <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">

                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-bold dark:text-gray-800 text-white">{{ $booster['name'] }}</h3>
                                    <span class="px-2 py-1 {{ $color_points[$booster['id']] }} text-xs font-medium rounded-full">+{{ $booster['point'] }} Point</span>
                                </div>
                                <p class="dark:text-gray-600 text-gray-400 mb-4">{{ $booster['description'] }}</p>
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="ml-1 font-medium dark:text-gray-800 text-white">{{ $booster['price'] }}</span>
                                    </div>
                                    <button class="px-4 py-2 {{ $color_buttons[$booster['id']] }} rounded-md transition-colors text-white {{ $enrollment->coin >= $booster['price'] ? "cursor-pointer" : "cursor-not-allowed" }}">
                                        @if($enrollment->coin >= $booster['price'])
                                            Purchase
                                        @else
                                            Not Enough Coins
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>

                <!-- Purchase History Button -->
                <div class="text-center mt-8">
                    <button data-modal-target="purchase-history-modal" data-modal-toggle="purchase-history-modal"
                        class="px-6 py-3 dark:bg-gray-100 dark:hover:bg-gray-200 dark:text-gray-800 bg-gray-700 hover:bg-gray-600 text-white rounded-lg shadow-md flex items-center gap-2 mx-auto transition-colors font-bold cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        View Purchase History
                    </button>
                </div>

                <!-- Purchase History Modal -->
                <div id="purchase-history-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-700">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Your Purchase History
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="purchase-history-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <div class="p-6">
                                @if($purchase_histories->count() > 0)
                                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($purchase_histories as $purchase)
                                        <div class="py-4">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $purchase->description }}</h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $purchase->created_at->format('M d, Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No purchases yet</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Your purchase history will appear here</p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center p-6 border-t border-gray-200 dark:border-gray-700 rounded-b">
                                <button data-modal-hide="purchase-history-modal" type="button" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endstudent

        @lecturer
        @if ($page == 'submit_score')
            <div class="dark:bg-white bg-gray-800 rounded-xl shadow-lg overflow-hidden p-6 mb-4">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold dark:text-gray-800 text-white">Score Submission</h1>
                    <p class="dark:text-gray-600 text-gray-300">Select a score component to do grading</p>
                </div>

                <!-- Score Component Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($score_components as $score_component_loop)
                        <a href="{{ $classroomUrl }}/submit-score/{{ Str::slug($score_component_loop->name) }}"
                        class="group block border rounded-lg hover:shadow-md transition-all duration-200 dark:border-gray-200 border-gray-700 dark:hover:border-blue-500 hover:border-blue-400">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold dark:text-gray-800 text-white dark:group-hover:text-blue-600 group-hover:text-blue-400">
                                            {{ $score_component_loop->name }}
                                        </h3>
                                        <p class="text-sm dark:text-gray-500 text-gray-400 mt-1">
                                            Weight: {{ $score_component_loop->weight }}%
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-between text-sm dark:text-gray-500 text-gray-400">
                                    <span>Start Grading</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            @if ($submission == true)
                <div class="dark:bg-white bg-gray-800 rounded-xl shadow-lg overflow-hidden border dark:border-gray-200 border-gray-700">
                    <!-- Header -->
                    <div class="bg-gradient-to-r dark:from-blue-600 dark:to-blue-500 from-blue-800 to-blue-700 px-6 py-5">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-2xl font-bold text-white">{{$score_component->name}} Scores</h1>
                                <p class="text-blue-100 opacity-90 mt-1">
                                    {{ $classroom->course->name }} • Weight: {{ $score_component->weight }}%
                                </p>
                            </div>
                            <div class="dark:bg-blue-700 bg-blue-900 px-3 py-1 rounded-full text-sm font-medium text-white">
                                {{ $enrollments->count() }} Students
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="p-0">
                        <form action="{{ session()->get('classroom.current.submit') }}/submit" method="POST">
                            @csrf
                            <!-- Table Container -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y dark:divide-gray-200 divide-gray-700">
                                    <thead class="dark:bg-gray-50 bg-gray-700/50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium dark:text-gray-500 text-gray-400 uppercase tracking-wider">Student ID</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium dark:text-gray-500 text-gray-400 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium dark:text-gray-500 text-gray-400 uppercase tracking-wider">Score (0-100)</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium dark:text-gray-500 text-gray-400 uppercase tracking-wider">Weighted Score</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dark:bg-white bg-gray-800 divide-y dark:divide-gray-200 divide-gray-700">
                                        @foreach($enrollments as $enrollment)
                                            @php
                                                $curr_score = $enrollment->student_scores
                                                            ->where('score_component_id', $score_component->id)
                                                            ->first()->score
                                                            ?? null;

                                                $is_graded = !is_null($curr_score);

                                                $weighted_score = $is_graded ? number_format($curr_score * $score_component->weight / 100, 2) : null;
                                            @endphp

                                            <tr class="dark:hover:bg-gray-50 hover:bg-gray-700/50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-medium dark:text-gray-900 text-white">
                                                        {{ $enrollment->student->student_id }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10 rounded-full dark:bg-gray-200 bg-gray-600 flex items-center justify-center">
                                                            <span class="dark:text-gray-600 text-gray-300 font-medium">
                                                                {{ substr($enrollment->student->user->name, 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium dark:text-gray-900 text-white">
                                                                {{ $enrollment->student->user->name }}
                                                            </div>
                                                            <div class="text-xs dark:text-gray-500 text-gray-400">
                                                                {{ $enrollment->student->user->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if (!$is_graded)
                                                        <input type="number"
                                                            step="0.01"
                                                            min="0"
                                                            max="100"
                                                            name="scores[{{ $enrollment->id }}]"
                                                            class="w-24 px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                                            placeholder="Score">
                                                    @else
                                                        <div class="flex items-center">
                                                            <span class="px-3 py-1 rounded-full text-sm font-medium dark:bg-blue-100 bg-blue-900/50 dark:text-blue-800 text-blue-200">
                                                            {{ $curr_score }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if (!$is_graded)
                                                        <span class="dark:text-gray-400 text-gray-500">N/A</span>
                                                    @else
                                                        <span class="dark:text-gray-900 text-white">
                                                            {{ $weighted_score }}
                                                        </span>
                                                        <span class="ml-1 text-xs dark:text-gray-500 text-gray-400">
                                                            ({{ $score_component->weight }}%)
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Footer with Save Button -->
                            <div class="px-6 py-4 dark:bg-gray-50 bg-gray-700/30 border-t dark:border-gray-200 border-gray-700 flex justify-end">
                                <button type="button" data-modal-target="confirmation-tab" data-modal-toggle="confirmation-tab" class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 flex items-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Save All Scores
                                </button>
                            </div>

                            <!-- Main modal -->
                            <div id="confirmation-tab" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                                            <div>
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Confirm Score Submission
                                                </h3>
                                            </div>
                                            <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="confirmation-tab">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="p-5 space-y-4">
                                            <div class="flex items-center p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300">
                                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                                </svg>
                                                <span class="sr-only">Info</span>
                                                <div>
                                                    <span class="font-medium">Important:</span> This action cannot be undone. Please verify the scores before submitting.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="flex items-center justify-end p-5 border-t border-gray-200 rounded-b dark:border-gray-600 space-x-3">
                                            <button type="button"
                                                    class="cursor-pointer text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                                                    data-modal-hide="confirmation-tab">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                    class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Confirm Submission
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        @endif

        @if($page == 'score_statistics')
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Average Score -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-gray-500 text-gray-400 text-sm font-medium">Average Score</p>
                            <p class="dark:text-gray-900 text-white text-2xl font-bold">{{ $average_score }}</p>
                        </div>
                        <div class="dark:bg-blue-100 bg-blue-900/50 p-3 rounded-full dark:text-blue-600 text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Highest Score -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-gray-500 text-gray-400 text-sm font-medium">Highest Score</p>
                            <p class="dark:text-gray-900 text-white text-2xl font-bold">{{ $highest_score }}</p>
                            <p class="dark:text-gray-500 text-gray-400 text-xs">{{ $top_student->name }}</p>
                        </div>
                        <div class="dark:bg-green-100 bg-green-900/50 p-3 rounded-full dark:text-green-600 text-green-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Lowest Score -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-gray-500 text-gray-400 text-sm font-medium">Lowest Score</p>
                            <p class="dark:text-gray-900 text-white text-2xl font-bold">{{ $lowest_score }}</p>
                            <p class="dark:text-gray-500 text-gray-400 text-xs">{{ $bottom_student->name }}</p>
                        </div>
                        <div class="dark:bg-red-100 bg-red-900/50 p-3 rounded-full dark:text-red-600 text-red-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pass Rate -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="dark:text-gray-500 text-gray-400 text-sm font-medium">Pass Rate</p>
                            <p class="dark:text-gray-900 text-white text-2xl font-bold">{{ $pass_rate }}%</p>
                            <p class="dark:text-gray-500 text-gray-400 text-xs">{{ $passed_students }} of {{ $total_students }} students</p>
                        </div>
                        <div class="dark:bg-purple-100 bg-purple-900/50 p-3 rounded-full dark:text-purple-600 text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 mb-6">
                <h3 class="dark:text-gray-900 text-white text-lg font-semibold mb-4">Course Component Performance</h3>
                <div class="space-y-4">
                    @foreach($score_components as $component)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="dark:text-gray-700 text-gray-300 text-sm font-medium">{{ $component->name }} ({{ $component->weight }}%)</span>
                                <span class="dark:text-gray-700 text-gray-300 text-sm font-medium">{{ $component_averages[$component->id] }}</span>
                            </div>
                            <div class="w-full dark:bg-gray-200 bg-gray-700 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $component_averages[$component->id] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="dark:bg-white bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 dark:border-gray-200 border-gray-700 border-b flex justify-between items-center">
                    <h3 class="dark:text-gray-900 text-white text-lg font-semibold">Student Performance</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y dark:divide-gray-200 divide-gray-700">
                        <thead class="dark:bg-gray-50 bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left dark:text-gray-500 text-gray-300 text-xs font-medium uppercase tracking-wider">Student</th>
                                <th scope="col" class="px-6 py-3 text-left dark:text-gray-500 text-gray-300 text-xs font-medium uppercase tracking-wider">ID</th>
                                @foreach($score_components as $component)
                                    <th scope="col" class="px-6 py-3 text-left dark:text-gray-500 text-gray-300 text-xs font-medium uppercase tracking-wider">{{ $component->name }}</th>
                                @endforeach
                                <th scope="col" class="px-6 py-3 text-left dark:text-gray-500 text-gray-300 text-xs font-medium uppercase tracking-wider">Final</th>
                                <th scope="col" class="px-6 py-3 text-left dark:text-gray-500 text-gray-300 text-xs font-medium uppercase tracking-wider">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="dark:bg-white bg-gray-800 divide-y dark:divide-gray-200 divide-gray-700">
                            @foreach($enrollments as $enrollment)
                                <tr class="dark:hover:bg-gray-50 hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full dark:bg-gray-200 bg-gray-600 flex items-center justify-center">
                                                <span class="dark:text-gray-600 text-gray-300 font-medium">
                                                    {{ substr($enrollment->student->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="dark:text-gray-900 text-white text-sm font-medium">
                                                    {{ $enrollment->student->user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-500 text-gray-400 text-sm">
                                        {{ $enrollment->student->student_id }}
                                    </td>
                                    @foreach($score_components as $component)
                                        @php
                                            $curr_score = $enrollment->student_scores
                                                ->firstWhere('score_component_id', $component->id)
                                                ->score ?? null;
                                        @endphp

                                        <td class="px-6 py-4 whitespace-nowrap dark:text-gray-900 text-gray-300 text-sm {{ $curr_score == null || $curr_score < 60 ? 'dark:text-red-600 text-red-400' : '' }}">
                                            {{ $curr_score !== null ? $curr_score : 'N/A' }}
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-900 text-gray-300 text-sm font-medium {{ $enrollment->final_score < 60 ? 'dark:text-red-600 text-red-400' : '' }}">
                                        {{ $enrollment->final_score ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-900 text-gray-300 text-sm font-medium {{ $enrollment->final_score < 60 ? 'dark:text-red-600 text-red-400' : '' }}">
                                        {{ $enrollment->final_grade() ?? 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if ($page == 'attendance')
        <div class="container mx-auto px-4 py-6">
            <!-- Attendance Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold dark:text-gray-800 text-white mb-2">
                    Attendance for Session {{ $classroom_session->course_session->session_number }}
                </h1>
                <div class="flex items-center text-sm dark:text-gray-600 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-medium text-gray-700 dark:text-gray-800">
                        {{ $classroom_session->date->format('F j, Y') }} •
                        {{ $classroom->class_code }} - {{ $classroom->course->name }}
                    </span>
                </div>

                @if ($classroom_session->is_finished == 1)
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-600 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="mr-1 text-gray-800">Last Updated:</span>
                        <span class="font-medium text-gray-700 dark:text-gray-800">
                            {{ $classroom_session->updated_at->format('F j, Y \a\t g:i A') }}
                        </span>
                    </div>
                @endif


            </div>

            @if ($classroom_session->is_finished == 1)
                <!-- Attendance Statistics -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Present Students -->
                        <div class="dark:bg-green-50 bg-green-900/20 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium dark:text-green-600 text-green-400">Present</p>
                                    <p class="text-2xl font-bold dark:text-green-800 text-green-300">
                                        {{ $attendances->where('status', true)->count() }}
                                        <span class="text-sm font-normal">({{ round($attendances->where('status', true)->count() / $enrollments->count() * 100) }}%)</span>
                                    </p>
                                </div>
                                <div class="p-2 rounded-full dark:bg-green-100 bg-green-800/50 dark:text-green-600 text-green-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Absent Students -->
                        <div class="dark:bg-red-50 bg-red-900/20 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium dark:text-red-600 text-red-400">Absent</p>
                                    <p class="text-2xl font-bold dark:text-red-800 text-red-300">
                                        {{ $attendances->where('status', false)->count() }}
                                        <span class="text-sm font-normal">({{ round($attendances->where('status', false)->count() / $enrollments->count() * 100) }}%)</span>
                                    </p>
                                </div>
                                <div class="p-2 rounded-full dark:bg-red-100 bg-red-800/50 dark:text-red-600 text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Attendance Form -->
            <form action="{{ $classroomUrl }}/session/{{ $classroom_session->classroom_session_id }}/attendance/save-attendance" method="POST">
                @csrf

                <div class="dark:bg-white bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <!-- Table Header -->
                    <div class="grid grid-cols-12 px-6 py-4 bg-gray-900 dark:bg-gray-100 border-b border-gray-600 dark:border-gray-300">
                        <div class="col-span-8 text-sm font-semibold text-white dark:text-gray-800 tracking-wide uppercase">
                            Student Information
                        </div>
                        <div class="col-span-4 flex items-center justify-end gap-2">
                            <span class="text-sm font-semibold text-white dark:text-gray-800 tracking-wide uppercase">
                                Attendance
                            </span>
                            @if ($classroom_session->is_finished == 0)
                                <button type="button" id="check-all-btn"
                                class="px-3 py-1.5 text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg flex items-center gap-1 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Check All
                                </button>
                            @endif
                        </div>
                    </div>



                    @foreach($enrollments as $enrollment)
                        <div class="grid grid-cols-12 px-6 py-4 border-b dark:border-gray-200 border-gray-600 dark:hover:bg-gray-50 hover:bg-gray-700/50 transition-colors">
                            <!-- Student Info -->
                            <div class="col-span-8 flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full dark:bg-gray-200 bg-gray-600 flex items-center justify-center mr-3">
                                    <span class="dark:text-gray-600 text-gray-300 font-medium">
                                        {{ substr($enrollment->student->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-medium dark:text-gray-900 text-white">
                                        {{ $enrollment->student->user->name }}
                                    </div>
                                    <div class="text-sm dark:text-gray-500 text-gray-400">
                                        {{ $enrollment->student->student_id }}
                                    </div>
                                </div>
                            </div>

                            <!-- Attendance Status -->
                            <div class="col-span-4 flex items-center justify-end">
                                @if ($classroom_session->is_finished == 0)
                                    <!-- Editable Status (Session Ongoing) -->
                                    <label class="inline-flex items-center cursor-pointer group">
                                        <input type="checkbox"
                                            name="attendance[{{ $enrollment->id }}]"
                                            value="present"
                                            class="attendance-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 dark:border-gray-600 dark:checked:bg-blue-600 dark:checked:border-blue-600"
                                            @if($enrollment->getAttendanceForSession($classroom_session->id)?->status == true) checked @endif>
                                        <span class="ml-2 text-sm font-medium dark:text-gray-700 text-gray-300 dark:group-hover:text-blue-600 group-hover:text-blue-400 transition-colors">
                                            Present
                                        </span>
                                    </label>
                                @else
                                    @php
                                    $curr = $attendances->where('enrollment_id', $enrollment->id)->first();
                                    @endphp
                                    <div class="flex items-center">
                                        @if ($curr->status == true)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium dark:bg-green-100 dark:text-green-800 bg-green-900/30 text-green-400">
                                                <svg class="-ml-0.5 mr-1.5 h-3 w-3 dark:text-green-500 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Present
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium dark:bg-red-100 dark:text-red-800 bg-red-900/30 text-red-400">
                                                <svg class="-ml-0.5 mr-1.5 h-3 w-3 text-red-500 dark:text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Absent
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                @if ($classroom_session->is_finished == 0)
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkAllBtn = document.getElementById('check-all-btn');
                        const checkboxes = document.querySelectorAll('.attendance-checkbox');
                        let allChecked = false;

                        // Initialize button state based on current checkboxes
                        updateButtonState();

                        checkAllBtn.addEventListener('click', function() {
                            allChecked = !allChecked;

                            checkboxes.forEach(checkbox => {
                                checkbox.checked = allChecked;
                            });

                            updateButtonState();
                        });

                        // Update individual checkboxes to affect the "Check All" button state
                        checkboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                updateButtonState();
                            });
                        });

                        function updateButtonState() {
                            const checkedCount = document.querySelectorAll('.attendance-checkbox:checked').length;
                            allChecked = checkedCount === checkboxes.length;

                            if (allChecked) {
                                checkAllBtn.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Uncheck All
                                `;
                                checkAllBtn.classList.remove('bg-gray-200', 'dark:bg-gray-700');
                                checkAllBtn.classList.add('bg-blue-100', 'text-blue-800', 'dark:bg-blue-900/50', 'dark:text-blue-400');
                            } else {
                                checkAllBtn.innerHTML = `
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Check All
                                `;
                                checkAllBtn.classList.remove('bg-blue-100', 'text-blue-800', 'dark:bg-blue-900/50', 'dark:text-blue-400');
                                checkAllBtn.classList.add('bg-gray-200', 'dark:bg-gray-700');
                            }
                        }
                    });
                    </script>
                @endif
                </div>

                @if ($classroom_session->is_finished == 0)
                    <!-- Form Actions -->
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer">
                            Save Attendance
                        </button>
                    </div>
                @endif
            </form>
        </div>
        @endif
        @endlecturer
    </div>
</x-layout>
