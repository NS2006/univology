  <!-- Main modal -->
<div id="change-password" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Change Password
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer" data-modal-hide="change-password">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="/change/password" method="POST">
                @csrf

                    <div>
                        <label for="oldPassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Password</label>
                        <input type="password" name="oldPassword" id="oldPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required />
                    </div>
                    <div>
                        <label for="newPassword" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Pasword</label>
                        <input type="password" name="newPassword" id="newPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required />
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">Change Password</button>

                    {{-- success message --}}
                    @if(session('success-change-password'))
                        <div class="mb-4 text-sm text-green-600 dark:text-green-400" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error-change-password'))
                        <div class="mb-4 text-sm text-red-600 dark:text-red-400" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @error('newPassword')
                        <div class="mb-4 text-sm text-red-600 dark:text-red-400" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>

<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Univology</span>
    </a>
    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <button type="button" class="flex text-sm rounded-full md:me-0 cursor-pointer focus:underline focus:decoration-white" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
          <span class="sr-only">Open user menu</span>
          <span class="self-center text-2l font-semibold whitespace-nowrap dark:text-white">{{ auth()->user()->name }}</span>
        </button>
        <!-- Dropdown menu -->
        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
          <div class="px-4 py-3">
            <span class="block text-sm text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->role->name }}</span>
          </div>
          <ul class="py-2" aria-labelledby="user-menu-button">
            <li>
                <button data-modal-target="change-password" data-modal-toggle="change-password" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white cursor-pointer" type="button">
                    Change Password
                </button>
            </li>
            <li>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white cursor-pointer text-left w-full">Sign Out</button>
                </form>
            </li>
          </ul>
        </div>
        <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
    </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
      <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        @admin
        <li>
            <x-nav-link href='/dashboard/admin' :active="request()->is('dashboard/admin')">Dashboard</x-nav-link>
        </li>

        <li>
            <x-nav-link href='/administration' :active="request()->is('administration')">Administration</x-nav-link>
        </li>
        @endadmin

        @user
        <li>
            <x-nav-link href='/dashboard' :active="request()->is('dashboard')">Dashboard</x-nav-link>
        </li>
        <li>
            <x-nav-link href='/courses' :active="request()->is('course*')">Course</x-nav-link>
        </li>

        <li>
            <x-nav-link href='/assignments' :active="request()->is('assignment')">Assignment</x-nav-link>
        </li>
        @enduser

        @student
        <li>
            <x-nav-link href='/shop' :active="request()->is('shop')">Shop</x-nav-link>
        </li>
        @endstudent
      </ul>
    </div>
    </div>
  </nav>


@if(session('keep_modal_open') || $errors->has('new_password') || $errors->has('old_password'))
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const modalToggle = document.querySelector('[data-modal-toggle="change-password"]');
        const modal = document.getElementById('change-password');

        modalToggle.click();
        modal.classList.add('hidden');
        setTimeout(() => modalToggle.click(), 500);
    });
</script>
@endif
