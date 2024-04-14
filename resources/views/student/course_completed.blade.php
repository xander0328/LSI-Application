<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Course/s Completed') }}
            </div>
        </div>
    </x-slot>
    <div id="course_list" class="mx-8 my-4">
        <ul class="space-y-2 font-semibold text-white">
            @if ($completed->count() == 0)
                <div>
                    <div class="rounded-lg bg-sky-950 p-4 text-center text-slate-400">No completed course
                    </div>
                </div>
            @else
                @foreach ($completed as $completed)
                    <li id="course-item" class="rounded-md bg-gray-700 p-2">
                        <div>
                            <div class="mb-px flex justify-between align-middle">
                                <div class="my-1 py-1">{{ $completed->course->name }}</div>
                                <div class="flex">

                                    <div class="flex">
                                        <button id="dropdownMenuIconHorizontalButton_{{ $completed->id }}"
                                            data-dropdown-toggle="dropdownDotsHorizontal_{{ $completed->id }}"
                                            class="my-1 inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                                            type="button">
                                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 16 3">
                                                <path
                                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                            </svg>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <hr class="border border-gray-500">
                            <div class="mt-2 text-sm font-thin">
                                <span class="font-semibold text-sky-400">Date Completed:</span>
                                {{ \Carbon\Carbon::parse($completed->completed_at)->format('Y-m-d') }}
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</x-app-layout>
