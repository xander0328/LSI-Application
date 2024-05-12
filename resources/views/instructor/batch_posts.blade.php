<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $batch->course->name }}</span>
            </div>
            <div class="flex items-center">
                <div class="mr-4">Batch: {{ $batch->name }}</div>
                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="flex items-center justify-center rounded-md bg-sky-700 p-2 px-3" type="button"><svg
                        class="h-4 w-4 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdown"
                    class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a data-modal-target="create-post-modal" data-modal-toggle="create-post-modal"
                                class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Post</a>
                        </li>
                        <li>
                            <a data-modal-target="create-assignment-modal" data-modal-toggle="create-assignment-modal"
                                class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Assignment</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </x-slot>
    <div id="course_list" class="flex flex-col-reverse px-8 pt-36 text-white">
        {{-- {{ $post }} --}}
        @foreach ($posts as $post)
            <div class="my-2 rounded-md bg-gray-800 p-3">
                <div class="align-center flex px-2 text-xs">
                    <svg class="mr-1 h-3 w-3 self-center text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div class="created_at">
                        {{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d H:i') }}
                    </div>
                </div>
                <hr class="my-2 opacity-25">
                <div class="rounded-b-md bg-gray-700 p-2">
                    @if ($post->description != null)
                        <div class="post mb-2">
                            <pre class="description text-md font-sans">{{ $post->description }}</pre>
                        </div>
                    @endif
                    <div class="flex">
                        @foreach ($post->files as $files)
                            @if (Str::startsWith($files->file_type, 'image/'))
                                <div class="mb-2 mr-2 mr-2">
                                    <a href="{{ asset('storage/' . $files->path) }}" target="_blank" download><img
                                            class="h-48 w-auto flex-1" src="{{ asset('storage/' . $files->path) }}"
                                            alt="{{ str_replace('uploads/', '', $files->path) }}">
                                    </a>
                                </div>
                            @endif

                            @if ($files->file_type == 'application/pdf')
                                <div class="mb-2 mr-2">
                                    <a target="_blank" class="flex rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(185 28 28)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-pdf-box</title>
                                            <path
                                                d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
                                        </svg>
                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif

                            @if (Str::endsWith($files->path, '.docx') || Str::endsWith($files->path, '.doc'))
                                <div class="mb-2 mr-2">
                                    <a target="_blank" download
                                        class="flex rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(2 132 199)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-word-box</title>
                                            <path
                                                d="M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>

                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif
                            @if (Str::endsWith($files->path, '.xlsx') || Str::endsWith($files->path, '.xls') || Str::endsWith($files->path, '.csv'))
                                <div class="mb-2 mr-2">
                                    <a target="_blank" download
                                        class="flex rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(22 163 74)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-excel-box</title>
                                            <path
                                                d="M16.2,17H14.2L12,13.2L9.8,17H7.8L11,12L7.8,7H9.8L12,10.8L14.2,7H16.2L13,12M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>
                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif
                            @if (Str::endsWith($files->path, '.txt'))
                                <div class="mb-2 mr-2">
                                    <a target="_blank" download
                                        class="flex rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>text-box</title>
                                            <path
                                                d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>
                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    {{-- Create Post Modal --}}
    <div id="create-post-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Post
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="create-post-modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="post_form" action="{{ route('post') }}" method="post" enctype="multipart/form-data"
                    class="p-4 md:p-5">
                    @csrf
                    <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="message"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea id="message" name="message" rows="2"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Write post description here"></textarea>
                        </div>
                        <div class="rounded-full text-xs text-white">
                            <a class="flex cursor-pointer items-center" onclick="toggleShowAddFile('post')">Attach
                                File/s<svg id="icon_post" class="ml-2 h-4 w-4 text-gray-800 dark:text-white"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 9-7 7-7-7" />
                                </svg>
                            </a>
                        </div>

                        <div id="show_addFile_post" class="col-span-2 hidden">
                            {{-- <label for="name"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Attach
                                File/s</label> --}}
                            <input
                                class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                type="file" name="file[]" accept=".jpg, .png, .xlsx, .docx, .txt" multiple>
                        </div>

                    </div>
                    <button type="button" onclick="formCheck()"
                        class="w-full items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                        <div class="flex justify-center">
                            Post
                        </div>
                    </button>

                </form>
            </div>
        </div>
    </div>

    {{-- Create Assignment Modal --}}
    <div id="create-assignment-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-xl p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Assignment
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="create-assignment-modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="post_assignment" action="{{ route('post_assignment') }}" method="post"
                    enctype="multipart/form-data" class="p-4 md:p-5">
                    @csrf
                    <input type="hidden" name="batch_id" value="{{ $batch->id }}">
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
                                    <input datepicker datepicker-buttons datepicker-autoselect-today id="due_date"
                                        type="text" name="due_date"
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
                            <input type="file" class="filepond assignment_files" name="assignment_files[]"
                                multiple />
                        </div>

                    </div>
                    <div class="flex w-full rounded-md shadow-sm" role="group">
                        <button type="submit"
                            class="flex-1 items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                            <div class="flex justify-center">
                                Assign
                            </div>
                        </button>
                        {{-- <button data-dropdown-toggle="schedule_assign"
                            class="flex-none items-center bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            <svg class="h-4 w-4 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>

                        </button> --}}
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        {{-- File Pond --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const posts = document.querySelectorAll('.post');
                const created_at = document.querySelectorAll('#created_at')

                posts.forEach(function(post) {
                    const description = post.querySelector('.description');
                    const content = description.innerHTML;

                    // Regular expression to find URLs
                    const urlRegex = /(https?:\/\/\S+)/g;

                    // Replace URLs with anchor tags
                    const replacedContent = content.replace(urlRegex,
                        '<a class="text-sky-500 hover:text-underlined" href="$1" target="_blank">$1</a>');

                    // Update the description content
                    description.innerHTML = replacedContent;
                });

                $('.created_at').each(function() {
                    var createdAtText = $(this).text().trim();
                    console.log(createdAtText.trim());

                    var createdAtMoment = moment(createdAtText, 'YYYY-MM-DD HH:mm');

                    // Calculate the difference between the current date and the parsed date
                    var diffInMonths = moment().diff(createdAtMoment, 'weeks');

                    // Format the date based on the difference
                    var formattedDate;
                    if (diffInMonths <= 1) {
                        // If less than 1 month ago, format with relative time
                        formattedDate = createdAtMoment.calendar();
                    } else {
                        // Otherwise, format with the desired full date format
                        formattedDate = createdAtMoment.format('MM/DD/YYYY hh:mm A');
                    }
                    // Replace the content of the current element with the formatted date
                    $(this).text(formattedDate);
                });
            })

            function formCheck() {
                var messageValue = $('#message').val();
                var fileValue = $('input[name="file[]"]').val();

                if (messageValue.trim() === '' && fileValue === '') {
                    alert('Please provide a message or upload a file.');
                    return
                    // console.log(fileValue);
                }
                // if (messageValue.trim() === '' && fileValue === '') {
                //     // If both are empty, prevent form submission
                //     alert('Please provide a message or upload a file.');
                //     event.preventDefault();
                // }
                $('#post_form').submit()
            }

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
                    // Change the SVG icon to the upward arrow
                    icon.innerHTML = `
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7"/>
                </svg>
            `;
                } else {
                    // Change the SVG icon to the downward arrow
                    icon.innerHTML = `
                <svg class="h-3 w-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
            `;
                }
            }

            // $(document).ready(function() {
            //     $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
            //     // Turn input element into a pond
            //     $('.assignment_files').filepond();


            //     // Turn input element into a pond with configuration options
            //     $('.assignment_files').filepond({
            //         allowMultiple: true,
            //         allowReorder: true,
            //         allowImagePreview: true,
            //     });

            //     FilePond.setOptions({
            //         server: {
            //             process: './{{ $batch->id }}/temp_upload_assignment',
            //             // revert: './revert',
            //             headers: {
            //                 'X-CSRF_TOKEN': '{{ csrf_token() }}'
            //             }
            //         },
            //     });

            //     // Listen for addfile event
            //     $('.assignment_files').on('FilePond:addfile', function(e) {
            //         console.log('file added event', e);
            //     });

            // });

            FilePond.registerPlugin(
                FilePondPluginImagePreview
            );

            const inputElement = document.querySelector('.assignment_files');
            const pond = FilePond.create(inputElement)
            FilePond.setOptions({
                allowMultiple: true,
                allowReorder: true,
                allowImagePreview: true,
                server: {
                    process: './{{ $batch->id }}/temp_upload_assignment',
                    // load: '/files/',
                    // revert: '/upload',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
            });


            // function due_date_toggle() {
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

            // Post assignment
            $(document).ready(function() {
                $('#post_assignment').submit(function(event) {
                    if ($('#due_date_toggle').is(':checked') && $('#due_date').val() === '') {
                        alert('Set due date');
                    }

                    event.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: formData,
                        success: function(response) {
                            console.log(formData);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            })
        </script>
    @endsection
</x-app-layout>
