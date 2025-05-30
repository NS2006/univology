<x-layout>
    <x-slot:title>{{ $title}}</x-slot:title>
    @if ($step == 1)
        <x-slot:header>Course Registration | Choose Faculty</x-slot:header>
    @elseif ($step == 2)
        <x-slot:header>Course Registration | Course Infomation</x-slot:header>
    @elseif ($step == 3)
        <x-slot:header>Course Registration | Session Information</x-slot:header>
    @else
        <x-slot:header>Course Registration | Confirmation</x-slot:header>
    @endif

    <div class="px-4 md:px-8">
        @if (session('registration.course.success'))
            <div id="pop-up-register" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-opacity-50">
                <div class="relative w-full max-w-2xl">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-6 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                New Course has been created successfully!
                            </h3>
                            <button type="button" onclick="closeModal()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="flex items-center w-full px-4">
            @for ($curr = 1; $curr <= 4; $curr++)
                @if ($step >= $curr)
                    <a href="{{ route('register.course.course_route', ['course_route' => $course_routes[$curr]]) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500 text-white">
                        {{ $curr }}
                    </a>
                @else
                    <div class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-500 border border-gray-300 rounded-full">{{ $curr }}</div>
                @endif

                @if ($curr != 4)
                    @if ($step > $curr)
                        <div class="h-1 flex-1 bg-blue-500 animate-pulse"></div>
                    @else
                        <div class="h-1 flex-1 bg-gray-300"></div>
                    @endif
                @endif
            @endfor
        </div>

        <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

        <form method="POST" action="{{ route('register.course.store-data') }}">
            @csrf

            <input type="hidden" name="step" value="{{ $step }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6 mt-4">
                @if ($step == 1)
                    @foreach ($faculties as $faculty)
                    <label class="block faculty-label">
                        <input type="radio" name="faculty_id" value="{{ $faculty->id }}"
                            class="hidden peer faculty-radio"
                            {{ $selectedFaculty && $selectedFaculty->id == $faculty->id ? 'checked' : '' }}
                            onchange="handleFacultySelection(this)">
                        <div class="p-4 border rounded-lg cursor-pointer hover:bg-blue-200 transition-colors faculty-card
                            {{ $selectedFaculty && $selectedFaculty->id == $faculty->id ? 'bg-blue-200 border-blue-500' : '' }}">
                            <p class="font-medium">{{ $faculty->name }}</p>
                        </div>
                    </label>
                    @endforeach
                @endif

                @if ($step == 2)
                    <input type="hidden" name="course_id" value="{{ $courseId }}">

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Course Id:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $courseId }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label class="text-lg font-medium mb-2" for="course_name">Course Name:</label>
                        <input type="text" name="course_name" id="course_name" placeholder="Input Course Name" class="p-4 border rounded-lg bg-blue-50 w-full font-medium" required value="{{ old('course_name') }}">
                        @error('course_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full">
                        <label class="text-lg font-medium mb-2" for="course_credit">Course Credit:</label>
                        <input type="number" name="course_credit" id="course_credit" placeholder="Input Course Credit" class="p-4 border rounded-lg bg-blue-50 w-full font-medium" required min="1" value="{{ old('course_credit') }}">
                    </div>

                    <div class="col-span-full">
                        <label class="text-lg font-medium mb-2" for="assignment">Assignment Weight (%)</label>
                        <input type="number" name="assignment" id="assignment" placeholder="Input Assignment Weight" class="p-4 border rounded-lg bg-blue-50 w-full font-medium" required min="1" max="100" value="{{ old('assignment') }}">
                        @if ($errors->has('weight'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('weight') }}</p>
                        @endif
                    </div>

                    <div class="col-span-full">
                        <label class="text-lg font-medium mb-2" for="mid_exam">Mid Exam Weight (%):</label>
                        <input type="number" name="mid_exam" id="mid_exam" placeholder="Input Mid Exam Weight" class="p-4 border rounded-lg bg-blue-50 w-full font-medium" required min="1" max="100" value="{{ old('mid_exam') }}">
                        @if ($errors->has('weight'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('weight') }}</p>
                        @endif
                    </div>

                    <div class="col-span-full">
                        <label class="text-lg font-medium mb-2" for="final_exam">Final Exam Weight (%)</label>
                        <input type="number" name="final_exam" id="final_exam" placeholder="Input Final Exam Weight" class="p-4 border rounded-lg bg-blue-50 w-full font-medium" required min="1" max="100" value="{{ old('final_exam') }}">
                        @if ($errors->has('weight'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('weight') }}</p>
                        @endif
                    </div>

                    <div class="flex items-center mb-4">
                        <input type="checkbox" name="fill_session" id="fill_session" class="w-4 h-4 dark:text-blue-600 dark:bg-gray-200 dark:border-gray-300 rounded dark:focus:ring-blue-500 focus:ring-2">
                        <label for="fill_session" class="ml-2 text-sm font-medium dark:text-gray-900">
                            Fill session information using dummy data
                        </label>
                    </div>
                @endif

                @if ($step == 3)
                    <div class="col-span-full flex justify-between items-center mb-2">
                        <h2 class="font-bold text-2xl md:text-3xl dark:text-gray-800">Total Sessions: {{ $totalSession }}</h2>
                    </div>

                    @for ($curr = 1; $curr <= $totalSession; $curr++)
                        <div class="dark:bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border dark:border-gray-200 p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 rounded-full dark:bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="dark:text-blue-600 font-bold">{{ $curr }}</span>
                                </div>
                                <h3 class="text-xl font-semibold dark:text-gray-800">Session {{ $curr }}</h3>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="course_session_{{ $curr }}_title" class="block text-sm font-medium dark:text-gray-700 mb-1">Session Title</label>
                                    <input type="text" name="course_session_{{ $curr }}_title" id="course_session_{{ $curr }}_title" placeholder="E.g., Introduction to Course" class="w-full px-4 py-3 border dark:border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-200 transition-all" required
                                    @if(session()->has("registration.course.sessions")) value="{{ $sessions[$curr-1]['title'] }}"
                                    @elseif(session()->has("registration.course.fill_session")) value="{{ $sessionTitle . " $curr" }}" @endif>
                                </div>

                                <div>
                                    <label for="course_session_{{ $curr }}_topic" class="block text-sm font-medium dark:text-gray-700 mb-1">Session Topic</label>
                                    <input type="text" name="course_session_{{ $curr }}_topic" id="course_session_{{ $curr }}_topic" placeholder="E.g., Introduction to Course" class="w-full px-4 py-3 border dark:border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-200 transition-all" required
                                    @if(session()->has("registration.course.sessions")) value="{{ $sessions[$curr-1]['topic'] }}"
                                    @elseif(session()->has("registration.course.fill_session")) value="{{ $sessionTopic . " $curr" }}" @endif>
                                </div>

                                <div>
                                    <label for="course_session_{{ $curr }}_main_material" class="block text-sm font-medium dark:text-gray-700 mb-1">Material Link</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </div>
                                        <input type="url" name="course_session_{{ $curr }}_link" id="course_session_{{ $curr }}_link" placeholder="https://example.com/material" class="w-full pl-10 pr-4 py-3 border dark:border-gray-300 ronded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-200 transition-all" required
                                        @if(session()->has("registration.course.sessions")) value="{{ $sessions[$curr-1]['link'] }}"
                                        @elseif(session()->has("registration.course.fill_session")) value="{{ $sessionLink }}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif

                @if ($step == 4)
                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Course Id:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $courseId }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Course Name:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $courseName }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Assignment Weight:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $weight['assignment'] }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Mid Exam Weight:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $weight['mid_exam'] }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Final Exam Weight:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $weight['final_exam'] }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Course Credit:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $courseCredit }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Selected Faculty:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $selectedFaculty->name }}</p>
                        </div>
                    </div>

                    <!-- Sessions Information Section -->
                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Session Informations:</h3>
                    </div>

                    @foreach ($sessions as $session)
                        <div class="dark:bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow border dark:border-gray-200 p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-8 h-8 rounded-full dark:bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="dark:text-blue-600 font-bold">{{ $loop->iteration }}</span>
                                </div>
                                <h3 class="text-xl font-semibold dark:text-gray-800">Session {{ $loop->iteration }}</h3>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <p class="block text-sm dark:text-gray-700 mb-1">Session Title</p>
                                    <p class="w-full px-4 py-3 border dark:border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-200 transition-all"> {{ $session['title'] }} </p>
                                </div>

                                <div>
                                    <p class="block text-sm dark:text-gray-700 mb-1">Material Topic</p>
                                    <p class="w-full px-4 py-3 border dark:border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-200 transition-all"> {{ $session['topic'] }} </p>
                                </div>

                                <div>
                                    <p class="block text-sm dark:text-gray-700 mb-1">Material Link</p>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                        </div>
                                        <p class="w-full pl-10 pr-4 py-3 border dark:border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-200 transition-all"> {{ $session['link'] }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="flex justify-between mt-6">
                @if ($step != 1)
                    <a href="{{ route('register.course.course_route', ['course_route' => $course_routes[$step-1]]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Previous
                    </a>
                @else
                    <span class="px-4 py-2 bg-blue-500 text-white rounded-lg opacity-50 cursor-not-allowed">
                        Previous
                    </span>
                @endif

                <button type="submit" id="next-btn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors {{ !$canProceed ? 'opacity-50 cursor-not-allowed' : '' }} cursor-pointer" {{ !$canProceed ? 'disabled' : '' }}>
                    {{ $step != 4 ? "Next" : "Register New Course"}}
                </button>
            </div>
        </form>
    </div>

</x-layout>

<script>
    function closeModal() {
        document.getElementById('pop-up-register').remove();
        document.getElementById('pop-up-register').remove();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Check initial state
        updateNextButtonState();

        // Add event listeners for all radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', updateNextButtonState);
        });

        const courseNameInput = document.getElementById('course_name');
        const courseCreditInput = document.getElementById('course_credit');

        if (courseNameInput && courseCreditInput) {
            courseNameInput.addEventListener('input', updateNextButtonState);
            courseCreditInput.addEventListener('input', updateNextButtonState);
        }

        document.querySelectorAll('[id^="course_session_"]').forEach(input => {
            input.addEventListener('input', updateNextButtonState);
        });
    });

    function updateNextButtonState() {
        const nextButton = document.getElementById('next-btn');
        if (!nextButton) return;

        let hasSelection = false;
        const currentStep = document.querySelector('input[name="step"]').value;

        switch(currentStep) {
            case '1':
                hasSelection = document.querySelector('input[name="faculty_id"]:checked') !== null;
                break;
            case '2':
                const courseName = document.getElementById('course_name')?.value.trim();
                const courseCredit = document.getElementById('course_credit')?.value;
                hasSelection = courseName && courseName.length > 0 && courseCredit && courseCredit.length > 0;
                break;
            case '3':
                const allSessionsFilled = Array.from(document.querySelectorAll('[id^="course_session_"]')).every(input => {
                    return input.value.trim().length > 0;
                });
                hasSelection = allSessionsFilled;
                break;
            default:
                hasSelection = true;
        }

        // Update button state
        nextButton.disabled = !hasSelection;
        nextButton.classList.toggle('opacity-50', !hasSelection);
        nextButton.classList.toggle('cursor-not-allowed', !hasSelection);

        // Also update card highlights
        highlightSelectedItems();
    }

    function highlightSelectedItems() {
        // Highlight faculty if selected
        const selectedFacultyRadio = document.querySelector('.faculty-radio:checked');
        if (selectedFacultyRadio) {
            highlightSelectedCard(selectedFacultyRadio.closest('.faculty-label').querySelector('.faculty-card'));
        }
    }

    function highlightSelectedCard(selectedCard) {
        document.querySelectorAll('.faculty-card').forEach(card => {
            card.classList.remove('bg-blue-200', 'border-blue-500');
        });

        // Add highlight to selected card
        selectedCard.classList.add('bg-blue-200', 'border-blue-500');
    }

    function handleFacultySelection(radio) {
        if (radio.checked) {
            updateNextButtonState();
            highlightSelectedCard(radio.closest('.faculty-label').querySelector('.faculty-card'));
        }
    }
</script>
