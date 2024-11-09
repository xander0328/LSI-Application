<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @laravelPWA

    {{-- PWA --}}
    <!-- Web Application Manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- Chrome for Android theme color -->
    <meta name="theme-color" content="#000000">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="PWA">
    <link rel="icon" sizes="512x512" href="/images/icons/icon-512x512.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="PWA">
    <link rel="apple-touch-icon" href="/images/icons/icon-512x512.png">

    <link href="/images/icons/splash-640x1136.png"
        media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-750x1334.png"
        media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1242x2208.png"
        media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1125x2436.png"
        media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-828x1792.png"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1242x2688.png"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1536x2048.png"
        media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1668x2224.png"
        media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1668x2388.png"
        media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-2048x2732.png"
        media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />

    <!-- Tile for Win8 -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/icons/icon-512x512.png">
    {{-- END PWA --}}

    {{-- filepond --}}
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css"
        integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Qr reader --}}
    <style>
        #qr-reader {
            width: 500px;
        }

        [x-cloak] {
            display: none !important;
        }

        @yield('style')
    </style>
    @yield('style-links')

</head>

<body class="bg-gray-200 font-sans antialiased dark:bg-gray-900">
    <div x-data="sessionChecker" class="min-h-screen bg-gray-200 dark:bg-gray-900">
        @include('layouts.navigation')

        @if (auth()->check() && auth()->user()->role != 'instructor')
            <aside id="logo-sidebar"
                class="fixed left-0 top-0 z-40 h-screen w-60 -translate-x-full border-r border-gray-200 bg-white pt-20 transition-transform dark:border-gray-700 dark:bg-gray-800 md:translate-x-0"
                aria-label="Sidebar">
                <div class="h-full flex-row justify-between overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
                    @if (auth()->check() && auth()->user()->role === 'superadmin')
                        <ul class="space-y-2 font-medium">
                            <li>
                                <x-nav-link :href="route('dashboard')" :active="request()->is('dashboard*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg fill="currentColor" class="h-6 w-6 flex-shrink-0 transition duration-75"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>view-dashboard-outline</title>
                                        <path
                                            d="M19,5V7H15V5H19M9,5V11H5V5H9M19,13V19H15V13H19M9,17V19H5V17H9M21,3H13V9H21V3M11,3H3V13H11V3M21,11H13V21H21V11M11,15H3V21H11V15Z" />
                                    </svg>
                                    <span class="ms-3">Dashboard</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('website')" :active="request()->is('website*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M3 11h18m-9 0v8m-8 0h16c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1H4a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Z" />
                                    </svg>
                                    <span class="ms-3">Website</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('courses')" :active="request()->is('courses*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 19V4c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v13H7a2 2 0 0 0-2 2Zm0 0c0 1.1.9 2 2 2h12M9 3v14m7 0v4" />
                                    </svg>
                                    <span class="ms-3 flex-1 whitespace-nowrap">Courses</span>
                                    {{-- <span
                                class="ms-3 inline-flex items-center justify-center rounded-full bg-gray-100 px-2 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">Pro</span> --}}
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('instructors')" :active="request()->is('instructors*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>school-outline</title>
                                        <path fill="currentColor"
                                            d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3M18.82 9L12 12.72L5.18 9L12 5.28L18.82 9M17 16L12 18.72L7 16V12.27L12 15L17 12.27V16Z" />
                                    </svg>
                                    <span class="ms-3 flex-1 whitespace-nowrap">Instructors</span>
                                    {{-- <span
                                class="ms-3 inline-flex items-center justify-center rounded-full bg-gray-100 px-2 text-sm font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">Pro</span> --}}
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('users')" :active="request()->is('users*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z" />
                                    </svg>
                                    <span class="ms-3 flex-1 whitespace-nowrap">Users</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('payments')" :active="request()->is('payments*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M5,6H23V18H5V6M14,9A3,3 0 0,1 17,12A3,3 0 0,1 14,15A3,3 0 0,1 11,12A3,3 0 0,1 14,9M9,8A2,2 0 0,1 7,10V14A2,2 0 0,1 9,16H19A2,2 0 0,1 21,14V10A2,2 0 0,1 19,8H9M1,10H3V20H19V22H1V10Z" />
                                    </svg>
                                    <span class="ms-3 flex-1 whitespace-nowrap">Payments</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('scan_attendance')" :active="request()->is('scan_attendance*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        class="h-6 w-6 flex-shrink-0 transition duration-75" viewBox="0 0 24 24">

                                        <path
                                            d="M3,11H5V13H3V11M11,5H13V9H11V5M9,11H13V15H11V13H9V11M15,11H17V13H19V11H21V13H19V15H21V19H19V21H17V19H13V21H11V17H15V15H17V13H15V11M19,19V15H17V19H19M15,3H21V9H15V3M17,5V7H19V5H17M3,3H9V9H3V3M5,5V7H7V5H5M3,15H9V21H3V15M5,17V19H7V17H5Z" />
                                    </svg>
                                    <span class="ms-3 flex-1 whitespace-nowrap">Attendance</span>
                                </x-nav-link>
                            </li>
                        </ul>
                    @endif
                    @if (auth()->check() && auth()->user()->role === 'student')
                        <div class="mb-4 flex flex-col items-center">
                            <template x-if="!image_path">
                                <div
                                    class="relative mb-3 inline-flex h-24 w-24 items-center justify-center overflow-hidden rounded-full bg-gray-100 dark:bg-gray-600">
                                    <span class="text-4xl font-medium text-gray-600 dark:text-gray-300"
                                        x-text="getInitials()"></span>
                                </div>
                            </template>
                            <template x-if="image_path">
                                <div
                                    class="border-3 relative mb-3 inline-flex h-24 w-24 items-center justify-center overflow-hidden rounded-full border-sky-500 bg-gray-100 dark:bg-gray-600">
                                    <img class="" :src="image_path">
                                </div>
                            </template>

                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                {{ auth()->user()->fname }}
                                {{ auth()->user()->mname ? auth()->user()->mname[0] . '.' : '' }}
                                {{ auth()->user()->lname }}
                            </h5>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Trainee</span>
                        </div>
                        <ul class="space-y-2 font-medium">
                            <li>
                                <x-nav-link :href="route('enrolled_course')" :active="request()->is('course*') && !request()->is('course_completed')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 19V4c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v13H7a2 2 0 0 0-2 2Zm0 0c0 1.1.9 2 2 2h12M9 3v14m7 0v4" />
                                    </svg>
                                    <span class="ms-3">Course</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('course_completed')" :active="request()->routeIs('course_completed')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>book-check-outline</title>
                                        <path
                                            d="M16.75 22.16L14 19.16L15.16 18L16.75 19.59L20.34 16L21.5 17.41L16.75 22.16M18 2C19.1 2 20 2.9 20 4V13.34C19.37 13.12 18.7 13 18 13V4H13V12L10.5 9.75L8 12V4H6V20H12.08C12.2 20.72 12.45 21.39 12.8 22H6C4.9 22 4 21.1 4 20V4C4 2.9 4.9 2 6 2H18Z" />
                                    </svg>
                                    <span class="ms-3">Completed</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('enrollment')" :active="request()->is('enrollment*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">

                                    <svg fill="currentColor" class="h-6 w-6 flex-shrink-0 transition duration-75"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>clipboard-clock-outline</title>
                                        <path
                                            d="M21 11.11V5C21 3.9 20.11 3 19 3H14.82C14.4 1.84 13.3 1 12 1S9.6 1.84 9.18 3H5C3.9 3 3 3.9 3 5V19C3 20.11 3.9 21 5 21H11.11C12.37 22.24 14.09 23 16 23C19.87 23 23 19.87 23 16C23 14.09 22.24 12.37 21 11.11M12 3C12.55 3 13 3.45 13 4S12.55 5 12 5 11 4.55 11 4 11.45 3 12 3M5 19V5H7V7H17V5H19V9.68C18.09 9.25 17.08 9 16 9C12.13 9 9 12.13 9 16C9 17.08 9.25 18.09 9.68 19H5M16 21C13.24 21 11 18.76 11 16S13.24 11 16 11 21 13.24 21 16 18.76 21 16 21M16.5 16.25L19.36 17.94L18.61 19.16L15 17V12H16.5V16.25Z" />
                                    </svg>
                                    <span class="ms-3">Enrollment</span>
                                </x-nav-link>
                            </li>
                            <li>
                                <x-nav-link :href="route('message_list')" :active="request()->routeIs('message_list')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg class="h-6 w-6 flex-shrink-0 transition duration-75" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>message-processing-outline</title>
                                        <path
                                            d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2M20 16H5.2L4 17.2V4H20V16M17 11H15V9H17M13 11H11V9H13M9 11H7V9H9" />
                                    </svg>
                                    <span class="ms-3">Message</span>
                                </x-nav-link>
                            </li>
                        </ul>
                    @endif
                    @if (auth()->check() && auth()->user()->role === 'guest')
                        <div class="mb-4 flex flex-col items-center">
                            <template x-if="!image_path">
                                <div
                                    class="relative mb-3 inline-flex h-24 w-24 items-center justify-center overflow-hidden rounded-full bg-gray-100 dark:bg-gray-600">
                                    <span class="text-4xl font-medium text-gray-600 dark:text-gray-300"
                                        x-text="getInitials()"></span>
                                </div>
                            </template>
                            <template x-if="image_path">
                                <div
                                    class="border-3 relative mb-3 inline-flex h-24 w-24 items-center justify-center overflow-hidden rounded-full border-sky-500 bg-gray-100 dark:bg-gray-600">
                                    <img class="" :src="image_path">
                                </div>
                            </template>

                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                {{ auth()->user()->fname }}
                                {{ auth()->user()->mname ? auth()->user()->mname[0] . '.' : '' }}
                                {{ auth()->user()->lname }}
                            </h5>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Guest</span>
                        </div>
                        <ul class="space-y-2 font-medium">
                            <li>
                                <x-nav-link :href="route('enrollment')" :active="request()->is('enrollment*')"
                                    class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg fill="currentColor" class="h-6 w-6 flex-shrink-0 transition duration-75"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>clipboard-clock-outline</title>
                                        <path
                                            d="M21 11.11V5C21 3.9 20.11 3 19 3H14.82C14.4 1.84 13.3 1 12 1S9.6 1.84 9.18 3H5C3.9 3 3 3.9 3 5V19C3 20.11 3.9 21 5 21H11.11C12.37 22.24 14.09 23 16 23C19.87 23 23 19.87 23 16C23 14.09 22.24 12.37 21 11.11M12 3C12.55 3 13 3.45 13 4S12.55 5 12 5 11 4.55 11 4 11.45 3 12 3M5 19V5H7V7H17V5H19V9.68C18.09 9.25 17.08 9 16 9C12.13 9 9 12.13 9 16C9 17.08 9.25 18.09 9.68 19H5M16 21C13.24 21 11 18.76 11 16S13.24 11 16 11 21 13.24 21 16 18.76 21 16 21M16.5 16.25L19.36 17.94L18.61 19.16L15 17V12H16.5V16.25Z" />
                                    </svg>

                                    <span class="ms-3">Enrollment</span>
                                </x-nav-link>
                            </li>
                        </ul>
                    @endif

                </div>
                <div class="fixed bottom-0 w-full px-3 pb-2">
                    <button id="installButton"
                        class="hidden w-full rounded-lg bg-sky-700 py-2 text-center text-white hover:bg-sky-800">
                        <div class="flex items-center justify-center">
                            <span>
                                <svg class="h-6 w-6 text-white" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>download-circle-outline</title>
                                    <path
                                        d="M8 17V15H16V17H8M16 10L12 14L8 10H10.5V6H13.5V10H16M12 2C17.5 2 22 6.5 22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2M12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4Z" />
                                </svg>
                            </span>
                            <span class="me-4 ms-2">
                                Install App
                            </span>
                        </div>
                    </button>
                </div>
            </aside>

        @endif
        <div class="{{ auth()->user()->role != 'instructor' ? 'md:ml-60' : '' }}">
            <!-- Page Heading -->
            @if (isset($header))
                <header
                    class="{{ auth()->user()->role != 'instructor' ? 'md:left-60' : '' }} fixed left-0 right-0 top-16 z-10 shadow-lg">
                    <div
                        class="{{ auth()->user()->role != 'instructor' ? ' max-w-8xl' : '' }} mx-auto border-black bg-white px-4 py-6 dark:border-gray-600 dark:bg-gray-800 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                <hr class="text-red">
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>

    </div>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

    {{-- Alerts --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"
        integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function sessionChecker() {
            return {
                sessionMessage: '',
                image_path: '{{ auth()->user()->get_profile_picture() }}',
                init() {},
                /* checkSession() {
                    $.ajax({
                        url: '/check-session',
                        method: 'GET',
                        success: (data) => {
                            if (!data.session_exists) {
                                window.location.href = '/login';
                            } else {
                                this.sessionMessage = 'Session is active';
                            }
                        },
                        error: (jqXHR) => {
                            if (jqXHR.status === 401) {
                                window.location.href = '/login';
                            } else {
                                this.sessionMessage = 'Error checking session';
                                console.error('Error:', jqXHR);
                            }
                        }
                    });
                }, */
                getInitials() {
                    var name = '{{ auth()->user()->fname }}'
                    let names = name.trim().split(' ');
                    let initials = names[0].charAt(0); // First letter of the first name
                    if (names.length > 1) {
                        initials += names[1].charAt(0); // First letter of the second name (if present)
                    }
                    return initials.toUpperCase(); // Return initials in uppercase
                }

            }
        }
    </script>
    @yield('script')

</body>

</html>
