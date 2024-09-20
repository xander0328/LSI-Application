<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LSI | Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <style>
        html {
            scroll-behavior: smooth;
        }

        [x-cloak] {
            display: none !important;
        }

        .no-scroll {
            overflow: hidden;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @laravelPWA
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    {{-- FilePond --}}
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />

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
</head>

<body class="antialiased">
    <div x-data="welcomePage"
        class="bg-dots-darker dark:bg-dots-lighter relative min-h-screen bg-gray-900 bg-center selection:bg-white selection:text-sky-400 dark:bg-gray-950 sm:items-center sm:justify-center">

        {{-- <div id="animation-carousel" class="relative w-full" data-carousel="static">
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
        </div> --}}

        {{-- Temporary Comment --}}
        <div style="background-image: url('{{ asset('images/elements/ekonek_bg.png') }}');"
            class="flex h-screen flex-col bg-cover bg-center">
            <div class="bg-dots-darker flex items-center justify-between px-4 py-4">
                <div class="flex">
                    <a href="/" class="mr-9 items-center">
                        <!-- <img src="images/icons/lsi-logo.png" alt="LSI" class="h-16 w-auto rounded-full dark:bg-gray-900" /> -->
                        <div class="text-3xl font-black text-cyan-500">Language Skills Institute</div>
                        <div class="bg-gradient-to-r from-gray-900 px-1 text-xs font-light text-cyan-300">Oriental
                            Mindoro
                        </div>
                    </a>

                    <nav class="flex items-center justify-center space-x-4">
                        <a href="#courses" class="rounded-md px-3 py-2 text-white/50 hover:text-sky-500">Courses</a>
                        <a href="#" class="rounded-md px-3 py-2 text-white/50 hover:text-sky-500">Community</a>
                        <a href="#" class="rounded-md px-3 py-2 text-white/50 hover:text-sky-500">About</a>
                    </nav>
                </div>

                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth

                            <a @if (Auth::user()->role == 'superadmin') href="{{ url('/website') }}" 
                                @elseif (Auth::user()->role == 'student') href="{{ route('enrolled_course') }}"
                            @elseif (Auth::user()->role == 'instructor') href="{{ url('/batch_list') }}" @endif
                                class="rounded-md bg-gray-900 from-sky-800 p-2 font-semibold text-gray-600 hover:bg-gradient-to-l focus:rounded-md focus:outline-none">
                                <img class="h-5 w-auto" src="{{ asset('/images/icons/lsi-logo.png') }}" alt="">
                            </a>
                            <div class="relative">
                                <x-dropdown align="right" width="46">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                            <div>
                                                {{ Auth::user()->role == 'instructor' ? 'Trainer ' : '' }}{{ Auth::user()->fname }}
                                                {{ Auth::user()->lname }}</div>

                                            <div class="ms-1">
                                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="m-1.5">

                                            <x-dropdown-link :href="route('profile.edit')"
                                                class="flex items-center space-x-1.5 rounded-md px-1.5">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
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
                                                    class="flex items-center space-x-1.5 rounded-md px-1.5"
                                                    onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
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

            <div class="flex h-full flex-col items-center p-4">
                <div class="flex">
                    <div x-data="{ show: false }" x-intersect:enter="show = true"
                        :class="{ 'opacity-100 translate-x-0': show, 'opacity-0 translate-x-full': !show }"
                        class="w-1/2 translate-x-full transform opacity-0 transition-opacity transition-transform duration-500 ease-out">
                        <h3 class="text-xl font-bold">Animated Element 1</h3>
                        <p class="mt-4 text-gray-600">This element slides in from the right as you scroll down.</p>
                    </div>
                    <div class="flex w-1/2 items-center rounded">
                        <swiper-container class="mySwiper h-full w-full" pagination="true"
                            pagination-clickable="true" space-between="30" effect="fade" navigation="true"
                            autoplay-delay="2500" autoplay-disable-on-interaction="false">
                            <swiper-slide>
                                <img src=" https://swiperjs.com/demos/images/nature-1.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
                            </swiper-slide>
                            <swiper-slide>
                                <img src="https://swiperjs.com/demos/images/nature-4.jpg" />
                            </swiper-slide>
                        </swiper-container>
                    </div>
                </div>
            </div>
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
            <h2 class="my-4 mb-8 text-center text-4xl font-bold">Featured Courses</h2>

            <div class="flex items-center justify-center">
                <div :class="{
                    'grid-cols-3': featuredCourses.length == 3,
                    'grid-cols-2': featuredCourses.length == 2,
                    'grid-cols-1': featuredCourses.length == 1,
                }"
                    class="grid gap-8">
                    <template x-for="course in featuredCourses" :key="course.id">
                        <div x-data="{ show: false }" x-intersect="show = true" :class="{ 'opacity-100 ': show }"
                            class="col-span-1 max-w-sm rounded-xl border-8 border-gray-200 bg-white opacity-0 shadow transition-opacity duration-700 ease-out dark:border-gray-800 dark:bg-gray-800">
                            <div class="h-44 w-full overflow-hidden rounded-t-lg">
                                <img class="h-full w-full object-cover object-center"
                                    :src="'{{ asset('storage/website/course_image/:course_id/:folder_name/:filename') }}'
                                    .replace(':course_id', course.id)
                                        .replace(':folder_name', course.folder)
                                        .replace(':filename', course.filename);"
                                    alt="" />
                            </div>
                            <div class="p-5">
                                <a href="#">
                                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"
                                        x-text="course.name"></h5>
                                </a>
                                <p class="mb-3 line-clamp-3 text-sm font-normal text-gray-700 dark:text-gray-400"
                                    x-text="course.description"></p>
                                <a :href="'{{ route('enroll', ':id') }}'.replace(':id', course.id)"
                                    class="inline-flex items-center rounded-lg text-center text-sm font-semibold text-white hover:text-sky-500 focus:outline-none">
                                    Learn more
                                    <svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="mt-5 text-center text-white">
                <a href="#" class="rounded-md px-3 py-2 text-sky-500 hover:text-sky-200">See All
                    Courses</a>
            </div>
        </div>

        {{-- <a href="#" x-data="{ showButton: false }" x-show="showButton"
            @click.prevent="window.scrollTo({ top: 0, behavior: 'smooth' })"
            @scroll.window="showButton = (window.scrollY > 200)" id="back-to-top"
            class="fixed bottom-4 right-4 hidden rounded-full bg-blue-500 p-3 text-white shadow-lg">
            Back to Top
        </a> --}}

        {{-- Instructor Modal --}}
        <div x-cloak x-show="noInstructorInfo" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50 pb-5">
            <div class="relative max-h-full w-full max-w-xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Instructor Information</h3>
                    </div>
                    <!-- Modal body -->
                    <form id="courseModalForm" class="p-4 pb-2 md:p-5" method="POST"
                        action="{{ route('record_instructor') }}">
                        @csrf
                        <div class="mb-2 grid grid-cols-2 gap-4">
                            <input type="hidden" id="course_id" name="course_id">
                            <input type="hidden" id="edit" name="edit" x-model="edit">
                            <div class="col-span-2">
                                <div class="flex justify-center">
                                    <input id="id_picture" required
                                        class="block h-3 w-1/2 cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                        type="file" name="id_picture" accept="image/*">
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label for="sex"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Sex</label>
                                <select name="sex" id="sex" required
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="region"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Region
                                    <span x-cloak x-show="errors.region" class="text-xs text-red-500"
                                        x-text="errors.region"></span></label>

                                <select name="region" id="region" x-model="form.region" @change="regionSelect"
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option selected value="">Select</option>
                                </select>
                                {{-- <input x-model="form.region" type="hidden" id="region_name" name="region_name" value=""> --}}
                                <template x-cloak x-show="errors.region">
                                    <p class="text-sm text-red-500" x-text="errors.region"></p>
                                </template>

                            </div>

                            <div class="col-span-2">
                                <label for="province"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Province</label>

                                <select x-model="form.province" name="province" id="province"
                                    @change="provinceSelect"
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option selected="">Select</option>
                                </select>
                                {{-- <input type="hidden" id="province_name" name="province_name" value=""> --}}
                                <template x-cloak x-show="errors.province">
                                    <p class="text-sm text-red-500" x-text="errors.province"></p>
                                </template>
                            </div>

                            <div class="col-span-2">
                                <label for="district"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">District</label>

                                <select x-model="form.district" name="district" id="district"
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option selected="">Select</option>
                                </select>
                                {{-- <input type="hidden" id="district_name" name="district_name" value=""> --}}

                                <template x-cloak x-show="errors.district">
                                    <p class="text-sm text-red-500" x-text="errors.district"></p>
                                </template>
                            </div>

                            <div class="col-span-2">
                                <label for="city"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">City/Municipality</label>

                                <select x-model="form.city" name="city" id="city" @change="citySelect"
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option selected="">Select</option>
                                </select>
                                <input type="hidden" id="city_name" name="city_name" value="">
                                <template x-cloak x-show="errors.city">
                                    <p class="text-sm text-red-500" x-text="errors.city"></p>
                                </template>
                            </div>

                            <div class="col-span-2">
                                <label for="barangay"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Barangay</label>

                                <select x-model="form.barangay" name="barangay" id="barangay"
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option selected="">Select</option>
                                </select>
                                <input type="hidden" id="barangay_name" name="barangay_name" value="">
                                <template x-cloak x-show="errors.barangay">
                                    <p class="text-sm text-red-500" x-text="errors.barangay"></p>
                                </template>
                            </div>

                            <div class="col-span-2">
                                <label for="street"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Street</label>
                                <input x-model="form.street" type="text" name="street" id="street"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="" required="">
                                <template x-if="errors.street">
                                    <p class="text-sm text-red-500" x-text="errors.street"></p>
                                </template>
                            </div>
                        </div>
                        <button type="submit"
                            class="mt-3 inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="-ms-1 me-1 h-5 w-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>check-circle-outline</title>
                                <path
                                    d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M12 20C7.59 20 4 16.41 4 12S7.59 4 12 4 20 7.59 20 12 16.41 20 12 20M16.59 7.58L10 14.17L7.41 11.59L6 13L10 17L18 9L16.59 7.58Z" />
                            </svg>
                            Submit
                        </button>
                    </form>
                    <form
                        class="mb-5 inline-flex w-full cursor-pointer justify-center text-sm text-white/50 hover:text-sky-500"
                        method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="flex items-center space-x-1.5 rounded-md px-1.5"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M14.08,15.59L16.67,13H7V11H16.67L14.08,8.41L15.5,7L20.5,12L15.5,17L14.08,15.59M19,3A2,2 0 0,1 21,5V9.67L19,7.67V5H5V19H19V16.33L21,14.33V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H19Z" />
                            </svg>
                            <div>
                                Log Out
                            </div>
                        </a>
                    </form>
                </div>
            </div>
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
            <li>
                {{ isset($message) ? $message : '' }}
            </li>
        </ul>
    </footer>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
    <script>
        function welcomePage() {
            return {
                user: @json($user),
                featuredCourses: @json($courses),
                noInstructorInfo: false,
                tempIdPicture: null,
                filePondInstance: null,

                errors: {},
                form: {
                    region: '',
                    province: '',
                    district: '',
                    city: '',
                    barangay: '',
                    street: '',
                },

                init() {
                    console.log(this.user);
                    if (this.user.role == 'instructor' && (!this.user.instructor_info || !this.user.instructor_info
                            .submitted)) {
                        this.noInstructorInfo = true;
                        document.body.classList.add('no-scroll');
                        this.notification('info',
                            'This account promoted to Instructor Role. Please complete the form to proceed.',
                            '')
                        this.filePond_config();
                        this.fetchRegions();
                    }

                },
                filePond_config() {
                    FilePond.registerPlugin(FilePondPluginImagePreview,
                        FilePondPluginImageCrop,
                        FilePondPluginImageTransform,
                        FilePondPluginImageResize,
                        FilePondPluginImageEdit,
                    );

                    const input_element = document.querySelector('#id_picture');
                    this.filepondInstance = FilePond.create(input_element);

                    var files = this.user.instructor_info ? [{
                        source: this.user.instructor_info.id,
                        options: {
                            type: 'local',
                        },
                    }, ] : []

                    this.filepondInstance.setOptions({
                        labelIdle: `Drag & Drop ID Picture or <span class="filepond--label-action">Browse</span>`,
                        allowImagePreview: true,
                        allowDownloadByUrl: true,
                        stylePanelLayout: 'compact circle',
                        imageCropAspectRatio: '1:1',
                        styleLoadIndicatorPosition: 'center bottom',
                        styleProgressIndicatorPosition: 'right bottom',
                        styleButtonRemoveItemPosition: 'left bottom',
                        styleButtonProcessItemPosition: 'right bottom',
                        files: files,

                        server: {
                            process: {
                                url: '{{ route('upload_instructor_picture') }}',
                                ondata: (formData) => {
                                    formData.append('credential_type', 'id_picture');
                                    return formData;
                                },
                            },
                            revert: {
                                url: '{{ route('revert_instructor_picture') }}',
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            },
                            load: `/record_information/load_instructor_picture/`,
                            remove: (source, load, error) => {
                                fetch(`/record_information/delete_instructor_picture/${source}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                }).then(response => {
                                    if (response.ok) {
                                        load();
                                    } else {
                                        error('Could not delete file');
                                    }
                                }).catch(() => {
                                    error('Could not delete file');
                                });
                            },
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        },
                    });
                },
                fetchRegions() {
                    $.ajax({
                        url: 'https://psgc.gitlab.io/api/regions/',
                        type: 'GET',
                        dataType: 'json',
                        success: (data) => {
                            const regionField = document.getElementById('region');
                            data.forEach(region => {
                                const option = document.createElement('option');
                                option.value = region.code;
                                option.text = region.name.toUpperCase();
                                regionField.appendChild(option);
                            });

                            // Auto-select the region loaded from the cookie
                            if (this.form.region) {
                                regionField.value = this.form.region;
                                this.regionSelect(); // Trigger province loading
                            }

                            // console.log(regionField);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching regions:', error);
                        }
                    });
                },
                async regionSelect() {
                    const regionCode = this.form.region;

                    try {
                        const response = await fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces`);
                        const data = await response.json();

                        const provinceField = document.getElementById('province');
                        provinceField.innerHTML = '<option value="">Select</option>';

                        // Append new options for provinces
                        data.forEach(province => {
                            const option = document.createElement('option');
                            option.value = province.code;
                            option.text = province.name.toUpperCase();
                            provinceField.appendChild(option);
                        });

                        if (this.form.province) {
                            provinceField.value = this.form.province;
                            this.provinceSelect(); // Trigger province loading
                        }
                    } catch (error) {
                        console.error('Error fetching provinces:', error);
                    }
                },
                async provinceSelect() {
                    const provCode = this.form.province; // Use the selected province from parameter or from data

                    try {
                        const response = await fetch(
                            `https://psgc.gitlab.io/api/provinces/${provCode}/cities-municipalities`);
                        const data = await response.json();

                        $('#city').empty();
                        $('#district').empty();
                        $('#city').append($('<option>', {
                            text: 'Select'
                        }));

                        data.forEach(city => {
                            $('#city').append($('<option>', {
                                value: city.code,
                                text: city.name.toUpperCase()
                            }));
                        });

                        if (this.form.district) {
                            $('#district').val(this.form.district)
                        }
                        this.districtSelect()

                    } catch (error) {
                        console.error('Error fetching cities:', error);
                    }
                },
                async districtSelect() {
                    try {
                        const response = await fetch('https://psgc.gitlab.io/api/districts');
                        const data = await response.json();

                        var districtField = $('#district');
                        $('#district').append($('<option>', {
                            text: 'Select'
                        }));

                        data.forEach(district => {
                            $('#district').append($('<option>', {
                                value: district.code,
                                text: district.name.toUpperCase()
                            }));
                        });

                        if (this.form.city) {
                            $('#city').val(this.form.city)
                            this.citySelect()
                        }

                        if (this.form.district) {
                            $('#district').val(this.form.district)

                        }
                    } catch (error) {
                        console.error('Error fetching districts:', error);
                    }
                },
                async citySelect() {
                    const cityCode = this.form.city; // Use the selected city from parameter or from data
                    try {
                        const response = await fetch(
                            `https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays`);
                        const data = await response.json();

                        $('#barangay').empty();
                        $('#barangay').append($('<option>', {
                            text: 'Select'
                        }));

                        data.forEach(barangay => {
                            $('#barangay').append($('<option>', {
                                value: barangay.code,
                                text: barangay.name.toUpperCase()
                            }));
                        });

                        if (this.form.barangay) {
                            $('#barangay').val(this.form.barangay)
                        }
                    } catch (error) {
                        console.error('Error fetching barangays:', error);
                    }
                },

                // Utility
                notification(status, message, title) {
                    status === 'success' ? toastr.success(message, title ?? title) : status == 'info' ? toastr.info(
                        message) : toastr.error(message, title ??
                        title);
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "showDuration": "300",
                        "hideDuration": "800",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                },
            }
        }
    </script>
</body>

</html>
