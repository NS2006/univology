<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>My Assignments</x-slot:header>

    @lecturer
    <!-- New Assignment Button -->
    <div class="flex justify-end mb-6">
        <button data-modal-target="new-assignment-modal" data-modal-toggle="new-assignment-modal"
            class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-lg shadow-md flex items-center gap-2 transition-all duration-200 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            New Assignment
        </button>
    </div>

    <!-- Assignment Creation Modal -->
    <div id="new-assignment-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-700 bg-blue-50 dark:bg-gray-700/50">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create New Assignment
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer"
                        data-modal-hide="new-assignment-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id="assignment-form" action="/assignment/new-assignment" method="POST">
                        @csrf

                        <!-- Title Field -->
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Assignment Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Enter assignment title" required>
                        </div>

                        <!-- Class Selection -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Select Classes <span class="text-red-500">*</span>
                            </label>

                            @forelse($classrooms as $classroom)
                                <div class="flex items-center mb-2">
                                    <input id="class-{{ $classroom->id }}" type="radio" name="classrooms[]"
                                        value="{{ $classroom->id }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="class-{{ $classroom->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $classroom->class_code }} - {{ $classroom->course->name }}
                                    </label>
                                </div>
                            @empty
                                <div class="p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-900/30 dark:text-yellow-300">
                                    <span class="font-medium">No classes found!</span> You need to be assigned to at least one course to create assignments.
                                </div>
                            @endforelse
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button data-modal-hide="new-assignment-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" form="assignment-form" class="text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-800 transition-all duration-200 cursor-pointer">
                        Create Assignment
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endlecturer

    <div class="container mx-auto px-4 py-8">
        <!-- Published Assignments Section -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white dark:text-gray-900">Published Assignments</h2>
                <div class="text-sm text-gray-300 dark:text-gray-600">
                    {{ $assignments->where('is_published', true)->count() }} assignments
                </div>
            </div>

            @if($assignments->where('is_published', true)->isEmpty())
                <div class="text-center py-12 dark:bg-white/50 bg-gray-800/50 rounded-lg border border-dashed border-gray-700 dark:border-gray-300">
                    <svg class="w-12 h-12 mx-auto dark:text-gray-400 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-200 dark:text-gray-700">No published assignments</h3>
                    <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Check back later for new assignments</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($assignments->where('is_published', true) as $assignment)
                        <a href="/assignment/{{ $assignment->assignment_id }}"
                        class="group relative block p-6 dark:bg-white bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all border dark:border-gray-200 border-gray-700 dark:hover:border-blue-500 hover:border-blue-400 overflow-hidden">
                            <!-- Status ribbon -->
                            <div class="absolute top-0 right-0 dark:bg-blue-600 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                                {{ $assignment->deadline && now()->gt($assignment->deadline) ? 'CLOSED' : 'ACTIVE' }}
                            </div>

                            <h3 class="mb-3 text-lg font-bold dark:text-gray-900 text-white dark:group-hover:text-blue-600 group-hover:text-blue-400 transition-colors">
                                {{ $assignment->title }}
                            </h3>

                            <div class="flex items-center text-sm dark:text-gray-500 text-gray-400 mb-3">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $assignment->classroom->course->name }}
                            </div>

                            <div class="flex items-center text-sm dark:text-gray-500 text-gray-400 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ $assignment->classroom->class_code }}
                            </div>

                            <div class="flex justify-between items-center pt-3 border-t dark:border-gray-100 border-gray-700">
                                <span class="text-sm font-medium {{ $assignment->deadline && now()->gt($assignment->deadline) ? 'text-red-500' : 'text-blue-500' }}">
                                    @if($assignment->deadline)
                                        {{ now()->gt($assignment->deadline) ? 'Closed' : 'Due' }}:
                                        {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y') }}
                                    @else
                                        No deadline
                                    @endif
                                </span>
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full dark:bg-blue-100 bg-blue-900/50 dark:text-blue-600 text-blue-300 dark:group-hover:bg-blue-200 group-hover:bg-blue-800 transition-colors">
                                    &rarr;
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Unpublished Assignments Section (Lecturer only) -->
        @lecturer
        @if(!$unpublished_assignments->isEmpty())
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white dark:text-gray-900">Draft Assignments</h2>
                <div class="text-sm text-gray-300 dark:text-gray-600">
                    {{ $unpublished_assignments->count() }} drafts
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($unpublished_assignments as $assignment)
                    <a href="/assignment/{{ $assignment->assignment_id }}"
                    class="group relative block p-6 dark:bg-white bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all border-2 border-dashed dark:border-gray-300 border-gray-600 dark:hover:border-yellow-400 hover:border-yellow-500 overflow-hidden">
                        <!-- Draft badge -->
                        <div class="absolute top-0 right-0 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                            DRAFT
                        </div>

                        <h3 class="mb-3 text-lg font-bold dark:text-gray-900 text-white dark:group-hover:text-yellow-600 group-hover:text-yellow-400 transition-colors">
                            {{ $assignment->title }}
                        </h3>

                        <div class="flex items-center text-sm dark:text-gray-500 text-gray-400 mb-3">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ $assignment->classroom->course->name }}
                        </div>

                        <div class="flex items-center text-sm dark:text-gray-500 text-gray-400 mb-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            {{ $assignment->classroom->class_code }}
                        </div>

                        <div class="flex justify-between items-center pt-3 border-t dark:border-gray-100 border-gray-700">
                            <span class="text-sm font-medium dark:text-gray-500 text-gray-400">
                                Created: {{ $assignment->created_at->format('M d, Y') }}
                            </span>
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full dark:bg-yellow-100 bg-yellow-900/50 dark:text-yellow-600 text-yellow-300 dark:group-hover:bg-yellow-200 group-hover:bg-yellow-800 transition-colors">
                                &rarr;
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
        @endlecturer
    </div>
</x-layout>
