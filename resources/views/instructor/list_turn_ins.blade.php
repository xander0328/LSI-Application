<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $batch->course->name }}</span>
            </div>
            <div>Batch: {{ $batch->name }}</div>
        </div>
        <x-course-nav :batch="$batch->id" :selected="'assignment'"></x-course-nav>
        {{-- <div>
            <button onclick="startFCM()" class="btn btn-danger btn-flat">Allow notification
            </button>
        </div> --}}

    </x-slot>
    <div x-data="turnIns()" class="mx-8 mt-2 pt-44 text-white">
        <div class="mb-2 flex items-center justify-end">
            <div class="mx-1 my-1 flex rounded-lg p-2 hover:bg-gray-800">
                <label class="inline-flex w-full cursor-pointer items-center">
                    <input @change="closeSubmission()" type="checkbox"
                        :checked="assignment_details.closed ? true : false" class="assignment-toggle peer sr-only">
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
                        <a href="javascript:void(0)" data-action="{{ route('get_assignment', $assignment->id) }}"
                            @click="triggerModal()"
                            class="m-1 flex items-center rounded-lg p-2 py-1 align-middle hover:bg-gray-700">
                            <svg class="h-5 w-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>Edit
                        </a>
                    </li>

                    <li>
                        <form id="delete-course" class="px-1" action="{{ route('delete_assignment') }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="assignment_id" :value="assignment_details.id">
                            <button @click.prevent="confirmDelete()" type="submit"
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
                <div class="mt-4 text-sm font-bold">Instructions</div>
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
        <div class="pb-6">
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
            <div id="accordion-collapse" {{-- data-accordion="open" data-active-classes="bg-sky-800 text-white"
                data-inactive-classes="text-white" --}}>
                {{-- @foreach ($students as $student)
                @php
                    $turnIn = $turn_in_files
                        ->where('user_id', $student->user->id)
                        ->where('assignment_id', $assignment->id)
                        ->first();
                    $hasTurnedIn = $turnIn && $turnIn->turned_in;
                @endphp --}}
                <template x-for="student in filteredRecords " :key="student.id">
                    <div x-data="{ open: false }">
                        <h2 :id="`accordion-collapse-heading-${student.id}`" x-transition>
                            <button type="button" @click="open = !open"
                                :class="open ? 'bg-sky-800' : 'bg-gray-700 rounded-b-md'"
                                class="mt-2 flex w-full items-center justify-between gap-3 rounded-t-md bg-gray-700 p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white">
                                <div>
                                    <div x-text="student.user.lname + ', ' + student.user.fname "></div>
                                    <div class="flex justify-start" :id="`grade_status_${student.id}`">
                                        <span
                                            :class="student.grades[0].grade != 0 || student.grades[0].grade == null ?
                                                'bg-sky-600' :
                                                'bg-yellow-600'"
                                            class="rounded-full p-1 px-2 text-xs"
                                            x-text="student.grades[0].grade == 0 || student.grades[0].grade == null ? 'Not graded' : 'Graded'">
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
                                        x-text="student.turn_ins[0].turned_in ? 'Turned in' : 'Not turned in'">
                                        {{-- @if ($hasTurnedIn)
                                        Turned in
                                    @else
                                        Not turned in
                                    @endif --}}
                                    </span>
                                    <svg class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </div>

                            </button>
                        </h2>
                        <div x-show="open" x-transition {{-- :id="`accordion-collapse-body-${student.id}`" class="mb-2 hidden"
                            :aria-labelledby="`accordion-collapse-heading-${student.id}`" --}}>
                            <div class="rounded-b-md bg-gray-800 p-3">
                                <div class="mb-2 text-sm">Submitted Files</div>
                                <template
                                    x-if="!student.turn_ins[0].turned_in || student.turn_ins[0].turned_in == false || student.turn_ins[0].turn_in_files.length == 0">
                                    <div class="text-sm text-gray-500">
                                        None
                                    </div>
                                </template>

                                <template x-if="student.turn_ins[0].turned_in == true">
                                    <div>
                                        <template x-for="file in student.turn_ins[0].turn_in_files"
                                            :key="file.id">
                                            <div class="mb-2" x-data="{ path: `{{ asset('storage/assignments/') }}/${student.batch_id}/${assignment_id}/${student.id}/${file.folder}/${file.filename}`, 'imageShow': false }">
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
                                <div x-data="{ initialGrade: student.grades[0].grade, currentGrade: student.grades[0].grade }" class="mt-2 flex items-center">
                                    {{-- {{ $student }} --}}
                                    <div class="me-2 text-sm">Grade:</div>
                                    <input
                                        class="me-2 block w-full rounded-lg p-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        type="number" x-model="student.grades[0].grade"
                                        @input="console.log(`${initialGrade} ${currentGrade}`)" name="grade"
                                        :id="`grade_${student.id}`">
                                    <div @click="grade_changed(student.id)"
                                        class="cursor-pointer rounded-md p-2 hover:bg-sky-800">
                                        <svg class="w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </template>
                {{-- @endforeach --}}
            </div>

        </div>
        {{-- Assignment Modal --}}
        <div x-cloak x-show="showAssignmentModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-2xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Update Assignment
                        </h3>
                        <button @click="showAssignmentModal = !showAssignmentModal" type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
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
                                            <input type="checkbox" id="due_date_toggle" class="peer sr-only"
                                                :checked="assignment_details.due_date != null ? true : false">
                                            <div
                                                class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600 dark:peer-focus:ring-blue-800">
                                            </div>
                                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Set due</span>
                                        </label>
                                    </div>
                                </label>
                                <div id="due_inputs" x-show="assignment_details.due_date != null"
                                    class="grid grid-cols-2 gap-2">
                                    <div class="relative mb-px max-w-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input datepicker datepicker-autohide datepicker-buttons
                                            :value="moment(assignment_details.due_date).format('L')"
                                            datepicker-autoselect-today id="due_date" type="text" name="due_date"
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
                                            :value="assignment_details.due_hour"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            min="00:00" max="23:59" value="23:59" required />
                                    </div>
                                    <div class="col-span-2 flex items-center text-xs text-white">
                                        <input type="checkbox" :checked="assignment_details.closing"
                                            class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                            name="closing" id="closing">
                                        <label for="closing" class="ms-2">Close submissions after due
                                            date</label>
                                    </div>
                                </div>

                            </div>

                            <template x-if="course.course.structure != 'small'">
                                <div class="col-span-2">
                                    <template x-if="course.course.structure == 'big'">
                                        <div class="col-span-2">
                                            <label for="uc"
                                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Unit
                                                of
                                                Competency</label>

                                            <select id="uc" name="uc" required
                                                x-model="assignment_details.unit_of_competency_id"
                                                @change="ucChanged()"
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                                <option value="" selected>Select</option>

                                                <template x-for="uc in course.unit_of_competency"
                                                    :key="uc.id">
                                                    <option :value="uc.id" x-text="uc.title"
                                                        :selected="uc.id === assignment_details.unit_of_competency_id">
                                                    </option>
                                                </template>

                                            </select>

                                        </div>
                                    </template>
                                    <div class="col-span-2">
                                        <label for="lesson"
                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Lesson</label>

                                        <select id="lesson" name="lesson" x-model="assignment_details.lesson_id"
                                            required
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                            <option value="" selected>Select</option>
                                            <template x-for="lesson in selectedUc.lesson" :key="lesson.id">
                                                <option :value="lesson.id" x-text="lesson.title"
                                                    :selected="lesson.id === assignment_details.lesson_id"></option>
                                            </template>
                                        </select>

                                    </div>
                                </div>
                            </template>

                            <div class="col-span-2">
                                <label for="title"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                <input type="text" id="title" name="title"
                                    x-model="assignment_details.title"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Title" required />
                            </div>
                            <div class="col-span-2">
                                <label for="description"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea x-model="assignment_details.description" id="description" name="description" rows="2"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Assignment description"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="max_point"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Maximum
                                    Point</label>
                                <input x-model="assignment_details.points" type="number" id="max_point"
                                    name="max_point" required aria-describedby="helper-text-explanation"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Points" required />
                            </div>
                            <div class="text-xs text-white">
                                <a class="flex cursor-pointer items-center" @click="toggleShowAddFile()">Attach
                                    File/s
                                    <svg x-show="showAddFileModal" class="ml-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m5 15 7-7 7 7" />
                                    </svg>
                                    <svg x-show="!showAddFileModal" class="ml-2 h-4 w-4 text-gray-800 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 9-7 7-7-7" />
                                    </svg>
                                </a>
                            </div>

                            <div x-show="showAddFileModal" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95" id="show_addFile_assignment"
                                class="col-span-2">
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
    </div>

    @section('script')
        <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
        <script>
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
                    course: @json($batch),
                    maxPoint: {{ $assignment->points }},
                    assignment_id: {{ $assignment->id }},
                    assignment_details: @json($assignment),
                    assignment_files: [],
                    filepond_files: [],
                    sort_by: 'lname',
                    sort_direction: 'asc',
                    filteredRecords: [], // Store the filtered records
                    students: @json($students),
                    showAssignmentModal: false,
                    showAddFileModal: false,
                    selectedUc: [],
                    init() {
                        this.ucChanged();
                        console.log(this.course);
                        console.log(this.course.unit_of_competency[0].lesson);
                        this.students = this.students.map(student => {
                            if (!student.grades || student.grades.length === 0) {
                                student.grades = [{
                                    grade: 0
                                }];
                            }
                            if (!student.turn_ins || student.turn_ins.length === 0) {
                                student.turn_ins = [{
                                    turned_in: 0
                                }];
                            }
                            return student;
                        });
                        this.filteredRecords = this.students; // Initialize with all records

                        var assignmentLesson = this.selectedUc.lesson.find(lesson => lesson.id === this.assignment_details
                            .lesson_id);
                        this.assignment_files = assignmentLesson.assignment.find(assignment => assignment.id === this
                                .assignment_details
                                .id)
                            .assignment_files;

                        if (this.assignment_files) {
                            this.filepond_files = this.assignment_files.map(file => {
                                return {
                                    source: file.id,
                                    options: {
                                        type: 'local',
                                    },
                                }
                            })
                        }

                        if (this.filepond_files.length > 0) {
                            this.toggleShowAddFile();
                        }

                        this.filepond_config();

                    },
                    filterRecords() {
                        let sortedRecords = [...this.students];
                        if (this.sort_by) {
                            sortedRecords.sort((a, b) => {
                                let modifier = this.sort_direction === 'asc' ? 1 : -1;
                                if (this.sort_by === 'turned_in') {
                                    if (a.turn_ins[0][this.sort_by] < b.turn_ins[0][this.sort_by]) return -1 * modifier;
                                    if (a.turn_ins[0][this.sort_by] > b.turn_ins[0][this.sort_by]) return 1 * modifier;
                                } else if (this.sort_by === 'grade') {
                                    if (a.grades[0][this.sort_by] < b.grades[0][this.sort_by]) return -1 * modifier;
                                    if (a.grades[0][this.sort_by] > b.grades[0][this.sort_by]) return 1 * modifier;
                                } else {
                                    if (a.user[this.sort_by] < b.user[this.sort_by]) return -1 * modifier;
                                    if (a.user[this.sort_by] > b.user[this.sort_by]) return 1 * modifier;
                                }
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
                        console.log(student);
                        let grade = student.grades[0].grade;
                        let desc = '';
                        let color = '';

                        if (grade > this.maxPoint) {
                            alert('You cannot rate more than maximum point!')
                            // student.grades[0].grade = this.maxPoint
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
                                    // student.grades.grade_status =
                                    //     `<span class="bg-${color}-600 rounded-full p-1 px-2 text-xs">${desc}</span>`;
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    },
                    getGradeStatus(student) {
                        if (student.grades.grade == 0 || student.grades.grade === null) {
                            return '<span class="bg-yellow-600 rounded-full p-1 px-2 text-xs">Not graded</span>';
                        } else if (student.grades.grade > 0) {
                            return '<span class="bg-sky-600 rounded-full p-1 px-2 text-xs">Graded</span>';
                        }
                        return '';
                    },
                    confirmDelete() {
                        var form = event.target.closest('form');

                        Swal.fire({
                            title: "Are you sure?",
                            text: "Warning: All data related to this will also be deleted.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    },
                    closeSubmission() {
                        $.ajax({
                            url: '{{ route('assignment_toggle') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                assignment_id: {{ $assignment->id }}
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    },
                    triggerModal() {
                        this.showAssignmentModal = true;
                    },
                    ucChanged() {
                        this.selectedUc = this.course.unit_of_competency.find(uc => uc.id == this.assignment_details
                            .unit_of_competency_id)
                    },


                    filepond_config() {
                        const inputElement = document.querySelector('.assignment_files');
                        const pond = FilePond.create(inputElement)
                        FilePond.setOptions({
                            allowMultiple: true,
                            allowReorder: true,
                            files: this.filepond_files,
                            server: {
                                process: {
                                    url: '{{ route('temp_upload_assignment') }}',
                                    ondata: (formData) => {
                                        formData.append('batch_id', '{{ $batch->id }}');
                                        return formData;
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                },
                                load: '/get_uploaded_assignment_files/{{ $assignment->id }}/',
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
                    },
                    toggleShowAddFile() {
                        this.showAddFileModal = !this.showAddFileModal;
                    }
                }
            }

            var firebaseConfig = {
                apiKey: "AIzaSyBi4oNVlyHAk6hdk42V7XugS_eR8_ianVw",
                authDomain: "lsi-app-541ad.firebaseapp.com",
                projectId: "lsi-app-541ad",
                storageBucket: "lsi-app-541ad.appspot.com",
                messagingSenderId: "740784195857",
                appId: "1:740784195857:web:01c322ecbcf6cc18bda4b0"
            };
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            function startFCM() {
                messaging
                    .requestPermission()
                    .then(function() {
                        return messaging.getToken()
                    })
                    .then(function(response) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{{ route('store.token') }}',
                            type: 'POST',
                            data: {
                                token: response
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                alert('Token stored.');
                            },
                            error: function(error) {
                                alert(error);
                            },
                        });
                    }).catch(function(error) {
                        alert(error);
                    });
            }
            messaging.onMessage(function(payload) {
                const title = payload.notification.title;
                const options = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(title, options);
            });
        </script>
    @endsection
</x-app-layout>
