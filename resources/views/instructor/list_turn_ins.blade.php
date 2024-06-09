<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $batch->course->name }}</span>
            </div>
            <div>Batch: {{ $batch->name }}</div>
        </div>
        <x-course-nav :batch="$batch->id" :selected="'assignment'"></x-course-nav>

    </x-slot>
    <div class="mx-8 mt-2 pt-44 text-white">
        <div class="mb-2 flex items-center justify-end">
            <div class="mx-1 my-1 flex rounded-lg p-2 hover:bg-gray-800">
                <label class="inline-flex w-full cursor-pointer items-center">
                    <input data-assignment-id="{{ $assignment->id }}" type="checkbox"
                        {{ $assignment->closed ? 'checked' : '' }} class="assignment-toggle peer sr-only">
                    <div
                        class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-yellow-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-300">Close submissions</span>
                </label>
            </div>
            <button id="dropdownMenuIconHorizontalButton" data-dropdown-toggle="dropdownDotsHorizontal"
                class="my-1 inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800"
                type="button">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="white"
                    viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg>
            </button>

            <div id="dropdownDotsHorizontal"
                class="z-10 hidden w-52 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-800">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownMenuIconHorizontalButton">
                    <li>
                        <a href="javascript:void(0)" id="edit_assignment"
                            data-action="{{ route('get_assignment', $assignment->id) }}"
                            data-modal-target="edit_assignment_modal" data-modal-toggle="edit_assignment_modal"
                            class="m-1 flex items-center rounded-lg p-2 py-1 align-middle hover:bg-gray-700"><svg
                                class="h-5 w-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m10.8 17.8-6.4 2.1 2.1-6.4m4.3 4.3L19 9a3 3 0 0 0-4-4l-8.4 8.6m4.3 4.3-4.3-4.3m2.1 2.1L15 9.1m-2.1-2 4.2 4.2" />
                            </svg>Edit
                        </a>
                    </li>

                    <li>
                        <form id="delete-course" class="px-1" action="" method="post">
                            @method('DELETE')
                            <button onclick="confirmDelete()" type="submit"
                                class="flex w-full items-center rounded-lg p-1 px-2 align-text-bottom hover:bg-gray-700">
                                <svg class="h-5 w-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M8.6 2.6A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4c0-.5.2-1 .6-1.4ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Delete</button>
                        </form>

                    </li>
                </ul>
            </div>
        </div>
        <div class="rounded-lg bg-gray-700 p-4">
            <div class="text-2xl font-semibold text-white"> {{ $assignment->title }}
            </div>
            <div class="flex items-center p-px text-sm">
                <span
                    class="relative mr-px inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="white"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" />
                    </svg>
                </span>
                {{ $assignment->points }} points |
                <span
                    class="relative mx-px ml-2 inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="white"
                            d="M9,10V12H7V10H9M13,10V12H11V10H13M17,10V12H15V10H17M19,3A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5A2,2 0 0,1 5,3H6V1H8V3H16V1H18V3H19M19,19V8H5V19H19M9,14V16H7V14H9M13,14V16H11V14H13M17,14V16H15V14H17Z" />
                    </svg>
                </span>
                @if ($assignment->due_date != null)
                    <span> Due
                        {{ \Carbon\Carbon::parse($assignment->due_date)->format('F d, Y') }}
                        {{ \Carbon\Carbon::parse($assignment->due_hour)->format('h:i A') }}
                    </span>
                @else
                    <span> No due
                    </span>
                @endif
            </div>
            <div class="p-px text-xs">
                @if (!$assignment->closed)
                    @if ($assignment->closing)
                        Submission will be closed after due
                    @endif
                @endif
            </div>
            <div>
                <div class="mt-4 text-sm">Instructions</div>
                @if ($assignment->description == null)
                    <div class="mb-2 p-px text-sm text-gray-500">None</div>
                @else
                    <pre class="text-wrap mb-2 p-px font-sans text-sm">{{ $assignment->description }}</pre>
                @endif
                <div class="mt-2">
                    @foreach ($assignment->assignment_files as $files)
                        <x-file-type-checker :files="$files" :path="asset(
                            'storage/assignments/' .
                                $batch->id .
                                '/' .
                                $assignment->id .
                                '/' .
                                'assignment_files/' .
                                $files->filename,
                        )"></x-file-type-checker>
                    @endforeach
                </div>
            </div>
        </div>
        <br>
        <div class="pb-6" x-data="turnIns()">
            <div>
                <span class="text-sm">Sort by</span>
                <select x-model="sort_by" @change="filterRecords"
                    class="mb-2 w-1/3 rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                    <option value="lname">Surname</option>
                    <option value="fname">First name</option>
                    <option value="turned_in">Turn in status</option>
                    <option value="grade">Grade</option>
                </select>
                <select x-model="sort_direction"
                    class="mb-2 w-1/4 rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white" @change="filterRecords">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <div id="accordion-collapse" data-accordion="open" data-active-classes="bg-sky-800 text-white"
                data-inactive-classes="text-white">
                {{-- @foreach ($students as $student)
                @php
                    $turnIn = $turn_in_files
                        ->where('user_id', $student->user->id)
                        ->where('assignment_id', $assignment->id)
                        ->first();
                    $hasTurnedIn = $turnIn && $turnIn->turned_in;
                @endphp --}}
                <template x-for="student in filteredRecords " :key="student.id">
                    <div>
                        <h2 :id="`accordion-collapse-heading-${student.id}`">
                            <button type="button"
                                class="mt-2 flex w-full items-center justify-between gap-3 bg-gray-700 p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white"
                                :data-accordion-target="`#accordion-collapse-body-${student.id}`" aria-expanded="false"
                                :aria-controls="`accordion-collapse-body-${student.id}`">
                                <div>
                                    <div x-text="student.lname + ', ' + student.fname "></div>
                                    <div class="flex justify-start" :id="`grade_status_${student.id}`">
                                        <span
                                            :class="student.grade != 0 || student.grade == null ? 'bg-sky-600' : 'bg-yellow-600'"
                                            class="rounded-full p-1 px-2 text-xs"
                                            x-text="student.grade == 0 || student.grade == null ? 'Not graded' : 'Graded'">
                                            {{-- @if ($student->grade)
                                            Graded
                                        @else
                                            Not graded
                                        @endif --}}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="me-2 text-sm italic"
                                        x-text="student.turned_in ? 'Turned in' : 'Not turned in'">
                                        {{-- @if ($hasTurnedIn)
                                        Turned in
                                    @else
                                        Not turned in
                                    @endif --}}
                                    </span>
                                    <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </div>

                            </button>
                        </h2>
                        <div :id="`accordion-collapse-body-${student.id}`" class="mb-2 hidden"
                            :aria-labelledby="`accordion-collapse-heading-${student.id}`">
                            <div class="bg-gray-800 p-3">
                                <div class="mb-2 text-sm">Submitted Files</div>
                                <div class="text-sm text-gray-500" x-if="student.turned_in == false">None</div>

                                <template x-if="student.turned_in == true">
                                    <div>
                                        <template x-for="file in student['files']" :key="file.id">
                                            <div x-data="{ path: `{{ asset('storage/assignments/') }}/${student.batch_id}/${assignment_id}/${student.user_id}/${file.folder}/${file.filename}` }">
                                                <x-file-type-checker-alpine></x-file-type-checker-alpine>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                {{-- @if ($file->user_id === $student->user_id)
                                    @if ($file->turned_in)
                                        @if (Str::startsWith($file->file_type, 'image/'))
                                            <div class="mb-2">
                                                <a target="_blank"
                                                    class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-600"
                                                    href="{{ asset('storage/assignments/' . $batch->id . '/' . $assignment->id . '/' . $student->user_id . '/' . $file->folder . '/' . $file->filename) }}">
                                                    <svg class="mr-2 h-6 w-6" fill="gray"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>text-box</title>
                                                        <path
                                                            d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                                    </svg>
                                                    {{ substr(str_replace('uploads/', '', $file->filename), strpos(str_replace('uploads/', '', $file->filename), '_')1) }}
                                                </a>
                                            </div>
                                        @elseif ($file->file_type == 'application/pdf')
                                            <div class="mb-2">
                                                <a target="_blank"
                                                    class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-600"
                                                    href="{{ asset('storage/assignments/' . $batch->id . '/' . $assignment->id . '/' . $student->user_id . '/' . $file->folder . '/' . $file->filename) }}">
                                                    <svg class="mr-2 h-6 w-6" fill="rgb(185 28 28)"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>file-pdf-box</title>
                                                        <path
                                                            d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
                                                    </svg>
                                                    {{ substr(str_replace('uploads/', '', $file->filename), strpos(str_replace('uploads/', '', $file->filename), '_') + 1) }}</a>
                                            </div>
                                        @elseif (Str::endsWith($file->filename, '.docx') || Str::endsWith($file->filename, '.doc'))
                                            <div class="mb-2">
                                                <a target="_blank" download
                                                    class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-600"
                                                    href="{{ asset('storage/assignments/' . $batch->id . '/' . $assignment->id . '/' . $student->user_id . '/' . $file->folder . '/' . $file->filename) }}">
                                                    <svg class="mr-2 h-6 w-6" fill="rgb(2 132 199)"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>file-word-box</title>
                                                        <path
                                                            d="M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                                    </svg>

                                                    {{ substr(str_replace('uploads/', '', $file->filename), strpos(str_replace('uploads/', '', $file->filename), '_') + 1) }}</a>
                                            </div>
                                        @elseif (Str::endsWith($file->filename, '.xlsx') ||
                                                Str::endsWith($file->filename, '.xls') ||
                                                Str::endsWith($file->filename, '.csv'))
                                            <div class="mb-2">
                                                <a target="_blank" download
                                                    class="flex rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-600"
                                                    href="{{ asset('storage/assignments/' . $batch->id . '/' . $assignment->id . '/' . $student->user_id . '/' . $file->folder . '/' . $file->filename) }}">
                                                    <svg class="mr-2 h-6 w-6" fill="rgb(22 163 74)"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>file-excel-box</title>
                                                        <path
                                                            d="M16.2,17H14.2L12,13.2L9.8,17H7.8L11,12L7.8,7H9.8L12,10.8L14.2,7H16.2L13,12M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                                    </svg>
                                                    {{ substr(str_replace('uploads/', '', $file->filename), strpos(str_replace('uploads/', '', $file->filename), '_') + 1) }}</a>
                                            </div>
                                        @elseif (Str::endsWith($file->filename, '.txt'))
                                            <div class="mb-2">
                                                <a target="_blank" download
                                                    class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-600"
                                                    href="{{ asset('storage/assignments/' . $batch->id . '/' . $assignment->id . '/' . $student->user_id . '/' . $file->folder . '/' . $file->filename) }}">
                                                    <svg class="mr-2 h-6 w-6" fill="gray"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>text-box</title>
                                                        <path
                                                            d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                                    </svg>
                                                    {{ substr(str_replace('uploads/', '', $file->filename), strpos(str_replace('uploads/', '', $file->filename), '_') + 1) }}</a>
                                            </div>
                                        @else
                                            <div class="mb-2">
                                                <a target="_blank" download
                                                    class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-600"
                                                    href="{{ asset('storage/assignments/' . $batch->id . '/' . $assignment->id . '/' . $student->user_id . '/' . $file->folder . '/' . $file->filename) }}">
                                                    <svg class="mr-2 h-6 w-6" fill="gray"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>file-document</title>
                                                        <path
                                                            d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M15,18V16H6V18H15M18,14V12H6V14H18Z" />
                                                    </svg>
                                                    {{ substr(str_replace('uploads/', '', $file->filename), strpos(str_replace('uploads/', '', $file->filename), '_') + 1) }}
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @endif --}}
                                <hr class="mt-2 border-t-2 border-gray-600">
                                <div class="mt-2 flex items-center">
                                    {{-- {{ $student }} --}}
                                    <div class="me-2 text-sm">Grade:</div>
                                    <input
                                        class="block w-full rounded-lg p-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        type="number" x-model="student.grade" @input="grade_changed(student.id)"
                                        name="grade" :id="`grade_${student.id}`">
                                </div>
                            </div>

                        </div>
                    </div>
                </template>
                {{-- @endforeach --}}
            </div>

        </div>

    </div>
    <div id="edit_assignment_modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Update Assignment
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="edit_assignment_modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="edit_assignment" action="{{ route('post_assignment') }}" method="post"
                    enctype="multipart/form-data" class="p-4 md:p-5">
                    @csrf
                    <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                    <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="time"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                <div class="flex rounded-lg">
                                    <label class="inline-flex w-full cursor-pointer items-center">
                                        <input type="checkbox" id="due_date_toggle" class="peer sr-only">
                                        <div
                                            class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600 dark:peer-focus:ring-blue-800">
                                        </div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Set due</span>
                                    </label>
                                </div>
                            </label>
                            <div id="due_inputs" class="grid hidden grid-cols-2 gap-2">
                                <div class="relative mb-px max-w-sm">
                                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input datepicker datepicker-autohide datepicker-buttons datepicker-autoselect-today
                                        id="due_date" type="text" name="due_date"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        placeholder="Select date">
                                </div>
                                <div class="relative">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 end-0 top-0 flex items-center pe-3.5">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="time" id="due_time" name="due_hour"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        min="00:00" max="23:59" value="23:59" required />
                                </div>
                                <div class="col-span-2 flex items-center text-xs text-white">
                                    <input type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                        name="closing" id="closing">
                                    <label for="closing" class="ms-2">Close submissions after due
                                        date</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-span-2">
                            <label for="lesson"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Lesson</label>

                            <select id="lesson" name="lesson"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                <option selected>Select</option>
                                @foreach ($batch->lesson as $lesson)
                                    <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-span-2">
                            <label for="title"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                            <input type="text" id="title" name="title"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Title" required />
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="description" name="description" rows="2"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Assignment description"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label for="max_point"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Maximum
                                Point</label>
                            <input type="number" id="max_point" name="max_point" required
                                aria-describedby="helper-text-explanation"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Points" required />
                        </div>
                        <div class="text-xs text-white">
                            <a class="flex cursor-pointer items-center"
                                onclick="toggleShowAddFile('assignment')">Attach File/s<svg id="icon_assignment"
                                    class="ml-px h-4 w-4 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 9-7 7-7-7" />
                                </svg>
                            </a>
                        </div>

                        <div id="show_addFile_assignment" class="col-span-2 hidden">
                            {{-- <label for="name"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Attach
                                File/s</label> --}}
                            {{-- <input
                                class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                type="file" name="file[]" accept=".jpg, .png, .xlsx, .docx, .txt" multiple> --}}
                            <input type="file" class="filepond assignment_files" id="assignment_files"
                                name="assignment_files[]" multiple />
                        </div>

                    </div>
                    <div class="flex w-full rounded-md shadow-sm" role="group">
                        <button type="submit"
                            class="flex-1 items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                            <div class="flex justify-center">
                                Update
                            </div>
                        </button>
                    </div>

                    <div id="schedule_assign"
                        class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Schedule</a>
                            </li>
                        </ul>
                    </div>

                </form>

            </div>
        </div>

    </div>
    @section('script')
        <script>
            $(document).ready(function() {
                $('.assignment-toggle').change(function() {
                    var assignment_id = $(this).data('assignment-id');
                    var isEnabled = $(this).is(':checked');

                    $.ajax({
                        url: '{{ route('assignment_toggle') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            assignment_id: assignment_id
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });

                const inputElement = document.querySelector('.assignment_files');
                const pond = FilePond.create(inputElement)
                FilePond.setOptions({
                    allowMultiple: true,
                    allowReorder: true,
                    server: {
                        process: {
                            url: '{{ route('temp_upload_assignment') }}',
                            ondata: (formData) => {
                                formData.append('batch_id', '{{ $batch->id }}');
                                return formData;
                            },
                        },
                        load: '/load_uploaded_files/{{ $batch->id }}',
                        revert: {
                            url: '{{ route('revert_assignment_file') }}',
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            ondata: (formData) => {
                                formData.append('batch_id', '{{ $batch->id }}');
                                return formData;
                            }
                        },
                        remove: (source, load, error) => {
                            fetch(`/delete_uploaded_assignment_file/{{ $assignment->id }}/${source}`, {
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

                fetch(`/get_uploaded_assignment_files/{{ $assignment->id }}`)
                    .then(response => response.json())
                    .then(files => {
                        const fileItems = files.map(file => ({
                            source: file.id,
                            options: {
                                type: 'local',
                                file: {
                                    name: file.filename,
                                    type: file
                                        .file_type // You can fetch the actual file type if stored in the database
                                },
                                metadata: {
                                    id: file.id,
                                }
                            }
                        }));
                        pond.files = fileItems;
                        console.log(files);
                        if (fileItems.length > 0)
                            toggleShowAddFile('assigment')
                    })
                    .catch(error => console.error('Error loading files:', error));


                var toggle = $('#due_date_toggle')
                toggle.click(function() {
                    var due_inputs = $('#due_inputs')
                    due_inputs.toggleClass('hidden')

                    if ($(this).is(':checked')) {
                        $('#due_date').prop('required', true);
                        $('#due_time').prop('required', true);

                    } else {
                        $('#due_date').prop('required', false);
                        $('#due_time').prop('required', false);
                    }
                })

                $('#due_date_toggle').on('change', function() {
                    $('#due_date').val('')
                })

                $('#sort_by').on('change', function() {
                    const selectedValue = $(this).val();
                    const currentUrl = window.location.href;
                    const urlWithoutParams = currentUrl.split('?')[0];
                    const newUrl = urlWithoutParams + '?sort=' + encodeURIComponent(selectedValue);
                    window.location.href = newUrl;
                })

                $('#edit_assignment').on('click', function() {
                    var assignment = $(this).data('action')
                    var due_inputs = $('#due_inputs')
                    var due_date_toggle = $('#due_date_toggle')
                    var due_closing = $('#closing')

                    $('#due_date').val('');
                    $('#due_time').val('');
                    $('#lesson').val('');
                    $('#title').val('');
                    $('#description').val('');
                    $('#max_point').val('');
                    due_date_toggle.prop('checked', false)
                    due_closing.prop('checked', false)

                    $.get(assignment, function(data) {
                        console.log(assignment);
                        // $('#edit_assignmeny_modal').show();

                        if (data.due_date != null) {
                            due_inputs.removeClass('hidden')
                            due_date_toggle.prop('checked', true)

                            if (data.closing) {
                                due_closing.prop('checked', true)
                            }
                        }

                        $('#assignment_id').val(data.id);
                        $('#due_date').val(data.due_date);
                        $('#due_time').val(data.due_hour);
                        $('#description').val(data.description);
                        $('#lesson').val(data.lesson_id);
                        $('#max_point').val(data.points);
                        $('#title').val(data.title);
                    })
                })
            })

            function toggleShowAddFile(type) {
                if (type === 'post') {
                    var content = document.getElementById('show_addFile_post');
                    var icon = document.getElementById('icon_post');
                } else {
                    var content = document.getElementById('show_addFile_assignment');
                    var icon = document.getElementById('icon_assignment');
                }
                console.log(icon);

                content.classList.toggle('hidden');
                if (!content.classList.contains('hidden')) {
                    icon.innerHTML = `
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7"/>
                </svg>`;
                } else {
                    icon.innerHTML = `
                <svg class="h-3 w-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>`;
                }
            }

            function turnIns() {
                return {
                    maxPoint: {{ $assignment->points }},
                    assignment_id: {{ $assignment->id }},
                    sort_by: 'lname',
                    sort_direction: 'asc',
                    filteredRecords: [], // Store the filtered records
                    students: [
                        @foreach ($students as $student)
                            @php
                                $turnIn = $turn_in_files
                                    ->where('user_id', $student->user->id)
                                    ->where('assignment_id', $assignment->id)
                                    ->first();
                                $hasTurnedIn = $turnIn && $turnIn->turned_in;
                            @endphp {
                                id: {{ $student->enrollee_id }},
                                fname: '{{ $student->user->fname }}',
                                lname: '{{ $student->user->lname }}',
                                batch_id: {{ $student->batch_id }},
                                user_id: {{ $student->user_id }},
                                grade: {{ $student->grade ? $student->grade : 0 }},
                                turned_in: {{ $turnIn && $turnIn->turned_in != 0 ? 'true' : 'false' }},
                                hasFile: {{ $hasTurnedIn ? 'true' : 'false' }},
                                files: [
                                    @foreach ($turn_in_files as $files)
                                        @if ($files->user_id == $student->user->id)
                                            {!! json_encode($files) !!},
                                        @endif
                                    @endforeach
                                ]
                            },
                        @endforeach
                    ],
                    init() {
                        console.log(this.students[0].files);
                        this.filteredRecords = this.students; // Initialize with all records
                    },
                    filterRecords() {
                        let sortedRecords = [...this.students];
                        if (this.sort_by) {
                            sortedRecords.sort((a, b) => {
                                let modifier = this.sort_direction === 'asc' ? 1 : -1;
                                if (a[this.sort_by] < b[this.sort_by]) return -1 * modifier;
                                if (a[this.sort_by] > b[this.sort_by]) return 1 * modifier;
                                return 0;
                            });

                            this.filteredRecords = sortedRecords;
                        } else {
                            this.filteredRecords = this.students;
                        }
                        // console.log(sortedRecords);
                    },
                    grade_changed(enrollee_id) {
                        let student = this.students.find(s => s.id === enrollee_id);
                        let grade = student.grade;
                        let desc = '';
                        let color = '';

                        if (grade > this.maxPoint) {
                            alert('You cannot rate more than maximum point!')
                            student.grade = this.maxPoint
                        } else {

                            fetch('{{ route('update_grade') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        enrollee_id: enrollee_id,
                                        assignment_id: {{ $assignment->id }},
                                        batch_id: {{ $batch->id }},
                                        grade: grade
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // if (grade == 0 || grade === null) {
                                    //     desc = 'Not graded';
                                    //     color = 'yellow';
                                    // } else if (grade > 0 || grade !== null) {
                                    //     desc = 'Graded';
                                    //     color = 'sky';
                                    // }
                                    // student.grade_status =
                                    //     `<span class="bg-${color}-600 rounded-full p-1 px-2 text-xs">${desc}</span>`;
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    },
                    getGradeStatus(student) {
                        if (student.grade == 0 || student.grade === null) {
                            return '<span class="bg-yellow-600 rounded-full p-1 px-2 text-xs">Not graded</span>';
                        } else if (student.grade > 0) {
                            return '<span class="bg-sky-600 rounded-full p-1 px-2 text-xs">Graded</span>';
                        }
                        return '';
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
