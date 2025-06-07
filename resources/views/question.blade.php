@php
    $questionUrl = "/assignment/" . $assignment->assignment_id . '/question';
    $assignmentUrl = "/assignment/" . $assignment->assignment_id;
@endphp

<x-layout>
    <x-slot:title>{{ $assignment->title }} - Question</x-slot:title>
    <x-slot:header>{{ $assignment->title }} - Question</x-slot:header>

    <div class="container mx-auto px-4 py-6">
        <!-- Question Navigation -->
        <div class="mb-8 p-4 dark:bg-white bg-gray-800 rounded-lg shadow border dark:border-gray-200 border-gray-700">
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-10 gap-3">
                @foreach ($all_questions as $curr_question)
                    <a href="{{ $questionUrl }}/{{ $curr_question->question_id }}" class="px-4 py-2 rounded-lg text-sm sm:text-base text-center {{ $question->question_id === $curr_question->question_id ?
                        'bg-blue-600 text-white' :
                        'dark:bg-gray-100 bg-gray-700 dark:text-gray-800 text-gray-200 dark:hover:bg-gray-200 hover:bg-gray-600' }}">
                        {{ $loop->iteration }}
                    </a>
                @endforeach

                <!-- New Question Button -->
                @lecturer
                @if (!$assignment->is_published)
                    <a href="{{ $questionUrl }}/new-question"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex justify-center items-center text-sm sm:text-base">
                        <span class="mr-1">+</span> New
                    </a>
                @endif
                @endlecturer
            </div>
        </div>

        @lecturer
        <!-- Question Form -->
        @if (!$assignment->is_published)
            <form action="{{ $questionUrl }}/{{ $question->question_id }}/save-question" method="POST" class="dark:bg-white bg-gray-800 rounded-lg shadow border dark:border-gray-200 border-gray-700 p-6">
                @csrf

                <!-- Question Text -->
                <div class="mb-6">
                    <label for="question_text" class="block mb-2 text-sm font-medium dark:text-gray-900 text-white">Question Text</label>
                    <textarea id="question_text" name="question_text" rows="4" class="block p-2.5 w-full text-sm dark:text-gray-900 dark:bg-gray-50 rounded-lg border dark:border-gray-300 dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-700 border-gray-600 dark:placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" required placeholder="Enter your question here...">{{ old('question_text', $question->question_text) }}</textarea>
                </div>

                <!-- Choices -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium dark:text-gray-900 text-white">Answer Choices</label>
                    <div class="choices-container space-y-4">
                        @foreach($question->choices as $choice)
                            <div class="flex items-center choice-item" data-choice-id="{{ $choice->id }}">
                                <input type="radio" id="correct_choice_{{ $choice->id }}" name="correct_choice" value="{{ $choice->id }}"
                                    class="w-4 h-4 text-blue-600 dark:bg-gray-100 dark:border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600"
                                    {{ $question->correct_choice && $question->correct_choice->choice_id == $choice->id ? 'checked' : '' }}>

                                <input type="text" name="choices[{{ $choice->id }}][text]" value="{{ old('choices.'.$choice->id.'.text', $choice->description) }}"
                                    class="ml-2 p-2.5 w-full text-sm dark:text-gray-900 dark:bg-gray-50 rounded-lg border dark:border-gray-300 dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter choice text...">

                                <input type="hidden" name="choices[{{ $choice->id }}][action]" value="keep">

                                @if($loop->index >= 0)  <!-- Show delete for non-required choices -->
                                    <button type="button" onclick="deleteChoice(this)"
                                            class="ml-2 p-2 dark:text-red-600 dark:hover:text-red-800 text-red-400 hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Choice Button -->
                    <button type="button" onclick="addChoice()" class="mt-4 px-4 py-2 text-sm font-medium dark:text-blue-600 dark:hover:text-blue-800 text-blue-400 hover:text-blue-300 flex items-center cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Another Choice
                    </button>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center">
                    <a href="{{ $assignmentUrl }}" class="dark:text-gray-600 text-gray-300 dark:hover:text-gray-900 hover:text-white font-medium text-sm">
                        Back to Assignment
                    </a>
                    <div class="space-x-3">
                        @if(!$assignment->is_published)
                            <button data-modal-target="delete-question-tab" data-modal-toggle="delete-question-tab" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg cursor-pointer" type="button">
                                Delete Question
                            </button>

                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg cursor-pointer">
                                Save Question
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        @else
            <div class="dark:bg-white bg-gray-800 rounded-lg shadow border dark:border-gray-200 border-gray-700 p-6">
                <!-- Question Text -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium dark:text-gray-900 text-white">Question Text</label>
                    <div class="p-2.5 w-full text-sm dark:text-gray-900 dark:bg-gray-50 rounded-lg bg-gray-700 text-white">
                        {{ $question->question_text }}
                    </div>
                </div>

                <!-- Choices -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium dark:text-gray-900 text-white">Answer Choices</label>
                    <div class="space-y-4">
                        @foreach($question->choices as $choice)
                            <div class="flex items-center">
                                <input type="radio"
                                    class="w-4 h-4 text-blue-600 dark:bg-gray-100 dark:border-gray-300 bg-gray-700 border-gray-600"
                                    disabled
                                    {{ $question->correct_choice && $question->correct_choice->choice_id == $choice->id ? 'checked' : '' }}>

                                <div class="ml-2 p-2.5 w-full text-sm dark:text-gray-900 dark:bg-gray-50 rounded-lg bg-gray-700 text-white">
                                    {{ $choice->description }}
                                    @if($question->correct_choice && $question->correct_choice->choice_id == $choice->id)
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full dark:bg-green-200 dark:text-green-900">
                                            Correct Answer
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Back Button -->
                <div class="flex justify-end">
                    <a href="{{ $assignmentUrl }}" class="dark:text-gray-600 text-gray-300 dark:hover:text-gray-900 hover:text-white font-medium text-sm">
                        Back to Assignment
                    </a>
                </div>
            </div>
        @endif
        @endlecturer

        @student
        <div class="dark:bg-white bg-gray-800 rounded-lg shadow-lg border dark:border-gray-200 border-gray-700 p-8">
            <!-- Assignment Info Header -->
            <div class="mb-6 pb-4 border-b dark:border-gray-200 border-gray-700">
                @if($assignment->deadline)
                <p class="text-sm {{ now()->gt($assignment->deadline) ? 'text-red-500 dark:text-red-400' : 'text-blue-500 dark:text-blue-400' }}">
                    Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->format('M j, Y g:i A') }}
                    @if(now()->gt($assignment->deadline))
                        (Overdue)
                    @else
                        (Due in {{ \Carbon\Carbon::parse($assignment->deadline)->diffForHumans() }})
                    @endif
                </p>
                @endif
            </div>

            <!-- Question Text (Larger and more prominent) -->
            <div class="mb-8">
                <div class="p-4 text-lg dark:text-gray-900 dark:bg-gray-50 rounded-lg bg-gray-700 text-white border-l-4 border-blue-500">
                    {{ $question->question_text }}
                </div>
            </div>

            <!-- Choices with radio-style buttons -->
            <div class="mb-8">
                <label class="block mb-4 text-lg font-medium text-white dark:text-gray-900">Select your answer:</label>
                <div class="space-y-3">
                    @foreach($question->choices as $choice)
                        <form method="POST" action="{{ $questionUrl }}/{{ $question->question_id }}/save-choice">
                            @csrf

                            <input type="hidden" name="choice_id" value="{{ $choice->id }}">

                            <button type="submit" class="w-full flex items-center p-4 border border-gray-600 dark:border-gray-300 rounded-lg bg-gray-800 dark:bg-gray-100 transition-colors group cursor-pointer">

                                <!-- Circle  -->
                                <div class="w-5 h-5 rounded-full border-2 border-white dark:border-gray-900 mr-4
                                    @if ($selected_choice_id == $choice->id)
                                        bg-blue-600
                                    @else
                                        group-hover:bg-white/20
                                    @endif
                                "></div>


                                <!-- Choice text -->
                                <span class=" text-white dark:text-gray-900">{{ $choice->description }}</span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>


            <!-- Navigation and Submit Buttons -->
            <div class="flex justify-between items-center pt-6 border-t dark:border-gray-200 border-gray-700">
                <a href="{{ $assignmentUrl }}" class="px-6 py-2 text-gray-300 dark:text-gray-600 hover:text-white dark:hover:text-gray-900 font-medium rounded-lg border dark:border-gray-300 border-gray-600 transition-colors">
                    Back to Assignment
                </a>
                <form method="POST" action="{{ $assignmentUrl }}/submit-answer">
                    @csrf

                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors cursor-pointer">
                    Submit Answer
                    </button>
                </form>
            </div>
        </div>
        @endstudent
    </div>

    @lecturer
    @if (!$assignment->is_published)
        <!-- Delete Question Modal -->
        <div id="delete-question-tab" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-500/50 dark:bg-gray-900/80">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Confirm Deletion
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                This action cannot be undone
                            </p>
                        </div>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-modal-hide="delete-question-tab">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-5 space-y-4">
                        <div class="flex items-center p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Warning</span>
                            <div>
                                <span class="font-medium">Warning:</span> Deleting this question will permanently remove it and all associated answers from the system.
                            </div>
                        </div>

                        <p class="text-gray-700 dark:text-gray-300">
                            Are you sure you want to delete this question?
                        </p>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center justify-end p-5 border-t border-gray-200 rounded-b dark:border-gray-600 space-x-3">
                        <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 cursor-pointer" data-modal-hide="delete-question-tab">
                            Cancel
                        </button>
                        <form id="delete-form" action="{{ $questionUrl }}/{{ $question->question_id }}/delete" method="POST" class="inline">
                            @csrf

                            <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 cursor-pointer">
                                Delete Question
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        {{-- Script --}}
        <script>
            // Add new choice
            function addChoice() {
                const choicesContainer = document.querySelector('.choices-container');
                const tempId = choicesContainer.children.length;

                const choiceDiv = document.createElement('div');
                choiceDiv.className = 'flex items-center choice-item';
                choiceDiv.innerHTML = `
                    <input type="radio" id="correct_choice_new_${tempId}" name="correct_choice" value="new_${tempId}"
                        class="w-4 h-4 text-blue-600 dark:bg-gray-100 dark:border-gray-300 dark:focus:ring-blue-500 focus:ring-blue-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                    <input type="text" name="new_choices[${tempId}][text]"
                        class="ml-2 p-2.5 w-full text-sm dark:text-gray-900 dark:bg-gray-50 rounded-lg border dark:border-gray-300 dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter choice text..." required>
                    <input type="hidden" name="new_choices[${tempId}][action]" value="create">
                    <button type="button" onclick="deleteChoice(this)"
                        class="ml-2 p-2 dark:text-red-600 dark:hover:text-red-800 text-red-400 hover:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                `;

                choicesContainer.appendChild(choiceDiv);
            }

            // Delete choice
            function deleteChoice(button) {
                const choiceDiv = button.closest('.choice-item');
                const choiceId = choiceDiv.dataset.choiceId;

                if (choiceId) {
                    // For existing choices, mark for deletion
                    const actionInput = choiceDiv.querySelector('input[name^="choices"][name$="[action]"]');
                    actionInput.value = 'delete';
                    choiceDiv.style.opacity = '0.3';
                    choiceDiv.style.pointerEvents = 'none';
                } else {
                    // For new choices, just remove the element
                    choiceDiv.remove();
                }
            }
        </script>
    @endif
    @endlecturer
</x-layout>
