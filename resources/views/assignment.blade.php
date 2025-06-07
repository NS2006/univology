@php
    $assignmentUrl = "/assignment/" . $assignment->assignment_id;
@endphp

<x-layout>
    <x-slot:title>{{ $assignment->title }}</x-slot:title>
    <x-slot:header>{{ $assignment->title }}</x-slot:header>

    <div class="container mx-auto px-4 py-2">
        <!-- Navigation Menu -->
        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
            <!-- Session Card -->
            <a href="{{ $assignmentUrl }}"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-blue-500 hover:border-blue-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-blue-100 bg-blue-900/50 dark:text-blue-600 text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-blue-600 group-hover:text-blue-400">Assignment Details</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">Access the assignment page</p>
                    </div>
                </div>
            </a>

            @lecturer
            {{-- <!-- View Score Card -->
            <a href="{{ $assignmentUrl }}/view-score"
            class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-yellow-500 hover:border-yellow-500">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full dark:bg-yellow-100 bg-yellow-900/50 dark:text-yellow-600 text-yellow-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-yellow-600 group-hover:text-yellow-400">Student Scores</h3>
                        <p class="text-sm dark:text-gray-500 text-gray-400">See how students performed</p>
                    </div>
                </div>
            </a> --}}

            <!-- Delete Assignment Card -->
            @if ($assignment->is_published == false)
                <button data-modal-target="delete-assignment-tab" data-modal-toggle="delete-assignment-tab" class="group dark:bg-white bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow p-6 border dark:border-gray-200 border-gray-700 dark:hover:border-red-500 hover:border-red-500 cursor-pointer" type="button">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-full dark:bg-red-100 bg-red-900/50 dark:text-red-600 text-red-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold dark:text-gray-800 text-gray-200 dark:group-hover:text-red-600 group-hover:text-red-400 text-left">Delete Assignment</h3>
                            <p class="text-sm dark:text-gray-500 text-gray-400">Discard before publishing</p>
                        </div>
                    </div>
                </button>

                <!-- Main modal -->
                <div id="delete-assignment-tab" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <form action="{{ $assignmentUrl }}/delete-assignment" method="POST">\
                            @csrf

                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Confirm Deletion Assignment
                                        </h3>
                                    </div>
                                    <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="delete-assignment-tab">
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
                                            <span class="font-medium">Important:</span> This action cannot be undone. Do you want delete this assignment?.
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <div class="flex items-center justify-end p-5 border-t border-gray-200 rounded-b dark:border-gray-600 space-x-3">
                                    <button type="button"
                                            class="cursor-pointer text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                                            data-modal-hide="delete-assignment-tab">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Confirm Deletion
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @endlecturer
        </div>

        @if ($page == 'home')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @lecturer
                <!-- Assignment Status Card -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 border dark:border-gray-200 border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium dark:text-gray-500 text-gray-400">Assignment Status</h3>
                            <p class="mt-2 text-2xl font-semibold">
                                {{ $assignment->is_published ? 'Published' : 'Draft' }}
                            </p>
                        </div>
                        <div class="p-3 rounded-full {{ $assignment->is_published ? 'dark:bg-green-100 bg-green-900/50 dark:text-green-600 text-green-400' : 'dark:bg-yellow-100 bg-yellow-900/50 dark:text-yellow-600 text-yellow-400' }}">
                            @if($assignment->is_published)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
                @endlecturer

                @student
                <!-- Score Card -->
                {{-- <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 border dark:border-gray-200 border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium dark:text-gray-500 text-gray-400"></h3>
                            <p class="mt-2 text-2xl font-semibold">
                                {{ $assignment->is_published ? 'Published' : 'Draft' }}
                            </p>
                        </div>
                        <div class="p-3 rounded-full {{ $assignment->is_published ? 'dark:bg-green-100 bg-green-900/50 dark:text-green-600 text-green-400' : 'dark:bg-yellow-100 bg-yellow-900/50 dark:text-yellow-600 text-yellow-400' }}">
                            @if($assignment->is_published)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div> --}}
                @endstudent

                <!-- Deadline Card -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 border dark:border-gray-200 border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium dark:text-gray-500 text-gray-400">Deadline</h3>
                            <p class="mt-2 text-2xl font-semibold">
                                {{ $deadline }}
                            </p>
                            @if($assignment->deadline)
                                <p class="mt-1 text-sm {{ \Carbon\Carbon::now()->gt($assignment->deadline) ? 'text-red-500' : 'dark:text-gray-500 text-gray-400' }}">
                                    {{ $deadline_passed }}
                                </p>
                            @endif
                        </div>
                        <div class="p-3 rounded-full dark:bg-blue-100 bg-blue-900/50 dark:text-blue-600 text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Questions Count Card -->
                <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 border dark:border-gray-200 border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium dark:text-gray-500 text-gray-400">Questions</h3>
                            <p class="mt-2 text-2xl font-semibold">
                                {{ $assignment->questions->count() }}
                            </p>
                        </div>
                        <div class="p-3 rounded-full dark:bg-purple-100 bg-purple-900/50 dark:text-purple-600 text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Description Section -->
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow p-6 border dark:border-gray-200 border-gray-700 mb-8">
                <h3 class="text-lg font-medium dark:text-gray-500 text-gray-400 mb-6 pb-2 border-b dark:border-gray-200 border-gray-700">Assignment Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Course Info -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 p-3 dark:bg-blue-100 bg-blue-900/30 rounded-lg dark:text-blue-600 text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium dark:text-gray-500 text-gray-400">Course</h4>
                            <p class="mt-1 text-lg font-semibold dark:text-gray-900 text-white">{{ $course_name }}</p>
                        </div>
                    </div>

                    <!-- Class Info -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 p-3 dark:bg-green-100 bg-green-900/30 rounded-lg dark:text-green-600 text-green-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium dark:text-gray-500 text-gray-400">Class</h4>
                            <p class="mt-1 text-lg font-semibold dark:text-gray-900 text-white">{{ $classroom_code }}</p>
                        </div>
                    </div>

                    <!-- Start Date -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 p-3 dark:bg-purple-100 bg-purple-900/30 rounded-lg dark:text-purple-600 text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium dark:text-gray-500 text-gray-400">Started At</h4>
                            <p class="mt-1 text-lg font-semibold dark:text-gray-900 text-white">
                                    {{ \Carbon\Carbon::parse($started_at)->format('M d, Y H:i') }}
                            </p>
                            <p class="mt-1 text-sm dark:text-gray-500 text-gray-400">
                                {{ \Carbon\Carbon::parse($started_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <!-- Deadline Section -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 p-3 {{ $finished_at ? 'dark:bg-yellow-100 bg-yellow-900/30 dark:text-yellow-600 text-yellow-400' : 'dark:bg-gray-100 bg-gray-700 dark:text-gray-500 text-gray-400' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium dark:text-gray-500 text-gray-400">Finished At</h4>
                            @if($finished_at)
                                <p class="mt-1 text-lg font-semibold dark:text-gray-900 text-white">
                                    {{ \Carbon\Carbon::parse($finished_at)->format('M d, Y H:i') }}
                                </p>
                                @if(\Carbon\Carbon::now()->gt($finished_at))
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium dark:bg-red-100 dark:text-red-800 bg-red-900 text-red-200">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Deadline Passed
                                        </span>
                                        <span class="ml-2 text-sm dark:text-gray-500 text-gray-400">
                                            {{ \Carbon\Carbon::parse($finished_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                @else
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium dark:bg-green-100 dark:text-green-800 bg-green-900 text-green-200">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Active
                                        </span>
                                        <span class="ml-2 text-sm dark:text-gray-500 text-gray-400">
                                            Due in {{ \Carbon\Carbon::parse($finished_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                @endif
                            @else
                                <p class="mt-1 text-lg font-semibold dark:text-gray-900 text-white">-</p>
                                <div class="mt-1 flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium dark:bg-blue-100 dark:text-blue-800 bg-blue-900 text-blue-200">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Open-ended
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            @lecturer
            <div class="flex justify-center mb-8">
                <div class="inline-flex flex-wrap gap-4 dark:bg-white bg-gray-800 rounded-lg shadow p-4 border dark:border-gray-200 border-gray-700">
                    @if(!$assignment->is_published)
                        <button data-modal-target="pre-publish-tab" data-modal-toggle="pre-publish-tab" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors cursor-pointer" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            Publish
                        </button>

                        <!-- Main modal -->
                        <div id="pre-publish-tab" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Do you want to report something?
                                        </h3>
                                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-modal-hide="pre-publish-tab">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    <!-- Publish Assignment Modal -->
                                    <div class="p-4 md:p-5">
                                        <form class="space-y-4" action="{{ $assignmentUrl }}/publish" method="POST">
                                            @csrf
                                            <!-- Deadline Date Picker -->
                                            <div>
                                                <label for="deadline_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    Deadline Date
                                                </label>
                                                <input type="date" name="deadline_date" id="deadline_date" min="{{ now()->format('Y-m-d') }}" value="{{ old('deadline_date') }}" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white {{ $errors->has('deadline_date') ? 'border-red-500' : 'border-gray-300' }}" required />
                                                @if ($errors->has('deadline_date'))
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $errors->first('deadline_date') }}</p>
                                                @endif
                                            </div>

                                            <!-- Deadline Time Picker -->
                                            <div>
                                                <label for="deadline_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    Deadline Time
                                                </label>
                                                <input type="time" name="deadline_time" id="deadline_time" value="{{ old('deadline_time', '23:59') }}" class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white     {{ $errors->has('deadline_time') ? 'border-red-500' : 'border-gray-300' }}" required />
                                                @if ($errors->has('deadline_time'))
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $errors->first('deadline_time') }}</p>
                                                @endif
                                            </div>

                                            <!-- Confirmation Checkbox -->
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input id="publish_confirm" name="publish_confirm" type="checkbox" class="w-4 h-4 border rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 {{ $errors->has('publish_confirm') ? 'border-red-500' : 'border-gray-300' }}" {{ old('publish_confirm') ? 'checked' : '' }} />
                                                </div>
                                                <label for="publish_confirm" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    I confirm that I want to publish this assignment to students
                                                </label>
                                            </div>
                                            @if ($errors->has('publish_confirm'))
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $errors->first('publish_confirm') }}</p>
                                            @endif

                                            @if(session('error_choice'))
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ session('error_choice') }}</p>
                                            @endif

                                            <!-- Submit Button -->
                                            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
                                                Publish Assignment
                                            </button>


                                            {{-- Script --}}
                                            @if ($errors->has('deadline_time') || $errors->has('deadline_date') || $errors->has('publish_confirm') || session()->has('error_choice'))
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', async function() {
                                                        const modalToggle = document.querySelector('[data-modal-toggle="pre-publish-tab"]');
                                                        const modal = document.getElementById('pre-publish-tab');

                                                        modalToggle.click();
                                                        modal.classList.add('hidden');
                                                        setTimeout(() => modalToggle.click(), 500);
                                                    });
                                                </script>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <a href="{{ $assignmentUrl }}/question" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $assignment->is_published ? 'View Questions' : 'Manage Questions' }}
                    </a>
                </div>
            </div>
            @endlecturer

            @student
            @if (!$assignment->isDeadlinePassed() && !$is_finished)
                @php
                $enrollment = Auth::user()->student->enrollments
                    ->firstWhere('classroom_id', $assignment->classroom_id);


                $entry = $enrollment
                    ? $assignment->assignment_entries->firstWhere('enrollment_id', $enrollment->id)
                    : null;

                if($entry != null){
                    $entry = true;
                } else{
                    $entry = false;
                }
                @endphp

                <div class="flex justify-center mb-8">
                    <div class="inline-flex flex-wrap gap-4 dark:bg-white bg-gray-800 rounded-lg shadow p-4 border dark:border-gray-200 border-gray-700">
                        <a href="{{ $assignmentUrl }}/do-question" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $entry ? 'Continue Assignment' : 'Start Assignment'}}
                        </a>
                    </div>
                </div>
            @endif
            @endstudent
        @endif
    </div>

</x-layout>
