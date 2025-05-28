<x-layout>
    <x-slot:title>{{ $title}}</x-slot:title>
    @if ($step == 1)
        <x-slot:header>Faculty Registration | Faculty Information</x-slot:header>
    @endif

    <div class="px-4 md:px-8">
        @if (session('registration.faculty.success'))
            <div id="pop-up-register" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-opacity-50">
                <div class="relative w-full max-w-2xl">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-6 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                New Faculty has been created successfully!
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
            @for ($curr = 1; $curr <= 1; $curr++)
                @if ($step >= $curr)
                    <a href="{{ route('register.faculty.faculty_route', ['faculty_route' => $faculty_routes[$curr]]) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500 text-white">
                        {{ $curr }}
                    </a>
                @else
                    <div class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-500 border border-gray-300 rounded-full">{{ $curr }}</div>
                @endif

                @if ($curr != 1)
                    @if ($step > $curr)
                        <div class="h-1 flex-1 bg-blue-500 animate-pulse"></div>
                    @else
                        <div class="h-1 flex-1 bg-gray-300"></div>
                    @endif
                @endif
            @endfor
        </div>

        <hr class="my-4 h-px bg-gray-500 dark:bg-gray-600 border-0">

        <form method="POST" action="{{ route('register.faculty.store-data') }}">
            @csrf

            <input type="hidden" name="step" value="{{ $step }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6 mt-4">
                @if ($step == 1)
                    <div class="col-span-full">
                        <label class="text-lg font-medium mb-2" for="faculty_name">Faculty Name:</label>
                        <input type="text" name="faculty_name" id="faculty_name" placeholder="Input Faculty Name" class="p-4 border rounded-lg bg-blue-50 w-full font-medium" required value="{{ old('faculty_name') }}">
                    </div>
                @endif
            </div>

            <div class="flex justify-between mt-6">
                @if ($step != 1)
                    <a href="{{ route('register.faculty.faculty_route', ['faculty_route' => $faculty_routes[$step-1]]) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Previous
                    </a>
                @else
                    <span class="px-4 py-2 bg-blue-500 text-white rounded-lg opacity-50 cursor-not-allowed">
                        Previous
                    </span>
                @endif

                <button type="submit" id="next-btn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors cursor-pointer">
                    {{ $step != 1 ? "Next" : "Register New Faculty"}}
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
</script>
