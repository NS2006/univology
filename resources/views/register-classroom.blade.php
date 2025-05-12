<x-layout>
    <x-slot:title>{{ $title}}</x-slot:title>
    @if ($step == 1)
        <x-slot:header>Classroom Registration | Choose Faculty</x-slot:header>
    @elseif ($step == 2)
        <x-slot:header>Classroom Registration | Choose Course</x-slot:header>
    @elseif ($step == 3)
        <x-slot:header>Classroom Registration | Choose Lecturer</x-slot:header>
    @elseif ($step == 4)
        <x-slot:header>Classroom Registration | Choose Student</x-slot:header>
    @else
        <x-slot:header>Classroom Registration | Confirmation</x-slot:header>
    @endif

    <div class="px-4 md:px-8">
        @if (session('registration.classroom.success'))
            <div id="pop-up-register" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-opacity-50">
                <div class="relative w-full max-w-2xl">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-6 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                New Classroom has been created successfully!
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
            @for ($curr = 1; $curr <= 5; $curr++)
                @if ($step >= $curr)
                    <a href="{{ route('register.classroom.classroom_route', ['classroom_route' => $classroom_routes[$curr]]) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500 text-white">
                        {{ $curr }}
                    </a>
                @else
                    <div class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-500 border border-gray-300 rounded-full">{{ $curr }}</div>
                @endif

                @if ($curr != 5)
                    @if ($step > $curr)
                        <div class="h-1 flex-1 bg-blue-500 animate-pulse"></div>
                    @else
                        <div class="h-1 flex-1 bg-gray-300"></div>
                    @endif
                @endif
            @endfor
        </div>

        <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

        <form method="POST" action="{{ route('register.classroom.store-data') }}">
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
                    @forelse ($courses as $course)
                    <label class="block">
                        <input type="radio" name="course_id" value="{{ $course->id }}"
                            class="hidden peer"
                            {{ $selectedCourse && $selectedCourse->id == $course->id ? 'checked' : '' }}
                            onchange="handleCourseSelection(this)">
                        <div class="p-4 border rounded-lg cursor-pointer hover:bg-blue-200 transition-colors course-card
                            {{ $selectedCourse && $selectedCourse->id == $course->id ? 'bg-blue-200 border-blue-500' : '' }}">
                            <p class="font-medium">{{ $course->course_id }} - {{ $course->name }}</p>
                        </div>
                    </label>
                    @empty
                    <div class="col-span-full flex justify-center items-center w-full h-full min-h-[200px]">
                        <p class="text-2xl font-medium text-center">
                            There is no Course in {{ $selectedFaculty->name }} Faculty
                        </p>
                    </div>
                    @endforelse
                @endif

                @if ($step == 3)
                    @forelse ($lecturers as $lecturer)
                    <label class="block">
                        <input type="radio" name="lecturer_id" value="{{ $lecturer->id }}"
                            class="hidden peer"
                            {{ $selectedLecturer && $selectedLecturer->id == $lecturer->id ? 'checked' : '' }}
                            onchange="handleLecturerSelection(this)">
                        <div class="p-4 border rounded-lg cursor-pointer hover:bg-blue-200 transition-colors lecturer-card
                            {{ $selectedLecturer && $selectedLecturer->id == $lecturer->id ? 'bg-blue-200 border-blue-500' : '' }}">
                            <p class="font-medium">{{ $lecturer->lecturer_id }} - {{ $lecturer->user->name }}</p>
                        </div>
                    </label>
                    @empty
                    <div class="col-span-full flex justify-center items-center w-full h-full min-h-[200px]">
                        <p class="text-2xl font-medium text-center">
                            There is no Lecturer in {{ $selectedFaculty->name }} Faculty
                        </p>
                    </div>
                    @endforelse
                @endif

                @if ($step == 4)
                    @forelse ($students as $student)
                    <label class="block">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                            class="hidden peer"
                            {{ in_array($student->id, $selectedStudentIds ?? []) ? 'checked' : '' }}
                            onchange="handleStudentSelection(this)">
                        <div class="p-4 border rounded-lg cursor-pointer hover:bg-blue-200 transition-colors student-card
                            {{ in_array($student->id, $selectedStudentIds ?? []) ? 'bg-blue-200 border-blue-500' : '' }}">
                            <p class="font-medium">{{ $student->student_id }} - {{ $student->user->name }}</p>
                        </div>
                    </label>
                    @empty
                    <div class="col-span-full flex justify-center items-center w-full h-full min-h-[200px]">
                        <p class="text-2xl font-medium text-center">
                            There is no Student in {{ $selectedFaculty->name }} Faculty
                        </p>
                    </div>
                    @endforelse
                @endif

                @if ($step == 5)
                    <input type="hidden" name="classCode" value="{{ $classCode }}">

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Class Code:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $classCode }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Select Schedule:</h3>
                        <select name="schedule" id="schedule" class="p-4 border rounded-lg bg-blue-50 w-full font-medium">
                            <option value="selectSchedule">Please Select The Schedule</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>
                        </select>

                        @error('schedule')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Selected Course:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $selectedCourse->course_id }} - {{ $selectedCourse->name }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Selected Lecturer:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $selectedLecturer->lecturer_id }} - {{ $selectedLecturer->user->name }}</p>
                        </div>
                    </div>

                    <!-- Selected Students Section -->
                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Selected Students:</h3>
                    </div>

                    @foreach ($selectedStudents as $student)
                    <div class="p-4 border rounded-lg bg-blue-50 transition-colors">
                        <p class="font-medium">{{ $student->student_id }} - {{ $student->user->name }}</p>
                    </div>
                    @endforeach
                @endif
            </div>

            <div class="flex justify-between mt-6">
                @if ($step != 1)
                    <a href="{{ route('register.classroom.classroom_route', ['classroom_route' => $classroom_routes[$step-1]]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Previous
                    </a>
                @else
                    <span class="px-4 py-2 bg-blue-500 text-white rounded-lg opacity-50 cursor-not-allowed">
                        Previous
                    </span>
                @endif

                <button type="submit" id="next-btn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors {{ !$canProceed ? 'opacity-50 cursor-not-allowed' : '' }} cursor-pointer" {{ !$canProceed ? 'disabled' : '' }}>
                    {{ $step != 5 ? "Next" : "Register New Classroom"}}
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
    });

    function updateNextButtonState() {
        const nextButton = document.getElementById('next-btn');
        if (!nextButton) return;

        // Determine if selection is made based on current step
        let hasSelection = false;
        const currentStep = document.querySelector('input[name="step"]').value;

        switch(currentStep) {
            case '1':
                hasSelection = document.querySelector('input[name="faculty_id"]:checked') !== null;
                break;
            case '2':
                hasSelection = document.querySelector('input[name="course_id"]:checked') !== null;
                break;
            case '3':
                hasSelection = document.querySelector('input[name="lecturer_id"]:checked') !== null;
                break;
            case '4':
                hasSelection = document.querySelectorAll('input[name="student_ids[]"]:checked').length > 0;
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

        // Highlight course if selected
        const selectedCourseRadio = document.querySelector('input[name="course_id"]:checked');
        if (selectedCourseRadio) {
            highlightSelectedCard(selectedCourseRadio.closest('label').querySelector('.course-card'));
        }

        document.querySelectorAll('input[name="student_ids[]"]:checked').forEach(checkbox => {
            highlightSelectedCard(checkbox.closest('label').querySelector('.student-card'));
        });
    }

    function highlightSelectedCard(selectedCard) {
        // Remove highlights from all cards of same type
        const cardType = selectedCard.classList.contains('faculty-card') ? 'faculty-card' : 'course-card';
            if (!selectedCard.classList.contains('student-card')) {
                const cardType = selectedCard.classList.contains('faculty-card') ? 'faculty-card' :
                                selectedCard.classList.contains('course-card') ? 'course-card' :
                                selectedCard.classList.contains('lecturer-card') ? 'lecturer-card' : '';

                if (cardType) {
                    document.querySelectorAll('.' + cardType).forEach(card => {
                        card.classList.remove('bg-blue-200', 'border-blue-500');
                    });
                }
            }

        // Add highlight to selected card
        selectedCard.classList.add('bg-blue-200', 'border-blue-500');
    }

    function handleFacultySelection(radio) {
        if (radio.checked) {
            updateNextButtonState();
            highlightSelectedCard(radio.closest('.faculty-label').querySelector('.faculty-card'));
        }
    }

    function handleCourseSelection(radio) {
        if (radio.checked) {
            updateNextButtonState();
            highlightSelectedCard(radio.closest('label').querySelector('.course-card'));
        }
    }

    function handleLecturerSelection(radio) {
        if (radio.checked) {
            updateNextButtonState();
            highlightSelectedCard(radio.closest('label').querySelector('.lecturer-card'));
        }
    }

    function handleStudentSelection(checkbox) {
        highlightSelectedCard(checkbox.closest('label').querySelector('.student-card'));
        updateNextButtonState();
    }
</script>
