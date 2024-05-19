<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Enrolled Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $batch->course->name }}</span>
            </div>
            <div>Batch: {{ $batch->name }}</div>
        </div>
        <div class="mt-2 flex items-center justify-start text-white">
            <a href="{{ route('batch_posts', encrypt($batch->id)) }}">
                <button class="flex items-center justify-center rounded-sm px-2 py-px text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">
                        <title>post-outline</title>
                        <path fill="white"
                            d="M19 5V19H5V5H19M21 3H3V21H21V3M17 17H7V16H17V17M17 15H7V14H17V15M17 12H7V7H17V12Z" />
                    </svg>
                    Stream
                </button>
            </a>

            <a href="{{ route('batch_assignments', $batch->id) }}">
                <button
                    class="ms-2 flex items-center justify-center rounded-sm bg-sky-700 px-2 py-px text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">
                        <title>book-open-variant</title>
                        <path fill="white"
                            d="M13,12H20V13.5H13M13,9.5H20V11H13M13,14.5H20V16H13M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M21,19H12V6H21" />
                    </svg>
                    Assignments</button>
            </a>
        </div>

    </x-slot>
    <div id="course_list" class="mx-8 mt-2 flex flex-col-reverse pt-44 text-white">
        <div> <a href="{{ route('list_turn_ins', $batch->id) }}">
                <button
                    class="ms-2 flex items-center justify-center rounded-sm px-2 py-px text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 w-5" viewBox="0 0 24 24">
                        <title>list-box-outline</title>
                        <path fill="white"
                            d="M11 15H17V17H11V15M9 7H7V9H9V7M11 13H17V11H11V13M11 9H17V7H11V9M9 11H7V13H9V11M21 5V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H19C20.1 3 21 3.9 21 5M19 5H5V19H19V5M9 15H7V17H9V15Z" />
                    </svg>
                    Student List</button>
            </a> </div>
        <div>
            @foreach ($students as $student)
                <div>
                    
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
