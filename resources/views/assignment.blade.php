@php
    $assignmentUrl = "/assignment/" . $assignment->assignment_id;
@endphp

<x-layout>
    <x-slot:title>{{ $assignment->title }}</x-slot:title>
    <x-slot:header>{{ $assignment->title }}</x-slot:header>

    <div class="container mx-auto px-4 py-2">
        <!-- Navigation Menu -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
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
            <!-- View Score Card -->
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
            </a>

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
    </div>

</x-layout>
