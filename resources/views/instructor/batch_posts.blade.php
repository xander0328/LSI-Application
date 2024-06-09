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
                        <li>
                            <a data-modal-target="add_lesson_modal" data-modal-toggle="add_lesson_modal"
                                class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lesson</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <x-course-nav :selected="'stream'" :batch="$batch->id"></x-course-nav>

    </x-slot>

    <div id="course_list" class="flex flex-col-reverse px-8 pb-4 pt-44 text-white">
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
                                <div class="mb-2 mr-2">
                                    <a href="{{ asset('storage/' . $files->path) }}" target="_blank" download><img
                                            class="h-48 w-auto flex-1" src="{{ asset('storage/' . $files->path) }}"
                                            alt="{{ str_replace('uploads/', '', $files->path) }}">
                                    </a>
                                </div>
                            @elseif ($files->file_type == 'application/pdf')
                                <div class="mb-2 mr-2">
                                    <a target="_blank"
                                        class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(185 28 28)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-pdf-box</title>
                                            <path
                                                d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
                                        </svg>
                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @elseif (Str::endsWith($files->path, '.docx') || Str::endsWith($files->path, '.doc'))
                                <div class="mb-2 mr-2">
                                    <a target="_blank" download
                                        class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(2 132 199)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-word-box</title>
                                            <path
                                                d="M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>

                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @elseif (Str::endsWith($files->path, '.xlsx') || Str::endsWith($files->path, '.xls') || Str::endsWith($files->path, '.csv'))
                                <div class="mb-2 mr-2">
                                    <a target="_blank" download
                                        class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(22 163 74)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-excel-box</title>
                                            <path
                                                d="M16.2,17H14.2L12,13.2L9.8,17H7.8L11,12L7.8,7H9.8L12,10.8L14.2,7H16.2L13,12M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>
                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @elseif (Str::endsWith($files->path, '.txt'))
                                <div class="mb-2 mr-2">
                                    <a target="_blank" download
                                        class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>text-box</title>
                                            <path
                                                d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>
                                        {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @else
                                <div class="mb-2 mr-2">
                                    <a target="_blank" download
                                        class="flex items-center rounded-md bg-gray-900 p-2 text-sm hover:bg-gray-800"
                                        href="{{ asset('storage/' . $files->path) }}">
                                        <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>file-document</title>
                                            <path
                                                d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M15,18V16H6V18H15M18,14V12H6V14H18Z" />
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

    {{-- Add Lesson Modal --}}
    <div id="add_lesson_modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-lg p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add New Lesson
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="add_lesson_modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <form id="add_lesson_form" method="post">
                                <label for="lesson" class="mb-2 block text-sm font-medium text-white">New
                                    Lesson</label>
                                <div class="grid grid-cols-9">
                                    <div class="col-span-8">
                                        <input type="text" id="lesson_input" name="lesson"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Lesson" required />
                                    </div>
                                    <button type="submit"
                                        class="ms-2 flex w-full items-center justify-center rounded-md bg-sky-700 p-2 px-3"><svg
                                            class="h-4 w-4 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-white">
                                <div class="mb-2 text-sm font-medium">
                                    List
                                </div>
                                <div id="list_lessons">
                                    @foreach ($lessons as $lesson)
                                        <div
                                            class="flex items-center justify-between bg-gray-600 p-2 text-sm hover:bg-sky-800">
                                            <span>{{ $lesson->title }}</span>
                                            <div class="flex">
                                                <button
                                                    onclick="edit_lesson('{{ $lesson->title }}',{{ $lesson->id }})"
                                                    class="me-1 h-7 w-7 rounded-md p-1 hover:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>Edit</title>
                                                        <path fill="white"
                                                            d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                    </svg>
                                                </button>
                                                <form id="delete_lesson_form_{{ $lesson->id }}"
                                                    action="{{ route('delete_lesson', $lesson->id) }}"
                                                    class="h-7 w-7 rounded-md p-1 hover:bg-gray-600" method="post">
                                                    @method('DELETE')
                                                    <button onclick="confirmDelete({{ $lesson->id }})"
                                                        class="h-full w-full" type="button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>Delete</title>
                                                            <path fill="white"
                                                                d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                        </svg></button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

                    const replacedContent = content.replace(urlRegex,
                        '<a class="text-sky-500 hover:text-underlined" href="$1" target="_blank">$1</a>');

                    description.innerHTML = replacedContent;
                });

                $('.created_at').each(function() {
                    var createdAtText = $(this).text().trim();

                    var createdAtMoment = moment(createdAtText, 'YYYY-MM-DD HH:mm');

                    var diffInMonths = moment().diff(createdAtMoment, 'weeks');

                    var formattedDate;
                    if (diffInMonths <= 1) {
                        formattedDate = createdAtMoment.calendar();
                    } else {
                        formattedDate = createdAtMoment.format('MM/DD/YYYY hh:mm A');
                    }
                    $(this).text(formattedDate);
                });
            })

            function formCheck() {
                var messageValue = $('#message').val();
                var fileValue = $('input[name="file[]"]').val();

                if (messageValue.trim() === '' && fileValue === '') {
                    alert('Please provide a message or upload a file.');
                    return

                }
                $('#post_form').submit()
            }

            var initial_lesson_count = @json($lessons);

            function get_lessons() {
                $.ajax({
                    url: `/get_lessons`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        batch_id: {{ $batch->id }},
                    },
                    success: function(data) {
                        // console.log(data);
                        var lesson = $('#lesson')
                        var current_lesson_count = data.lessons
                        if (JSON.stringify(current_lesson_count) != JSON.stringify(initial_lesson_count)) {
                            initial_lesson_count = current_lesson_count
                            lesson.empty();

                            lesson.append($('<option>', {
                                value: '',
                                text: 'Select'
                            }));

                            let list_lessons = ''
                            $.each(data.lessons, function(index, data) {
                                lesson.append($('<option>', {
                                    value: data.id,
                                    text: data.title
                                }));

                                list_lessons += `<div
                                            class="flex items-center justify-between bg-gray-600 p-2 text-sm hover:bg-sky-800">
                                            <span>${data.title}</span>
                                            <div class="flex">
                                                <button onclick="edit_lesson('${data.title}', ${data.id})"
                                                    class="me-1 h-7 w-7 rounded-md p-1 hover:bg-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>Edit</title>
                                                        <path fill="white"
                                                            d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                    </svg>
                                                </button>
                                                <form id="delete_lesson_form_${data.id}"
                                                    action="/delete_lesson/${data.id}"
                                                    class="h-7 w-7 rounded-md p-1 hover:bg-gray-600" method="post">
                                                    @method('DELETE')
                                                    <button onclick="confirmDelete(${data.id})"
                                                        class="h-full w-full" type="button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>Delete</title>
                                                            <path fill="white"
                                                                d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                        </svg></button>
                                                </form>
                                            </div>
                                        </div>`
                            });

                            $('#list_lessons').html(list_lessons)
                        }

                    },
                })
            }

            setInterval(() => {
                get_lessons()
            }, 2000);

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
                </svg>
            `;
                } else {
                    icon.innerHTML = `
                <svg class="h-3 w-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
            `;
                }
            }


            $('#add_lesson_form').submit(function(event) {
                event.preventDefault()
                var lesson_input = $('#lesson_input')
                $.ajax({
                    url: `{{ route('add_lesson') }}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        batch_id: {{ $batch->id }},
                        lesson: lesson_input.val()
                    },
                    success: function(data) {
                        lesson_input.val('')
                    },
                })
            })

            function edit_lesson(title, id) {
                var current_title = title;
                console.log(current_title);
                var new_title = prompt("Edit the lesson title:", current_title);

                if (new_title !== null && new_title !== current_title) {
                    $.ajax({
                        url: '{{ route('edit_lesson') }}',
                        type: 'POST',
                        data: {
                            id: id,
                            title: new_title,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert('Title updated successfully');
                        },
                        error: function(xhr) {
                            alert('Error updating title');
                        }
                    });
                }
            }

            function confirmDelete(lesson_id) {
                var confirmation = 'DELETE'
                var user_input = prompt(
                    "Deleting this lesson will also delete all related data. To confirm deletion, type the word '" +
                    confirmation + "'."
                )
                if (user_input === confirmation) {
                    // event.preventDefault();
                    var form = $('#delete_lesson_form_' + lesson_id);

                    $.ajax({
                        url: form.attr('action'),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    alert('Deletion cancelled.')
                }

            }

            // $('#delete_lesson_form').submit(function(event) {
            //     event.preventDefault();
            //     var form = $('#delete_lesson_form');
            //     var url = form.attr('action');
            //     console.log(url);

            //     $.ajax({
            //         url: url,
            //         type: 'DELETE',
            //         headers: {
            //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //         },
            //         success: function(response) {
            //             console.log(response);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(xhr.responseText);
            //         }
            //     });
            // });
        </script>
    @endsection
</x-app-layout>
