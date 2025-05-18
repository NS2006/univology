@student
<a href="/classroom/{{ $enrollment->classroom->class_id }}">
@endstudent

@lecturer
<a href="/classroom/{{ $classroom->class_id }}">
@endlecturer

    <div class="group mb-6 p-6 dark:bg-white rounded-xl dark:shadow-md hover:shadow-lg transition-all duration-300 bg-gray-800 border-gray-700 cursor-pointer relative overflow-hidden">
        <!-- Clickable overlay (entire card) -->
        <div class="absolute inset-0 z-0 opacity-0 group-hover:opacity-10 dark:bg-blue-500 transition-opacity duration-300"></div>
        @student
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div>
                    <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider dark:text-blue-800 uppercase dark:bg-blue-100 rounded-full bg-blue-900 text-blue-200">
                        {{ $enrollment->classroom->course->course_id }}
                    </span>
                    <h2 class="mt-2 text-xl font-bold dark:text-gray-800 dark:group-hover:text-blue-600 transition-colors">
                        {{ $enrollment->classroom->course->name }}
                    </h2>
                    <div class="flex flex-wrap gap-x-4">
                        <p class="text-sm dark:text-gray-400 dark:group-hover:text-gray-700 transition-colors">
                            Class: {{ $enrollment->classroom->class_code }}
                        </p>
                        <p class="text-sm dark:text-gray-400 dark:group-hover:text-gray-700 transition-colors">
                            Lecturer: {{ $enrollment->classroom->lecturer->lecturer_id }} - {{ $enrollment->classroom->lecturer->user->name }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="mt-6 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 dark:text-blue-600 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium dark:text-gray-700 text-gray-300">YOUR PROGRESS</span>
                    </div>
                    <span class="text-sm font-semibold dark:text-blue-600 text-blue-300">
                        {{ $enrollment->progress }}%
                    </span>
                </div>

                <div class="relative h-2.5 mb-4 overflow-hidden rounded-full dark:bg-gray-200 bg-gray-700">
                    <div class="absolute top-0 left-0 h-full rounded-full bg-gradient-to-r from-blue-500 via-teal-400 to-emerald-400"
                        style="width: {{ $enrollment->progress }}%"
                        x-data="{ progress: 0 }"
                        x-init="
                            setTimeout(() => {
                                let interval = setInterval(() => {
                                    progress += 5;
                                    if (progress >= `{{ $enrollment->progress }}`) clearInterval(interval);
                                    $el.style.width = `${progress}%`;
                                }, 50);
                            }, 300);">
                        <div class="absolute inset-0 bg-white opacity-20 animate-pulse"></div>
                    </div>
                </div>

                <div class="flex justify-between text-xs dark:text-gray-500 text-gray-400">
                    <span>0%</span>
                    <span>100%</span>
                </div>
            </div>
            @endstudent




        @lecturer
        <!-- Course Header -->
        <div class="flex items-start justify-between mb-4 relative z-10">
            <div>
                <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider dark:text-blue-800 uppercase dark:bg-blue-100 rounded-full bg-blue-900 text-blue-200">
                    {{ $classroom->course->course_id }}
                </span>
                <h2 class="mt-2 text-xl font-bold dark:text-gray-800 dark:group-hover:text-blue-600 transition-colors">
                    {{ $classroom->course->name }}
                </h2>
                <p class="text-sm dark:text-gray-400 dark:group-hover:text-gray-700 transition-colors">
                    Class: {{ $classroom->class_code }}
                </p>
            </div>
        </div>

        <!-- Progress Section -->
        <!-- Enhanced Stats Section -->
        <div class="mt-6 grid grid-cols-2 gap-4 relative z-10">
            <!-- Students Card -->
            <div class="p-3 dark:bg-blue-50 rounded-lg group-hover:shadow-sm transition-shadow">
                <div class="flex items-center">
                    <div class="p-2 mr-3 dark:bg-blue-100 rounded-full">
                        <svg class="w-5 h-5 dark:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold dark:text-blue-700">{{ $classroom->enrollments->count() }}</p>
                        <p class="text-xs dark:text-blue-600 font-bold">Students</p>
                    </div>
                </div>
            </div>

            <!-- Credit Card -->
            <div class="p-3 dark:bg-teal-50 rounded-lg group-hover:shadow-sm transition-shadow">
                <div class="flex items-center">
                    <div class="p-2 mr-3 dark:bg-teal-100 rounded-full">
                        <svg class="w-5 h-5 dark:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold dark:text-teal-700">{{ $classroom->course->credit }}</p>
                        <p class="text-xs dark:text-teal-600 font-bold">Course Credits</p>
                    </div>
                </div>
            </div>
        </div>
        @endlecturer
    </div>
</a>
