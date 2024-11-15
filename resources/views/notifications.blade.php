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
    </style>

</head>

<body class="font-sans antialiased bg-gray-200 dark:bg-gray-900">

    <div>
        @extends('layouts.navigation')
        <div class="fixed left-0 right-0 z-10 shadow-lg top-16">
            <div class="z-10 flex items-center bg-white shadow-lg">
                <span class="px-4 py-6 text-2xl font-bold">
                    Notifications
                </span>
            </div>
        </div>
        <div x-data="notifList" class="pt-40 mx-2">
            <template x-for="notif in  notifications" :key="notif.id">

                <template x-if="notif.data.subject === 'enrollment'">
                    <div class="flex items-center p-2 mb-1 bg-white rounded-lg hover:bg-sky-50"">
                        <div class="me-1.5 flex items-center">
                            <span class="w-10 h-10 me-1">
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
                        <div>
                            <div>
                                <span :class="{
                                    'border-lime-500 bg-lime-300' : notif.data.status === 'accepted',
                                    'border-red-500 bg-red-300' : notif.data.status !== 'accepted'
                                }" class="px-2 border rounded">
                                    <span>Status:</span>
                                    <span class="capitalize" x-text="notif.data.status"></span>
                                </span>
                            </div>
                            <div>
                                <span class="text-sm" x-text="notif.data.message"></span>
                            </div>
                            <template x-if="notif.data.status === 'accepted'">
                                <div class="mt-2 text-sm">
                                    <span>Download your ID Card here: </span>
                                    <span class="px-2 py-1 text-center rounded whitespace-nowrap bg-sky-400 hover:bg-sky-500"><a :href="notif.data.id_card_link">My Profile</a></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

            </template>
        </div>
    </div>
</body>

<script>
    function notifList() {
        return {
            notifications: [],
            unreadNotificationCount: 0,
            notificationCount: 0,
            notificationLoading: false,
            init() {
                this.getNotifications()
            },
            async getNotifications() {
                const t = this; // Capture the context of `this`
                t.notificationLoading = true;
                try {
                    const response = await $.ajax({
                        url: '{{ route('get_all_notifications') }}',
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
                }
            }
        }
    }
</script>