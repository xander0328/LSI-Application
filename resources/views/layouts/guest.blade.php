<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LSI | Login') }}</title>
    <link rel="icon" sizes="512x512" href="/images/icons/icon-512x512.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @laravelPWA

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    {{-- filepond --}}
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js">
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div style="background-image: url('{{ asset('images/elements/ekonek_bg.png') }}');"
        class="flex min-h-screen items-center justify-center bg-cover bg-center pt-0">
        <div class="w-3/4 md:w-1/2">
            <div>
                <a href="/" class="mb-10 mt-3 flex items-center justify-center space-x-2">
                    <span>
                        <img class="h-10 w-10" src="{{ asset('/images/elements/lsi_logo.png') }}" alt=""
                            srcset="">
                    </span>
                    <div>
                        <div class="px-1 font-black text-cyan-500">Language Skills Institute</div>
                        <div class="bg-gradient-to-r from-gray-900 px-1 text-xs font-light text-cyan-300">Oriental
                            Mindoro
                        </div>
                    </div>
                </a>
                <div class="flex justify-center">
                    <img class="w-2/3" src="{{ asset('/images/elements/ekonek_logo.png') }}" alt=""
                        srcset="">
                </div>
            </div>

            <div class="flex justify-center">
                <div
                    class="bg-white/65 my-6 w-full overflow-hidden rounded-lg px-6 py-4 shadow-md dark:bg-gray-800 sm:max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

    @yield('script')
</body>

</html>
