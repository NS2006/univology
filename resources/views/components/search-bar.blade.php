<div class="py-8 px-4 mx-auto max-w-screen-xl lg:px-6">
    <div class="mx-auto max-w-screen-md">
        <form action="{{ $route }}" method="GET" class="group">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 dark:text-gray-500 dark:group-focus-within:text-blue-500 transition-colors" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input class="block w-full p-4 pl-12 text-sm dark:text-gray-900 border dark:border-gray-300 rounded-lg dark:bg-gray-50 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg" placeholder="{{ $placeholder }}" type="search" id="search" name="search" autocomplete="off" value="{{ request('search') }}">
                <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-4 py-2 transition-all cursor-pointer">
                    Search
                </button>
            </div>
        </form>
    </div>
</div>
