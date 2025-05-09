<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:header>Welcome back, {{ auth()->user()->name }}</x-slot:header>

    {{-- Admin --}}
    @admin
    <div class="flex flex-wrap min-h-[70vh] mb-2.5">
        <!-- Section 1 -->
        <div class="w-full md:w-1/3 p-4">
          <div class="border rounded-lg p-6 h-full">
            <h3 class="text-xl font-bold mb-4">Section 1</h3>
            <p>Content goes here</p>
          </div>
        </div>

        <!-- Section 2 -->
        <div class="w-full md:w-1/3 p-4">
          <div class="border rounded-lg p-6 h-full">
            <h3 class="text-xl font-bold mb-4">Section 2</h3>
            <p>Content goes here</p>
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

    {{-- Lecturer --}}
    @lecturer
    <h1>Lecturer Page</h1>
    @endlecturer

    {{-- Student --}}
    @student
    <h1>Student Page</h1>
    @endstudent
</x-layout>
