<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LSI | Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @laravelPWA

</head>

<body class="antialiased">
    <div
        class="bg-dots-darker dark:bg-dots-lighter relative min-h-screen bg-gray-900 bg-center selection:bg-white selection:text-sky-400 dark:bg-gray-950 sm:items-center sm:justify-center">
        <div class="bg-dots-darker flex items-center justify-between px-4 py-4">
            <div class="flex">
                <a href="/" class="mr-9 items-center">
                    <!-- <img src="images/icons/lsi-logo.png" alt="LSI" class="h-16 w-auto rounded-full dark:bg-gray-900" /> -->
                    <div class="text-3xl font-black text-cyan-500">Language Skills Institute</div>
                    <div class="bg-gradient-to-r from-gray-900 px-1 text-xs font-light text-cyan-300">Oriental Mindoro
                    </div>
                </a>

                <nav class="flex items-center justify-center space-x-4">
                    <a href="#courses"
                        class="rounded-md px-3 py-2 text-sky-500 hover:bg-gray-800 hover:text-sky-200">Courses</a>
                    <a href="#"
                        class="rounded-md px-3 py-2 text-sky-500 hover:bg-gray-800 hover:text-sky-200">Community</a>
                    <a href="#"
                        class="rounded-md px-3 py-2 text-sky-500 hover:bg-gray-800 hover:text-sky-200">About</a>
                </nav>
            </div>

            <!-- <div class="">
                    <a href="#" class="hover:text-red text-gray-300">Sign In</a>
                    <a href="#" class="text-gray-300 hover:text-black">Logout</a>
                </div> -->

            @if (Route::has('login'))
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/website') }}"
                            class="font-semibold text-gray-600 hover:text-gray-900 focus:rounded-sm focus:outline-none dark:text-gray-400 dark:hover:text-white">
                            <img src="images/icons/lsi-logo.png" alt="Profile"
                                class="h-9 w-auto rounded-full border-2 border-sky-300">
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="rounded-md border border-cyan-500 px-3 py-2 font-semibold text-sky-300">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="ml-4 rounded-md bg-gradient-to-r from-cyan-500 to-blue-500 px-3 py-2 font-semibold text-black">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <div id="animation-carousel" class="relative w-full" data-carousel="static">
            <!-- Carousel wrapper -->
            <div class="relative h-56 overflow-hidden md:h-96">
                <!-- Item 1 -->
                <div class="hidden duration-200 ease-linear" data-carousel-item="active">
                    <img src="images/carousel/image1.jpg"
                        class="absolute left-1/2 top-1/2 block w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-200 ease-linear" data-carousel-item>
                    <img src="images/carousel/image2.jpg"
                        class="absolute left-1/2 top-1/2 block w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-200 ease-linear" data-carousel-item>
                    <img src="images/carousel/image3.jpg"
                        class="absolute left-1/2 top-1/2 block w-full -translate-x-1/2 -translate-y-1/2" alt="...">
                </div>
            </div>
            <!-- Slider controls -->
            <button type="button"
                class="group absolute start-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/30 group-hover:bg-white/50 group-focus:outline-none group-focus:ring-4 group-focus:ring-white dark:bg-gray-800/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70">
                    <svg class="h-4 w-4 text-white rtl:rotate-180 dark:text-gray-800" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="group absolute end-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/30 group-hover:bg-white/50 group-focus:outline-none group-focus:ring-4 group-focus:ring-white dark:bg-gray-800/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70">
                    <svg class="h-4 w-4 text-white rtl:rotate-180 dark:text-gray-800" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

        <h1
            class="my-4 text-center text-2xl font-extrabold leading-none tracking-tight text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
            Welcome to Language Skills Institute </h1>
        <div class="mx-20 mb-10 text-center text-white">At LSI, we're dedicated to empowering individuals with the
            essential
            skills they need to excel in today's dynamic world. Whether you're looking
            to enhance your communication abilities or boost your computer literacy,
            LSI is here to guide you on your learning journey.</div>

        <div id="courses" class="bg-gradient-to-b from-blue-600 p-10 text-white">
            <h2 class="my-4 mb-8 text-center text-4xl font-bold">Popular Offered Courses</h2>

            <div class="flex items-center justify-center">
                <div class="grid grid-cols-3 gap-4 md:grid-cols-3">
                    <!-- Course Item -->
                    <div
                        class="max-w-xs rounded-xl border-8 border-gray-200 bg-white shadow dark:border-gray-800 dark:bg-gray-800">
                        <a href="#">
                            <img class="rounded-t-lg" src="/images/carousel/image1-test.jpg" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Noteworthy technology acquisitions 2021</h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise
                                technology acquisitions of 2021 so far, in reverse chronological order.</p>
                            <a href="#"
                                class="inline-flex items-center rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 py-2 text-center text-sm font-medium font-semibold text-black hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Read more
                                <svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="max-w-xs rounded-xl border-8 bg-white shadow dark:border-gray-800 dark:bg-gray-800">
                        <a href="#">
                            <img class="rounded-t-lg" src="/images/carousel/image1.jpg" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Noteworthy technology acquisitions 2021</h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest
                                enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
                            <a href="#"
                                class="inline-flex items-center rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 py-2 text-center text-sm font-medium font-semibold text-black hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Read more
                                <svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div
                        class="max-w-xs rounded-xl border-8 border-gray-200 bg-white shadow dark:border-gray-800 dark:bg-gray-800">
                        <a href="#">
                            <img class="rounded-t-lg" src="/images/carousel/image1.jpg" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Noteworthy technology acquisitions 2021</h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest
                                enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
                            <a href="#"
                                class="inline-flex items-center rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 py-2 text-center text-sm font-medium font-semibold text-black hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-sky-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Read more
                                <svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 text-center text-white">
                <a href="#"
                    class="rounded-md px-3 py-2 text-lg text-sky-500 hover:bg-gray-800 hover:text-sky-200">See All
                    Courses</a>
            </div>
        </div>

        <div>

        </div>

    </div>

    <footer
        class="w-full border-t border-gray-200 bg-white p-4 shadow dark:border-gray-600 dark:bg-gray-800 md:flex md:items-center md:justify-between md:p-6">
        <span class="text-sm text-gray-500 dark:text-gray-400 sm:text-center">© 2024 <a href="/"
                class="hover:underline">Language Skills Institute</a>. All Rights Reserved.
        </span>
        <ul class="mt-3 flex flex-wrap items-center text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
            <li>
                <a href="#" class="me-4 hover:underline md:me-6">About</a>
            </li>
            <li>
                <a href="#" class="me-4 hover:underline md:me-6">Privacy Policy</a>
            </li>
            <li>
                <a href="#" class="hover:underline">Contact</a>
            </li>
        </ul>
    </footer>
</body>

</html>
