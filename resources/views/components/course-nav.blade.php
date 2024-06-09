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

                    <path fill="white"
                        d="M13,12H20V13.5H13M13,9.5H20V11H13M13,14.5H20V16H13M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M21,19H12V6H21" />
                </svg>
                Assignments</button>
        </a>
        <a href="{{ route('enrolled_course') }}">
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

                    <path fill="white"
                        d="M13,12H20V13.5H13M13,9.5H20V11H13M13,14.5H20V16H13M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M21,19H12V6H21" />
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
