<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>Welcome back, {{ auth()->user()->name }}</x-slot:header>

    {{-- Admin --}}
    @admin
    <div class="flex flex-wrap min-h-[70vh] mb-2.5">
        <!-- Section 1 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
          <div class="border rounded-lg p-6 h-full">
            <h3 class="text-xl font-bold mb-4">Section 1</h3>
            <p>Content goes here</p>
          </div>
        </div>

        <!-- Section 2 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
          <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-gray-200 dark:border-gray-300">
              <h3 class="text-2xl font-bold text-center">User's Report</h3>
              <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

              <div class="overflow-y-auto flex-1">
                @forelse ($reports as $report)
                    {{-- content --}}
                    <div class="flex items-center p-2 dark:hover:bg-gray-100 rounded-lg transition-colors cursor-pointer mb-4" data-modal-target="report-admin-{{ $report->id }}" data-modal-toggle="report-admin-{{ $report->id }}">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0 {{ $report->status ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            @if($report->status)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="text-base text-gray-700 dark:text-gray-800">
                            @if ($report->user->role->name == 'student')
                                <p>{{ $report->user->student->student_id }} - {{ $report->user->name }}: <b>{{ $report->description }}</b></p>
                            @else
                                <p>{{ $report->user->lecturer->lecturer_id }} - {{ $report->user->name }}: <b>{{ $report->description }}</b></p>
                            @endif
                        </div>
                    </div>

                    <div id="report-admin-{{ $report->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t-lg bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Report#{{ $report->id }}
                                    </h3>
                                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-modal-hide="report-admin-{{ $report->id }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 bg-white dark:bg-gray-800">
                                    <form class="space-y-4" action="/solve/report" method="POST">
                                    @csrf
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">

                                        <div class="dark:text-gray-50">
                                            <div class="p-6 space-y-4">
                                                <div class="p-3 rounded-lg {{ $report->status ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }}">
                                                    <h4 class="font-medium text-gray-700 dark:text-gray-200">Status:</h4>
                                                    <p class="{{ $report->status ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }} font-medium">
                                                        {{ $report->status ? '✓ Resolved' : '✗ Pending' }}
                                                    </p>
                                                </div>

                                                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                                    <h4 class="font-medium text-gray-700 dark:text-gray-200">Reported by:</h4>
                                                    <p class="text-gray-800 dark:text-gray-100">
                                                        @if($report->user->role->name == 'student')
                                                            {{ $report->user->student->student_id }} -
                                                        @else
                                                            {{ $report->user->lecturer->lecturer_id }} -
                                                        @endif
                                                        <span class="font-medium">{{ $report->user->name }}</span>
                                                    </p>
                                                </div>

                                                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                                    <h4 class="font-medium text-gray-700 dark:text-gray-200">Description:</h4>
                                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                                        {{ $report->description }}
                                                    </p>
                                                </div>

                                                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                                    <h4 class="font-medium text-gray-700 dark:text-gray-200">Date Reported:</h4>
                                                    <p class="text-gray-600 dark:text-gray-300">
                                                        {{ $report->created_at->format('M d, Y \a\t H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors duration-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            {{ $report->status ? 'Reopen Report' : 'Mark as Resolved' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-gray-500">
                        No reports found
                    </div>
                    @endforelse
                </div>

                {{-- pop up script --}}
                @if (session('success-solve-report'))
                    <script>
                        const reportId = {{ session('report-id') }};
                        console.log(reportId)

                        document.addEventListener('DOMContentLoaded', async function() {
                            const modalToggle = document.querySelector(`[data-modal-toggle="report-admin-${reportId}"]`);
                            const modal = document.getElementById(`report-admin-${reportId}`);

                            modalToggle.click();
                            modal.classList.add('hidden');
                            setTimeout(() => modalToggle.click(), 500);
                        });
                    </script>
                @endif
          </div>
        </div>

        <!-- Section 3 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
            <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-gray-200 dark:border-gray-300">
                <h3 class="text-2xl font-bold text-center">Today's Logs</h3>
                <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">
                <div class="overflow-y-auto flex-1"> <!-- Scrollable area -->
                    <!-- Long content -->
                    @forelse ($logs as $log)
                        <div class="flex items-center p-2 dark:hover:bg-gray-200 rounded-lg transition-colors">
                            <div class="w-3 h-3 rounded-full {{ $log->type == 'logged in' ? "bg-green-300" : "bg-yellow-300" }} mr-3 flex-shrink-0"></div>
                            <div class="text-base text-gray-700 dark:text-gray-800">
                                @if ($log->user->role->name == 'student')
                                    <h4><b>{{ $log->user->student->student_id }}</b> - <b>{{ $log->user->name }}</b> {{ $log->type }} at {{ $log->created_at }}</h4>
                                @else
                                    <h4><b>{{ $log->user->lecturer->lecturer_id }}</b> - <b>{{ $log->user->name }}</b> {{ $log->type }} at {{ $log->created_at }}</h4>
                                @endif
                            </div>
                        </div>
                    @empty
                        {{-- soon --}}
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- <h1>Report</h1>
    @forelse ($reports as $report)
        @if ($report->user->role->name == 'student')
            <p>{{ $report->user->student->student_id }} - {{ $report->user->name }}: <b>{{ $report->description }}</b></p>
        @else
            <p>{{ $report->user->lecturer->lecturer_id }} - {{ $report->user->name }}: <b>{{ $report->description }}</b></p>
        @endif
    @empty
    <h3>There's no report</h3>
    <h3>You can relax</h3>
    @endforelse


    <h1>Today's Activity Log</h1>
    @forelse ($logs as $log)
        @if ($log->user->role->name == 'student')
            <h4>{{ $log->user->student->student_id }} - {{ $log->user->name }} {{ $log->type }} at {{ $log->created_at }}</h4>
        @else
            <h4>{{ $log->user->lecturer->lecturer_id }} - {{ $log->user->name }} {{ $log->type }} at {{ $log->created_at }}</h4>
        @endif
    @empty
        <h4>There is no activity logs for today</h4>
    @endforelse --}}


    @endadmin

    @user
    @forelse ($classrooms as $classroom)
        <h1>{{ $classroom->class_code }}</h1>
    @empty
        <h1>Empty</h1>
    @endforelse
    @enduser

    {{-- Lecturer --}}
    @lecturer
    <h1>Lecturer Page</h1>
    @endlecturer

    {{-- Student --}}
    @student
    <h1>Student Page</h1>
    @endstudent
</x-layout>
