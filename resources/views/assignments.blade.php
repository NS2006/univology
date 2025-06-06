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

    @lecturer
    <div>
        @if (!$unpublished_assignments->isEmpty())
        <h1>Unpublished Assignment</h1>
            @foreach ($unpublished_assignments as $unpublished_assignment)
                <a href="/assignment/{{  $unpublished_assignment->assignment_id }}"> {{ $unpublished_assignment->title }} </a>
            @endforeach
        @endif
    </div>
    @endlecturer

    <!-- Classroom Filter (if lecturer has multiple classes) -->
    {{-- @if($classrooms->count() > 1)
    <div class="mb-6">
        <label for="classroom-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Class</label>
        <select id="classroom-filter" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="all">All Classes</option>
            @foreach($classrooms as $classroom)
            <option value="{{ $classroom->class_id }}">{{ $classroom->class_code }} - {{ $classroom->course->name }}</option>
            @endforeach
        </select>
    </div>
    @endif --}}

    <!-- Assignments List -->
    {{-- <div class="space-y-4">
        @forelse($assignments as $assignment)
        <a href="/assignment/{{ $assignment->assignment_id }}" class="block group">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-l-4 border-blue-500 group-hover:border-blue-600">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">
                            {{ $assignment->title }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $assignment->classroom->class_code }} - {{ $assignment->classroom->course->name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $assignment->deadline->isPast() ? 'red' : 'green' }}-100 text-{{ $assignment->deadline->isPast() ? 'red' : 'green' }}-800 dark:bg-{{ $assignment->deadline->isPast() ? 'red' : 'green' }}-900/50 dark:text-{{ $assignment->deadline->isPast() ? 'red' : 'green' }}-400">
                            {{ $assignment->deadline->isPast() ? 'Closed' : 'Open' }}
                        </span>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Due: {{ $assignment->deadline->format('M d, Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $assignment->submissions_count }} submissions
                    </div>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400 group-hover:text-blue-800 dark:group-hover:text-blue-300">
                        View details →
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No assignments yet</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new assignment.</p>
            <div class="mt-6">
                <a href="/assignment/new-assignment" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create First Assignment
                </a>
            </div>
        </div>
        @endforelse
    </div> --}}

    {{-- @push('scripts')
    <script>
        // Classroom filter functionality
        document.getElementById('classroom-filter').addEventListener('change', function() {
            const classId = this.value;
            if(classId === 'all') {
                window.location.href = '/assignments';
            } else {
                window.location.href = `/assignments?class=${classId}`;
            }
        });
    </script>
    @endpush --}}
</x-layout>
