<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>Welcome back, {{ auth()->user()->name }}</x-slot:header>

    {{-- Admin --}}
    @admin
    <div class="flex flex-wrap min-h-[70vh] mb-2.5">
        <!-- Section 1 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
            <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-gray-200 dark:border-gray-300 shadow-sm">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-900">Admin Activity Log</h3>
                    <hr class="my-4 h-px bg-gray-300 dark:bg-gray-400 border-0">
                </div>

                <!-- Logs Content - Scrollable Area -->
                <div class="overflow-y-auto flex-1 space-y-4">
                    @forelse ($histories as $history)
    <!-- Log Entry Card -->
    <div class="bg-white dark:bg-gray-100 rounded-lg p-4 mb-3 shadow-sm border border-gray-200 dark:border-gray-300 hover:shadow-md transition-shadow">
        <div class="flex items-start">
            <!-- Log Content -->
            <div class="flex-1">
                <!-- Action Type Badge -->
                @php
                    $actionType = strtolower(explode(' ', $history->description)[1]) ?? 'action';
                    $colorMap = [
                        'student' => 'bg-blue-100 text-blue-800 dark:bg-blue-200 dark:text-blue-900',
                        'classroom' => 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900',
                        'course' => 'bg-purple-100 text-purple-800 dark:bg-purple-200 dark:text-purple-900',
                        'lecturer' => 'bg-amber-100 text-amber-800 dark:bg-amber-200 dark:text-amber-900',
                        'faculty' => 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900',
                    ];
                    $badgeColor = $colorMap[$actionType] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-200 dark:text-gray-900';
                @endphp

                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full mb-2 {{ $badgeColor }}">
                    {{ ucfirst($actionType) }} created
                </span>

                <!-- Main Description -->
                <p class="text-sm font-medium text-gray-800 dark:text-gray-700 mb-2">
                    @php
                        // Extract the key parts from the description
                        $parts = explode(' - ', $history->description);
                        $namePart = $parts[0] ?? '';
                        $idPart = $parts[1] ?? '';
                        $name = preg_replace('/^New (Student|Classroom|Course|Lecturer|Faculty) named? /', '', $namePart);
                    @endphp

                    <span class="font-semibold">{{ $name }}</span>
                    @if($idPart)
                        <span class="text-gray-500 dark:text-gray-600 font-mono text-xs bg-gray-100 dark:bg-gray-200 px-1.5 py-0.5 rounded ml-1">
                            {{ explode(' ', $idPart)[0] }}
                        </span>
                    @endif
                </p>

                <!-- Timestamp -->
                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $history->created_at->diffForHumans() }} •
                    {{ $history->created_at->format('M j, Y \a\t h:i A') }}
                </div>
            </div>

            <!-- Status Icon -->
            <div class="ml-2 p-1 text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
    </div>
@empty
                        <!-- Empty State -->
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300 dark:text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>

                            <h3 class="text-xl font-bold text-gray-500 dark:text-gray-600 mb-2">No Activity Logs</h3>
                            <p class="text-gray-400 dark:text-gray-500 max-w-md mx-auto mb-6">
                                Admin activities will appear here once actions are performed in the system.
                            </p>

                            <button class="px-4 py-2 bg-blue-50 dark:bg-gray-700 text-blue-600 dark:text-blue-400 rounded-lg border border-blue-100 dark:border-gray-600 hover:bg-blue-100 dark:hover:bg-gray-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Refresh Logs
                            </button>
                        </div>
                    @endforelse
                </div>

                <!-- Footer (optional) -->
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-400 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-600">
                        {{ $histories->count() }} log entries
                    </p>
                </div>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
            <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-gray-200 dark:border-gray-300">
                <h3 class="text-2xl font-bold text-center">User's Report</h3>
                <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

                <div class="overflow-y-auto flex-1">
                    @forelse ($reports as $report)
                        <div class="flex items-center p-4 dark:hover:bg-gray-50 rounded-lg transition-colors cursor-pointer mb-3 border dark:border-gray-200 dark:shadow-sm dark:hover:shadow-md" data-modal-target="report-admin-{{ $report->id }}" data-modal-toggle="report-admin-{{ $report->id }}">
                            <div class="relative mr-4 flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center dark:bg-green-100 dark:text-green-600">
                                    @if($report->status)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center dark:bg-red-100 dark:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="absolute inset-0 rounded-full dark:bg-red-100 animate-pulse opacity-75"></div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex-1 min-w-0 font-bold">
                                <div class="flex items-baseline gap-3 mb-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium dark:bg-blue-100 dark:text-blue-800">
                                        {{ $report->user->role->name == 'student' ? $report->user->student->student_id : $report->user->lecturer->lecturer_id }}
                                    </span>

                                    <p class="text-base font-semibold dark:text-gray-900 truncate">
                                        {{ $report->user->name }}
                                    </p>
                                </div>

                                <p class="text-sm dark:text-gray-600 line-clamp-2">
                                    {{ $report->description }}
                                </p>

                                <p class="text-xs dark:text-gray-500 mt-1">
                                    Reported {{ $report->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark:text-gray-400 ml-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>


                        {{-- pop up --}}
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
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-500 dark:text-gray-600 mb-2">No Reports Found</h3>
                            <p class="text-gray-400 dark:text-gray-500">There are no reports to display at this time.</p>
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
                <div class="overflow-y-auto flex-1">
                    @forelse ($logs as $log)
                        <div class="flex items-start p-4 dark:hover:bg-gray-50 dark:bg-gray-100 rounded-lg transition-colors group mb-2">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                                {{ $log->user->role->name == 'student' ?
                                                    'dark:bg-blue-200 dark:text-blue-900' :
                                                    'dark:bg-purple-200 dark:text-purple-900' }}">
                                            {{ $log->user->role->name == 'student' ? $log->user->student->student_id : $log->user->lecturer->lecturer_id }}
                                        </span>


                                        <p class="text-base font-bold dark:text-gray-800 truncate">
                                            {{ $log->user->name }}
                                        </p>
                                    </div>


                                    <span class="text-sm font-medium dark:text-gray-600 whitespace-nowrap">
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <div class="mt-2 flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full
                                            {{ $log->type == 'logged in' ? 'dark:bg-green-200 dark:text-green-800' :
                                                'dark:bg-yellow-200 dark:text-yellow-800' }}">
                                        @if($log->type == 'logged in')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        @endif
                                    </span>

                                    <p class="text-sm font-bold
                                        {{ $log->type == 'logged in' ? 'text-green-800 dark:text-green-400' : 'text-yellow-800 dark:text-yellow-400' }}">
                                        {{ ucfirst($log->type) }}
                                    </p>

                                    <span class="text-xs font-medium dark:text-gray-500 ml-auto">
                                        {{ $log->created_at->format('M j, Y \a\t g:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-xl font-bold dark:text-gray-600 mb-2">No Activities Found</h3>
                            <p class="dark:text-gray-500">There are no activity logs to display yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endadmin


    {{-- Lecturer --}}
    @lecturer
    <div class="flex flex-wrap min-h-[70vh] mb-2.5">
        <!-- Section 1 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
            <div class="rounded-lg p-6 h-full flex flex-col flex-1 dark:bg-gray-200">
                <h3 class="text-2xl font-bold text-center dark:text-gray-800">Student's Coin Leaderboard</h3>
                <hr class="my-4 h-px bg-gray-300 dark:bg-gray-400 border-0">

                <div class="flex flex-col h-full max-h-[calc(70vh-150px)]">
                    <div class="flex justify-between items-center mb-4 px-2">
                        <h3 class="text-lg font-bold dark:text-gray-800">Top Students</h3>
                        <button class="text-sm dark:text-blue-600 hover:underline cursor-pointer" data-modal-target="show-leaderboard" data-modal-toggle="show-leaderboard">
                            See All →
                        </button>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto ">
                        {{-- pop up --}}
                        <div id="show-leaderboard" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t-lg bg-gray-50 dark:bg-gray-700 border-gray-200 dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            All Students
                                        </h3>
                                        <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-modal-hide="show-leaderboard">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>


                                    {{-- content --}}
                                    <div class="p-4 md:p-5 bg-white dark:bg-gray-800 max-h-[400px] overflow-y-auto flex-1">
                                        @forelse ($enrollments as $enrollment)
                                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm hover:shadow-md transition-all border border-gray-200 dark:border-gray-700 group">
                                                <div class="flex items-center gap-4">
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                                                        @switch($loop->iteration)
                                                            @case(1) bg-gradient-to-br from-amber-400 to-amber-600 text-white @break
                                                            @case(2) bg-gradient-to-br from-gray-300 to-gray-500 text-white @break
                                                            @case(3) bg-gradient-to-br from-amber-700 to-amber-900 text-white @break
                                                            @default bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                                        @endswitch
                                                        font-bold">
                                                        #{{ $loop->iteration }}
                                                    </div>

                                                    <!-- Student Info -->
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex justify-between items-baseline">
                                                            <p class="font-semibold text-gray-800 dark:text-gray-100 truncate">
                                                                {{ $enrollment->student->user->name }}
                                                            </p>
                                                            <span class="flex items-center text-sm font-bold text-amber-600 dark:text-amber-400">
                                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/>
                                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                                </svg>
                                                                {{ $enrollment->coin }}
                                                            </span>
                                                        </div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                                            {{ $enrollment->student->student_id }} • {{ $enrollment->classroom->class_code }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                                <h3 class="text-xl font-bold text-gray-500 mb-2">No Students Found</h3>
                                                <p class="text-gray-400">You don't have any students enrolled yet.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- content --}}
                        @forelse ($enrollments->take(5) as $enrollment)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm hover:shadow-md transition-all border border-gray-200 dark:border-gray-700 group mx-1">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                                    @switch($loop->iteration)
                                        @case(1) bg-gradient-to-br from-amber-400 to-amber-600 text-white @break
                                        @case(2) bg-gradient-to-br from-gray-300 to-gray-500 text-white @break
                                        @case(3) bg-gradient-to-br from-amber-700 to-amber-900 text-white @break
                                        @default bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                    @endswitch
                                    font-bold">
                                    #{{ $loop->iteration }}
                                </div>

                                <!-- Student Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline">
                                        <p class="font-semibold text-gray-800 dark:text-gray-100 truncate">
                                            {{ $enrollment->student->user->name }}
                                        </p>
                                        <span class="flex items-center text-sm font-bold text-amber-600 dark:text-amber-400">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/>
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            </svg>
                                            {{ $enrollment->coin }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ $enrollment->student->student_id }} • {{ $enrollment->classroom->class_code }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-500 mb-2">No Students Found</h3>
                            <p class="text-gray-400">You don't have any students enrolled yet.</p>
                        </div>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
          <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-gray-200 dark:border-gray-300">
            <h3 class="text-2xl font-bold text-center">User's Report</h3>
            <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

            <div class="overflow-y-auto flex-1">
                <p>content</p>
            </div>
          </div>
        </div>
    @endlecturer

    {{-- Student --}}
    @student
    <div class="flex flex-wrap min-h-[70vh] mb-2.5">
        <!-- Section 1 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
            <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-white shadow-sm dark:border-gray-700">
                <h3 class="text-2xl font-bold text-center dark:text-gray-800">Course Progress</h3>
                <hr class="my-4 h-px bg-gray-200 border-0 dark:bg-gray-700">

                <div class="overflow-y-auto flex-1 -mx-2 px-2">
                    @foreach ($enrollments as $enrollment)
                        <x-course-card :enrollment="$enrollment" class="mb-4" />
                    @endforeach
                </div>

                <!-- Empty State -->
                @if($enrollments->isEmpty())
                    <div class="flex flex-col items-center justify-center h-full text-gray-500 dark:text-gray-400">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-lg">No enrolled courses yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section 2 -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
          <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-gray-200 dark:border-gray-300">
            <h3 class="text-2xl font-bold text-center">User's Report</h3>
            <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

            <div class="overflow-y-auto flex-1">
                <p>content</p>
            </div>
          </div>
        </div>
    @endstudent

    @user
        <!-- Upcoming Class Section -->
        <div class="w-full md:w-1/3 p-4 h-[70vh]">
            <div class="border rounded-lg p-6 h-full flex flex-col dark:bg-white shadow-sm dark:border-gray-700">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-900">Upcoming Class</h3>
                    <hr class="my-4 h-px bg-gray-300 dark:bg-gray-400 border-0">
                </div>

                <div class="overflow-y-auto flex-1 space-y-6">
                    <!-- Class Card -->
                    <div class="dark:bg-white rounded-lg p-5 shadow-sm border dark:border-gray-200">
                        <div class="flex items-start mb-3">
                            <div class="bg-blue-100 dark:bg-blue-200 p-3 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">{{ $topSession->classroom->course->name }}</h4>
                                <p class="text-sm text-gray-600">Code: {{ $topSession->classroom->class_code }}</p>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500">Session</p>
                                <p class="font-medium">{{ $topSession->course_session->session_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Date</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($topSession->date)->format('D, M j') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Time</p>
                                <p class="font-medium">
                                    {{ \Carbon\Carbon::parse($topSession->start_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($topSession->end_time)->format('h:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Lecturer</p>
                                <p class="font-medium">{{ $topSession->classroom->lecturer->user->name }}</p>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="/classroom/{{ $topSession->classroom->class_id }}/session/{{ $topSession->classroom_session_id }}" class="mt-6 block">
                            <button class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center space-x-2 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>View Classroom</span>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @enduser
</x-layout>
