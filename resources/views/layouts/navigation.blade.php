<nav x-data="navigation"
    class="fixed top-0 z-50 w-full bg-blue-100 border-b border-gray-100 dark:border-gray-700 dark:bg-gray-800">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div x-data="{
                    role: '{{ Auth::user()->role }}',
                    getHref() {
                        switch (this.role) {
                            case 'guest':
                                return '{{ route('home') }}';
                            case 'superadmin':
                                return '{{ route('dashboard') }}';
                            case 'instructor':
                                return '{{ route('batch_list') }}';
                            case 'student':
                                return '{{ route('enrolled_course') }}';
                            default:
                                return '#'; // fallback or default route
                        }
                    }
                }" class="flex items-center shrink-0">
                    <a :href="getHref()" class="items-center">
                        <!-- <img src="images/icons/lsi-logo.png" alt="LSI" class="w-auto h-16 rounded-full dark:bg-gray-900" /> -->
                        <img src="{{ asset('images/icons/lsi-logo.png') }}" alt="" class="w-auto h-9">
                    </a>
                </div>

                <!-- Navigation Links -->
                {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}
            </div>

            <!-- Menu Dropdown -->
            <div class="flex items-center">
                <div x-cloak x-show="{{ request()->routeIs('notifications') }} != 1" @click="markRead()"
                    class="me-2 md:me-4">
                    <x-dropdown align="right" width="80" marginRight="md:me-32 me-10 ">
                        <x-slot name="trigger">
                            <span class="relative inline-flex cursor-pointer ">
                                <svg class="text-gray-500 w-7 h-7 dark:text-white/50" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>notification</title>
                                    <path
                                        d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21" />
                                </svg>
                                <span class="sr-only">Notifications</span>
                                <div x-cloak x-show="unreadNotificationCount > 0"
                                    x-text="unreadNotificationCount > 99 ? '99+' : unreadNotificationCount"
                                    class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                                </div>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="m-1.5 text-black dark:text-white">
                                <div
                                    class="p-1 text-sm font-bold uppercase border-b border-gray-200 dark:border-gray-600">
                                    Notifications</div>
                                <div>
                                    <template x-for="notif in notifications" :key="notif.id">
                                        <div>
                                            <template x-if="notif.data.subject === 'enrollment'">
                                                <div class="flex p-1  hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <div class="me-1.5 flex">
                                                        <span class="w-6 h-6 me-1">
                                                            <template x-if="notif.data.status === 'accepted'">
                                                                <img width="48" height="48"
                                                                    src="https://img.icons8.com/color/48/check-file.png"
                                                                    alt="check-file" />
                                                            </template>
                                                            <template x-if="notif.data.status !== 'accepted'">
                                                                <img width="48" height="48"
                                                                    src="https://img.icons8.com/color/48/file-delete--v1.png"
                                                                    alt="file-delete--v1" />
                                                            </template>
                                                        </span>
                                                    </div>
                                                    <div class="">
                                                        <div class="flex items-center text-sm">
                                                            <span class="font-bold">
                                                                Enrollment
                                                            </span>
                                                        </div>
                                                        <div class="text-xs">
                                                            <div x-text="notif.data.message"></div>
                                                            <div class="mt-1">
                                                                Download ID Card here: <a
                                                                    class="p-1 rounded bg-black/10 hover:bg-black/20"
                                                                    :href="notif.id_card_link" target="_blank"
                                                                    rel="noopener noreferrer">My Profile</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <template x-if="notif.data.subject === 'post'">
                                                <div class="flex p-1  hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <div class="me-1.5 flex">
                                                        <span class="w-6 h-6 me-1">
                                                            <img width="48" height="48"
                                                                src="https://img.icons8.com/color/48/check-file.png"
                                                                alt="check-file" />
                                                        </span>
                                                    </div>
                                                    <a :href="notif.data.link" class="">
                                                        <div class="flex items-center text-sm">
                                                            <span class="font-bold"
                                                                x-text="notif.data.type === 'new' ? 'New Post' : 'Post Updated'">
                                                            </span>
                                                        </div>
                                                        <div class="text-xs">
                                                            <div x-text="notif.data.message"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </template>
                                            <template x-if="notif.data.subject === 'assignment'">
                                                <div class="flex p-1  hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <div class="me-1.5 flex">
                                                        <span class="w-6 h-6 me-1">
                                                            <img width="48" height="48"
                                                                src="https://img.icons8.com/external-vectorslab-flat-vectorslab/53/external-School-Bag-education-vectorslab-flat-vectorslab.png" />
                                                        </span>
                                                    </div>
                                                    <a :href="notif.data.link" class="">
                                                        <div class="flex items-center text-sm">
                                                            <span class="font-bold"
                                                                x-text="notif.data.type === 'new' ? 'New Assignment' : 'Assignment Updated'">
                                                            </span>
                                                        </div>
                                                        <div class="text-xs">
                                                            <div x-text="notif.data.message"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </template>
                                            <template x-if="notif.data.subject === 'attendance'">
                                                <div class="flex p-1  hover:bg-gray-200 dark:hover:bg-gray-600">
                                                    <div class="me-1.5 flex">
                                                        <span class="w-6 h-6 me-1">
                                                            <img width="48" height="48"
                                                                src="https://img.icons8.com/color/48/check-file.png"
                                                                alt="check-file" />
                                                        </span>
                                                    </div>
                                                    <a :href="notif.data.link" class="">
                                                        <div class="flex items-center text-sm">
                                                            <span class="font-bold">Attendance</span>
                                                        </div>
                                                        <div class="text-xs">
                                                            <div x-text="notif.data.message"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="unreadNotificationCount == 0">
                                        <div class="flex items-center justify-center my-4">
                                            <span class="text-sm text-gray-600 dark:text-gray-300">No Unread
                                                Notifications</span>
                                        </div>
                                    </template>
                                    <template
                                        x-if="notificationCount > 5 || (notificationCount > 0 && unreadNotificationCount == 0)">
                                        <div
                                            class="flex items-center justify-center p-1 border-t border-gray-200 dark:border-gray-600">
                                            <a class="p-2 text-xs rounded-md hover:bg-gray-200 dark:hover:bg-gray-600"
                                                href="{{ route('notifications') }}">Show All</a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
                <div class="relative hidden md:flex md:items-center">

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                <div>
                                    {{ Auth::user()->role == 'instructor' ? 'Trainer ' . Auth::user()->fname . ' ' . Auth::user()->lname : (Auth::user()->role == 'superadmin' ? 'Administrator' : Auth::user()->fname . ' ' . Auth::user()->lname) }}
                                </div>

                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="m-1.5 space-y-1">

                                <x-dropdown-link :href="'#'" id="installButtonHolder"
                                    class="hidden items-center space-x-1.5 rounded-md bg-sky-700 px-1.5 hover:bg-sky-600">
                                    <button id="installButton"
                                        class="hidden w-full text-center text-white rounded-lg">
                                        <div class="flex items-center justify-center">
                                            <span>
                                                <svg class="w-4 h-4 text-white" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <title>download-circle-outline</title>
                                                    <path
                                                        d="M8 17V15H16V17H8M16 10L12 14L8 10H10.5V6H13.5V10H16M12 2C17.5 2 22 6.5 22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2M12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4Z" />
                                                </svg>
                                            </span>
                                            <span class="ms-2">
                                                Install App
                                            </span>
                                        </div>
                                    </button>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="flex items-center justify-center space-x-1.5 rounded-md px-1.5">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                                    </svg>
                                    <div>
                                        Profile
                                    </div>
                                </x-dropdown-link>

                                <form class="cursor-pointer" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link hover_bg="hover:bg-red-900"
                                        class="flex items-center justify-center space-x-1.5 rounded-md px-1.5"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M14.08,15.59L16.67,13H7V11H16.67L14.08,8.41L15.5,7L20.5,12L15.5,17L14.08,15.59M19,3A2,2 0 0,1 21,5V9.67L19,7.67V5H5V19H19V16.33L21,14.33V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H19Z" />
                                        </svg>
                                        <div>
                                            Log Out
                                        </div>
                                    </x-dropdown-link>
                                </form>

                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Menu Hamburger -->
                <div class="flex items-center me-2 md:hidden">
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400">
                        <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hamburger Navigation Menu -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="block transition-transform md:hidden">
        <!-- Responsive Settings Options -->
        <div class="py-4 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center justify-between px-4">
                <div>
                    <div class="text-base font-medium text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->role == 'instructor' ? 'Trainer ' . Auth::user()->fname . ' ' . Auth::user()->lname : (Auth::user()->role == 'superadmin' ? 'Administrator' : Auth::user()->fname . ' ' . Auth::user()->lname) }}
                    </div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="flex">
                    <a class="me-1.5 flex" href="{{ route('profile.edit') }}">
                        <span class="p-2 rounded bg-gray-700/75 hover:bg-sky-600">
                            <svg class="w-6 h-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>account-circle-outline</title>
                                <path
                                    d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                            </svg>
                        </span>
                    </a>
                    <form class="cursor-pointer" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a class="flex" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <span class="p-2 rounded bg-red-600/50 hover:bg-red-600">
                                <svg class="w-6 h-6 text-white" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>logout</title>
                                    <path
                                        d="M17 7L15.59 8.41L18.17 11H8V13H18.17L15.59 15.58L17 17L22 12M4 5H12V3H4C2.9 3 2 3.9 2 5V19C2 20.1 2.9 21 4 21H12V19H4V5Z" />
                                </svg>
                            </span>
                        </a>
                    </form>

                </div>
            </div>

            <div class="mt-3 space-y-1">

                @if (auth()->check() && auth()->user()->role === 'superadmin')
                    <ul class="space-y-2 font-medium">
                        <li>
                            <x-responsive-nav-link :href="route('dashboard')" :active="request()->is('dashboard*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg fill="currentColor" class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>view-dashboard-outline</title>
                                    <path
                                        d="M19,5V7H15V5H19M9,5V11H5V5H9M19,13V19H15V13H19M9,17V19H5V17H9M21,3H13V9H21V3M11,3H3V13H11V3M21,11H13V21H21V11M11,15H3V21H11V15Z" />
                                </svg>
                                <span class="ms-3">Dashboard</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('website')" :active="request()->is('website*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 transition duration-75" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M3 11h18m-9 0v8m-8 0h16c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1H4a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Z" />
                                </svg>
                                <span class="ms-3">Website</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('courses')" :active="request()->is('courses*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 transition duration-75" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 19V4c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v13H7a2 2 0 0 0-2 2Zm0 0c0 1.1.9 2 2 2h12M9 3v14m7 0v4" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Courses</span>
                                {{-- <span
                                class="inline-flex items-center justify-center px-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-full ms-3 dark:bg-gray-700 dark:text-gray-300">Pro</span> --}}
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('instructors')" :active="request()->is('instructors*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>school-outline</title>
                                    <path fill="currentColor"
                                        d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3M18.82 9L12 12.72L5.18 9L12 5.28L18.82 9M17 16L12 18.72L7 16V12.27L12 15L17 12.27V16Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Instructors</span>
                                {{-- <span
                                class="inline-flex items-center justify-center px-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-full ms-3 dark:bg-gray-700 dark:text-gray-300">Pro</span> --}}
                            </x-responsive-nav-link>
                        </li>
                        {{-- <li>
                            <x-responsive-nav-link :href="route('instructors')" :active="request()->is('instructors*')"
                                class="flex items-center p-2 text-gray-900 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
                                <span
                                    class="inline-flex items-center justify-center w-3 h-3 p-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full ms-3 dark:bg-blue-900 dark:text-blue-300">3</span>
                            </x-responsive-nav-link>
                        </li> --}}
                        <li>
                            <x-responsive-nav-link :href="route('users')" :active="request()->is('users*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 transition duration-75" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('payments')" :active="request()->is('payments*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 transition duration-75"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5,6H23V18H5V6M14,9A3,3 0 0,1 17,12A3,3 0 0,1 14,15A3,3 0 0,1 11,12A3,3 0 0,1 14,9M9,8A2,2 0 0,1 7,10V14A2,2 0 0,1 9,16H19A2,2 0 0,1 21,14V10A2,2 0 0,1 19,8H9M1,10H3V20H19V22H1V10Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Payments</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('scan_attendance')" :active="request()->is('scan_attendance*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="flex-shrink-0 w-6 h-6 transition duration-75" viewBox="0 0 24 24">

                                    <path
                                        d="M3,11H5V13H3V11M11,5H13V9H11V5M9,11H13V15H11V13H9V11M15,11H17V13H19V11H21V13H19V15H21V19H19V21H17V19H13V21H11V17H15V15H17V13H15V11M19,19V15H17V19H19M15,3H21V9H15V3M17,5V7H19V5H17M3,3H9V9H3V3M5,5V7H7V5H5M3,15H9V21H3V15M5,17V19H7V17H5Z" />
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Attendance</span>
                            </x-responsive-nav-link>
                        </li>
                    </ul>
                @endif
                @if (auth()->check() && auth()->user()->role === 'student')
                    <ul class="space-y-2 font-medium">
                        <li>
                            <x-responsive-nav-link :href="route('enrolled_course')" :active="request()->is('course*') && !request()->is('course_completed')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 19V4c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v13H7a2 2 0 0 0-2 2Zm0 0c0 1.1.9 2 2 2h12M9 3v14m7 0v4" />
                                </svg>
                                <span class="ms-3">Course</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('course_completed')" :active="request()->routeIs('course_completed')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>book-check-outline</title>
                                    <path
                                        d="M16.75 22.16L14 19.16L15.16 18L16.75 19.59L20.34 16L21.5 17.41L16.75 22.16M18 2C19.1 2 20 2.9 20 4V13.34C19.37 13.12 18.7 13 18 13V4H13V12L10.5 9.75L8 12V4H6V20H12.08C12.2 20.72 12.45 21.39 12.8 22H6C4.9 22 4 21.1 4 20V4C4 2.9 4.9 2 6 2H18Z" />
                                </svg>
                                <span class="ms-3">Completed</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('enrollment')" :active="request()->is('enrollment*')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg fill="currentColor" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>clipboard-clock-outline</title>
                                    <path
                                        d="M21 11.11V5C21 3.9 20.11 3 19 3H14.82C14.4 1.84 13.3 1 12 1S9.6 1.84 9.18 3H5C3.9 3 3 3.9 3 5V19C3 20.11 3.9 21 5 21H11.11C12.37 22.24 14.09 23 16 23C19.87 23 23 19.87 23 16C23 14.09 22.24 12.37 21 11.11M12 3C12.55 3 13 3.45 13 4S12.55 5 12 5 11 4.55 11 4 11.45 3 12 3M5 19V5H7V7H17V5H19V9.68C18.09 9.25 17.08 9 16 9C12.13 9 9 12.13 9 16C9 17.08 9.25 18.09 9.68 19H5M16 21C13.24 21 11 18.76 11 16S13.24 11 16 11 21 13.24 21 16 18.76 21 16 21M16.5 16.25L19.36 17.94L18.61 19.16L15 17V12H16.5V16.25Z" />
                                </svg>
                                <span class="ms-3">Enrollment</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-responsive-nav-link :href="route('message_list')" :active="request()->routeIs('message_list')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>message-processing-outline</title>
                                    <path
                                        d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2M20 16H5.2L4 17.2V4H20V16M17 11H15V9H17M13 11H11V9H13M9 11H7V9H9" />
                                </svg>
                                <span class="ms-3">Message</span>
                            </x-responsive-nav-link>
                        </li>
                        <li>
                            <x-dropdown-link :href="'#'" id="installButtonHolderRes"
                                class="hidden items-center space-x-1.5 rounded-md bg-sky-700 px-1.5 hover:bg-sky-600">
                                <button id="installButtonRes" class="hidden w-full text-center text-white rounded-lg">
                                    <div class="flex items-center justify-center">
                                        <span>
                                            <svg class="w-4 h-4 text-white" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <title>download-circle-outline</title>
                                                <path
                                                    d="M8 17V15H16V17H8M16 10L12 14L8 10H10.5V6H13.5V10H16M12 2C17.5 2 22 6.5 22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2M12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4Z" />
                                            </svg>
                                        </span>
                                        <span class="ms-2">
                                            Install App
                                        </span>
                                    </div>
                                </button>
                            </x-dropdown-link>
                        </li>
                    </ul>
                @endif
                @if (auth()->check() && auth()->user()->role === 'instructor')
                    <ul class="space-y-2 font-medium">
                        <li>
                            <x-responsive-nav-link :href="route('batch_list')" :active="request()->is('batch_list')"
                                class="flex items-center p-2 group hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 19V4c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v13H7a2 2 0 0 0-2 2Zm0 0c0 1.1.9 2 2 2h12M9 3v14m7 0v4" />
                                </svg>
                                <span class="ms-3">Batches</span>
                            </x-responsive-nav-link>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</nav>
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script>
    function navigation() {
        return {
            open: false,
            notificationCount: 0,
            unreadNotificationCount: 0,
            notifications: [],
            notificationLoading: false, // Add loading flag for better UX
            init() {
                console.log('Navigation initialized');
                // this.websocket();
                this.getNotifications();
                this.notify();
            },
            async getNotifications() {
                const t = this; // Capture the context of `this`
                t.notificationLoading = true;
                try {
                    const response = await $.ajax({
                        url: '{{ route('get_notifications') }}',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });
                    t.notifications = response.notifications;
                    t.unreadNotificationCount = response.unread;
                    t.notificationCount = response.all; // Update the notification data
                } catch (error) {
                    t.notifications = []; // Handle empty notification in case of error
                    console.error('Error getting notification', error);
                } finally {
                    t.notificationLoading = false; // Reset loading state
                    console.log(t.unreadNotificationCount);
                    console.log(t.notificationCount);
                    console.log(t.notifications);
                }
            },
            async markRead() {
                const t = this
                try {
                    const notificationIds = t.notifications.map(n => n.id)
                    const response = await $.ajax({
                        url: '{{ route('mark_read') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            notif_ids: notificationIds
                        }
                    });
                    t.notifications = t.notifications.map(n => {
                        n.read_at = moment().format(); // Set `read_at` to the current timestamp
                        return n; // Return the updated notification object
                    });
                } catch (error) {
                    console.error('Error getting notification', error);
                }
            },
            websocket() {
                if (!ws || ws.readyState === WebSocket.CLOSED) {
                    console.log('WebSocket connection not available');
                    return;
                }

                ws.onopen = () => {
                    console.log('Connected to WebSocket server');
                    ws.send(JSON.stringify({
                        action: 'register',
                        userId: {{ auth()->user()->id }}
                    }));
                };

                ws.onmessage = (event) => {
                    const message = JSON.parse(event.data);
                    if (message.message === 'notify') {
                        console.log('got notified');
                        // Handle new notification here
                        this.getNotifications()
                    }
                    console.log(message);
                };

                ws.onclose = () => {
                    console.log('Disconnected from WebSocket server');
                    setTimeout(() => { // Adding delay before reconnecting
                        this.websocket();
                    }, 1000); // 1 second delay before retrying
                };
            },
            notify() {
                Echo.private(`App.Models.User.{{ auth()->user()->id }}`)
                    .notification((data) => {
                        this.getNotifications();
                        if (data.notify === 'post_update') {
                            Alpine.store('sharedState').postUpdate = true;
                        } else if (data.notify == 'assignment_update') {
                            Alpine.store('sharedState').assignmentUpdate = true;
                        } else if (data.notify == 'attendance_update') {
                            Alpine.store('sharedState').attendanceUpdate = true;
                        }
                    })
            }
        }
    }
</script>
