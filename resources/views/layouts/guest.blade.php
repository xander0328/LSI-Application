<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LSI | Login') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @laravelPWA

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>

<body class="font-sans text-gray-900 antialiased">
    {{-- <div class="flex min-h-screen flex-col place-items-center bg-gray-100 p-9 dark:bg-gray-950"> --}}
    <div class="flex min-h-screen items-center justify-evenly bg-gray-950 pt-0">
        <div>
            <a href="/" class="mr-9 items-center">
                <div class="px-1 text-3xl font-black text-cyan-500">Language Skills Institute</div>
                <div class="bg-gradient-to-r from-gray-900 px-1 text-xs font-light text-cyan-300">Oriental Mindoro</div>
            </a>
        </div>

        <div
            class="my-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md dark:bg-gray-800 sm:max-w-md sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
    @yield('script')
</body>

</html>
