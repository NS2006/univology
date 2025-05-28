<x-layout>
    <x-slot:title>{{ $title}}</x-slot:title>
    @if ($step == 1)
        <x-slot:header>User Registration | User Information</x-slot:header>
    @else
        <x-slot:header>User Registration | Confirmation</x-slot:header>
    @endif

    <div class="px-4 md:px-8">
        @if (session('registration.user.success'))
            <div id="pop-up-register" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-opacity-50">
                <div class="relative w-full max-w-2xl">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-6 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                New User has been created successfully!
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
            @for ($curr = 1; $curr <= 3; $curr++)
                @if ($step >= $curr)
                    <a href="{{ route('register.user.user_route', ['user_route' => $user_routes[$curr]]) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500 text-white">
                        {{ $curr }}
                    </a>
                @else
                    <div class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-500 border border-gray-300 rounded-full">{{ $curr }}</div>
                @endif

                @if ($curr != 3)
                    @if ($step > $curr)
                        <div class="h-1 flex-1 bg-blue-500 animate-pulse"></div>
                    @else
                        <div class="h-1 flex-1 bg-gray-300"></div>
                    @endif
                @endif
            @endfor
        </div>

        <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

        <form method="POST" action="{{ route('register.user.store-data') }}">
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
                    <div class="col-span-full">
                        <label class="text-lg font-medium mb-2" for="user_name">User Name:</label>
                        <input type="text" name="user_name" id="user_name" placeholder="Input User Name" class="p-4 border rounded-lg bg-blue-50 w-full font-medium" required value="{{ old('user_name') }}">
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Select User Role:</h3>
                        <select name="role" id="role" class="p-4 border rounded-lg bg-blue-50 w-full font-medium">
                            <option value="selectRole">Please Select The Role</option>
                            <option value="student">Student</option>
                            <option value="lecturer">Lecturer</option>
                        </select>

                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                @if ($step == 3)
                    <input type="hidden" name="user_id" value="{{ $user_id }}">

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">User Name:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $user_name }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Role:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ Str::title($role) }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        @if($role == 'student')
                            <h3 class="text-lg font-medium mb-2">Student ID:</h3>
                        @else
                            <h3 class="text-lg font-medium mb-2">Lecturer ID:</h3>
                        @endif
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $user_id }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">User Email:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $email_name }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Default Password:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $default_password }}</p>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <h3 class="text-lg font-medium mb-2">Selected Faculty:</h3>
                        <div class="p-4 border rounded-lg bg-blue-50">
                            <p class="font-medium">{{ $selectedFaculty->name }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex justify-between mt-6">
                @if ($step != 1)
                    <a href="{{ route('register.user.user_route', ['user_route' => $user_routes[$step-1]]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Previous
                    </a>
                @else
                    <span class="px-4 py-2 bg-blue-500 text-white rounded-lg opacity-50 cursor-not-allowed">
                        Previous
                    </span>
                @endif

                <button type="submit" id="next-btn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors {{ !$canProceed ? 'opacity-50 cursor-not-allowed' : '' }} cursor-pointer" {{ !$canProceed ? 'disabled' : '' }}>
                    {{ $step != 3 ? "Next" : "Register New User"}}
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
