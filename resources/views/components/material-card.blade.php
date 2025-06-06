@php
    use App\Models\MaterialProgress;
    use Illuminate\Support\Facades\Auth;

    if(Auth::user()->role->name == 'student'){
        $enrollment = $classroom->enrollments->where('student_id', Auth::user()->student->id)->first();
        $isFinished = MaterialProgress::where('enrollment_id', $enrollment->id ?? null)
                        ->where('material_id', $material->id)
                        ->where('status', true)
                        ->exists();
    } else{
        $isFinished = false;
    }
@endphp


<form method="POST" action="{{ $classroomUrl }}/view-material" target="_blank">
    @csrf
    
    <input type="hidden" name="material_id" value="{{ $material->id }}">
    <input type="hidden" name="redirect_url" value="{{ $material->link }}">

    <button type="submit"
        class="group relative block w-full text-left p-4 border rounded-lg transition-colors hover:shadow-md cursor-pointer
            {{ $isFinished
                ? 'dark:border-green-500 dark:bg-green-50 border-green-400 bg-green-900'
                : 'dark:border-gray-200 border-gray-700' }} dark:hover:border-purple-300 hover:border-purple-700">

        <h4 class="font-medium text-white dark:text-gray-800 group-hover:text-purple-400 dark:group-hover:text-purple-600">
            {{ $material->topic }}
        </h4>
        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1 truncate">
            {{ parse_url($material->link, PHP_URL_HOST) }}
        </p>
        <div class="mt-2 flex items-center text-xs text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            Click to open
        </div>
    </button>
</form>

