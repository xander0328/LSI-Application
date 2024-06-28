@if (auth()->user()->role == 'student')
    <div class="mt-2 flex items-center justify-start text-white">
        <a href="{{ route('enrolled_course') }}">
            <button
                class="{{ $selected == 'stream' ? 'bg-sky-700' : '' }} flex items-center justify-center rounded-sm px-3 py-1.5 text-sm text-white hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">

                    <path fill="white"
                        d="M19 5V19H5V5H19M21 3H3V21H21V3M17 17H7V16H17V17M17 15H7V14H17V15M17 12H7V7H17V12Z" />
                </svg>
                Stream
            </button>
        </a>
        <a href="{{ route('enrolled_course_assignment') }}">
            <button
                class="{{ $selected == 'assignment' ? 'bg-sky-700' : '' }} ms-2 flex items-center justify-center rounded-sm px-3 py-1.5 text-sm text-white hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">
                    <path fill="currentColor"
                        d="M19.07 14.88L21.12 16.93L15.06 23H13V20.94L19.07 14.88M21.04 13.13C21.18 13.13 21.31 13.19 21.42 13.3L22.7 14.58C22.92 14.79 22.92 15.14 22.7 15.35L21.7 16.35L19.65 14.3L20.65 13.3C20.76 13.19 20.9 13.13 21.04 13.13M17 4V10L15 8L13 10V4H9V20H11V22H7C5.95 22 5 21.05 5 20V19H3V17H5V13H3V11H5V7H3V5H5V4C5 2.89 5.9 2 7 2H19C20.05 2 21 2.95 21 4V10L19 12V4H17M5 5V7H7V5H5M5 11V13H7V11H5M5 17V19H7V17H5Z" />
                </svg>
                Assignments</button>
        </a>
        <a href="{{ route('enrolled_course_attendance') }}">
            <button
                class="{{ $selected == 'attendance' ? 'bg-sky-700' : '' }} ms-2 flex items-center justify-center rounded-sm px-3 py-1.5 text-sm text-white hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">

                    <path fill="white"
                        d="M21.1,12.5L22.5,13.91L15.97,20.5L12.5,17L13.9,15.59L15.97,17.67L21.1,12.5M10,17L13,20H3V18C3,15.79 6.58,14 11,14L12.89,14.11L10,17M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4Z" />
                </svg>
                Attendance</button>
        </a>
    </div>
@elseif(auth()->user()->role == 'instructor')
    <div class="mt-2 flex items-center justify-start text-white">
        <a href="{{ route('batch_posts', encrypt($batch)) }}">
            <button
                class="{{ $selected == 'stream' ? 'bg-sky-700' : '' }} flex items-center justify-center rounded-sm px-3 py-1.5 text-sm text-white hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">

                    <path fill="white"
                        d="M19 5V19H5V5H19M21 3H3V21H21V3M17 17H7V16H17V17M17 15H7V14H17V15M17 12H7V7H17V12Z" />
                </svg>
                Stream
            </button>
        </a>
        <a href="{{ route('batch_assignments', $batch) }}">
            <button
                class="{{ $selected == 'assignment' ? 'bg-sky-700' : '' }} ms-2 flex items-center justify-center rounded-sm px-3 py-1.5 text-sm text-white hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">
                    <path fill="currentColor"
                        d="M19.07 14.88L21.12 16.93L15.06 23H13V20.94L19.07 14.88M21.04 13.13C21.18 13.13 21.31 13.19 21.42 13.3L22.7 14.58C22.92 14.79 22.92 15.14 22.7 15.35L21.7 16.35L19.65 14.3L20.65 13.3C20.76 13.19 20.9 13.13 21.04 13.13M17 4V10L15 8L13 10V4H9V20H11V22H7C5.95 22 5 21.05 5 20V19H3V17H5V13H3V11H5V7H3V5H5V4C5 2.89 5.9 2 7 2H19C20.05 2 21 2.95 21 4V10L19 12V4H17M5 5V7H7V5H5M5 11V13H7V11H5M5 17V19H7V17H5Z" />
                </svg>
                Assignments</button>
        </a>
        <a href="{{ route('batch_attendance', $batch) }}">
            <button
                class="{{ $selected == 'attendance' ? 'bg-sky-700' : '' }} ms-2 flex items-center justify-center rounded-sm px-3 py-1.5 text-sm text-white hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">

                    <path fill="white"
                        d="M21.1,12.5L22.5,13.91L15.97,20.5L12.5,17L13.9,15.59L15.97,17.67L21.1,12.5M10,17L13,20H3V18C3,15.79 6.58,14 11,14L12.89,14.11L10,17M11,4A4,4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4Z" />
                </svg>
                Attendance</button>
        </a>
    </div>
@endif
