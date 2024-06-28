<x-app-layout>
    @section('style')
        .image-item {
        width: 10rem; /* Adjust as needed */
        aspect-ratio: 3 / 2.5;
        overflow: hidden;
        margin-bottom: 10px;
        background: #eee;
        position: relative;
        }

        .image-item img {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: auto;
        transform: translate(-50%, -50%);
        }

        .image-item img.landscape {
        height: 100%;
        width: auto;
        overflow: hidden;
        }

        {{-- Quill JS --}}
        @font-face {
        font-family: 'Figtree';
        src: url(@vite('resources/font/Figtree-VariableFont_wght.ttf')) format('truetype');
        font-weight: normal;
        font-style: normal;
        }

        .ql-editor {
        font-family: 'Figtree', Arial, sans-serif;
        font-size: 16px;
        color: #000; /* Text color */
        background-color: #fff; /* Editor background color */
        border: 0px !important;
        }

        .ql-snow a {
        color: #000 !important; /* Link color */
        }

        .ql-snow .ql-stroke{
        stroke: #082f49 !important;
        }

        .ql-snow button:hover{
        stroke: #fff !important;
        }

        .ql-snow .ql-picker{
        color: #082f49 !important;
        }

        .ql-snow .ql-picker-options{
        background-color: #0284c7 !important;
        }

        .ql-snow.ql-toolbar button:hover, .ql-snow .ql-toolbar button:hover, .ql-snow.ql-toolbar button:focus, .ql-snow
        .ql-toolbar button:focus, .ql-snow.ql-toolbar button.ql-active, .ql-snow .ql-toolbar button.ql-active,
        .ql-snow.ql-toolbar .ql-picker-label:hover, .ql-snow .ql-toolbar .ql-picker-label:hover, .ql-snow.ql-toolbar
        .ql-picker-label.ql-active, .ql-snow .ql-toolbar .ql-picker-label.ql-active, .ql-snow.ql-toolbar
        .ql-picker-item:hover, .ql-snow .ql-toolbar .ql-picker-item:hover, .ql-snow.ql-toolbar .ql-picker-item.ql-selected,
        .ql-snow .ql-toolbar .ql-picker-item.ql-selected{
        color:#fff !important;
        }

        .ql-toolbar.ql-snow {
        background-color: #0284c7; /* Toolbar background color */
        border: 0px !important; /* Toolbar border */
        }

        {{-- Displaying --}}
        ol {
        list-style-type: disc; /* Or circle, square, etc. for different bullet styles */
        padding-left: 20px; /* Adjust the indentation as needed */
        }
    @endsection
    @section('style-links')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $batch->course->name }}</span>
            </div>
            <div class="flex items-center">
                <div class="mr-4">Batch: {{ $batch->name }}</div>

            </div>
        </div>
        <x-course-nav :selected="'stream'" :batch="$batch->id"></x-course-nav>

    </x-slot>
    <div x-data="stream" id="course_list" class="mx-8 pt-44 text-white">
        {{-- <button 
            class="flex items-center justify-center rounded-md bg-sky-700 p-2 px-3" type="button">
        </button> --}}

        <div class="flex pt-2">
            <a id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                class="block cursor-pointer rounded-md bg-sky-700 px-4 py-2 text-sm hover:bg-sky-800 hover:text-white">Create
                New</a>
        </div>

        <!-- Dropdown menu -->
        <div id="dropdown"
            class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a @click="edit = false; createPost()" data-modal-target="create-post-modal"
                        data-modal-toggle="create-post-modal"
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

        <div class="flex flex-col-reverse">
            <template x-if="posts.length > 0">
                <template x-for="post in posts" :key="post.id">
                    <div class="my-1.5 shadow-md rounded-md bg-gray-800 p-3">
                        <div class="mb-1.5 flex items-center justify-between px-2 text-xs">
                            <div>
                                <div>
                                    <div
                                        class="relative inline-flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-sky-800 p-1">
                                        <svg class="w-5 self-center text-white" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M9 22C8.4 22 8 21.6 8 21V18H4C2.9 18 2 17.1 2 16V4C2 2.9 2.9 2 4 2H20C21.1 2 22 2.9 22 4V16C22 17.1 21.1 18 20 18H13.9L10.2 21.7C10 21.9 9.8 22 9.5 22H9M10 16V19.1L13.1 16H20V4H4V16H10M18 14V6H13V14L15.5 12.5L18 14Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div class="flex items-center me-2">
                                    <svg class="mr-1 h-3 w-3 self-center text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <div x-text="post.formattedDate"></div>
                                </div>
                                <div class=" cursor-pointer">
                                    <x-dropdown width="40" align="right">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center rounded-md border border-transparent bg-white text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                                <svg class="h-7 w-7 text-white hover:text-sky-500"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="m-1.5">
                                                <a @click="editPost(post.id)" data-modal-target="create-post-modal"
                                                    data-modal-toggle="create-post-modal"
                                                    class=" w-full hover:bg-gray-800 py-2 text-start text-sm leading-5 text-gray-300 focus:outline-none focus:bg-gray-800 transition duration-150 ease-in-out flex px-4 items-center space-x-1.5 rounded-md">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                    </svg>
                                                    <div>Edit</div>
                                                </a>


                                                <!-- Authentication -->
                                                <form method="POST" action="{{ route('delete_post') }}">
                                                    @csrf
                                                    <input type="hidden" name="post_id" :value="post.id">

                                                    <x-dropdown-link hover_bg="hover:bg-red-900"
                                                        class="flex px-1.5  items-center space-x-1.5 rounded-md"
                                                        :href="route('delete_post')" @click.prevent="deletePostConfirmation">
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                        </svg>
                                                        <div>
                                                            Delete
                                                        </div>
                                                    </x-dropdown-link>
                                                </form>
                                            </div>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </div>
                        <div class="p-2">
                            <div x-show="post.description" class="post mb-2">
                                <p x-html="sanitize(post.description)" class="description font-sans">
                                </p>
                            </div>
                            <div>
                                <template x-if="post.files.length > 0">
                                    <div>
                                        <template x-for="file in post.files" :key="file.id">
                                            <template x-if="!imageExtensions.some(ext => file.filename.endsWith(ext))">
                                                <div class="mb-2" x-data="{ path: `{{ asset('storage/uploads/') }}/${batch.id}/${post.id}/${file.filename}` }">
                                                    <x-file-type-checker-alpine></x-file-type-checker-alpine>
                                                </div>
                                            </template>
                                        </template>
                                        <template
                                            x-if="post.files.some(file => imageExtensions.some(ext => file.filename.endsWith(ext)))">
                                            <div class="image block" :id="`post_${post.id}`">
                                                <template x-for="file in post.files" :key="file.id">
                                                    <template
                                                        x-if="imageExtensions.some(ext => file.filename.endsWith(ext))">
                                                        <div class="image-item rounded-md border border-transparent hover:border-2 hover:border-solid hover:border-sky-700"
                                                            x-data="{ path: `{{ asset('storage/uploads/') }}/${batch.id}/${post.id}/${file.filename}`, imageShow: true }">
                                                            <x-file-type-checker-alpine></x-file-type-checker-alpine>
                                                        </div>
                                                    </template>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
            <template x-if="posts.length == 0">
                <div class="mt-4 rounded-md bg-gray-700 p-2.5 text-center text-sm text-gray-300">No Post
                </div>
            </template>
            <template x-if="batch.length == 0">
                <div class="mt-4 rounded-md bg-gray-700 p-2.5 text-center text-sm text-gray-300">We will
                    contact you as
                    soon as
                    possible, feel free
                    to contact us here for inquiries</div>
            </template>
        </div>

        {{-- Create Post Modal --}}
        <div id="create-post-modal" tabindex="-1" aria-hidden="true"
            class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
            <div class="relative max-h-full w-full max-w-xl p-4">
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
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
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
                        <input type="hidden" name="message" id="message">
                        <template x-if="edit">
                            <input type="hidden" name="post_id" :value="selectedPost[0].id">
                        </template>
                        <div class="mb-4">
                            <label
                                class="mb-1.5 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <div id="editor">
                            </div>
                        </div>
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            {{-- <div class="col-span-2">
                                <label for="message"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="message" name="message" rows="2"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Write post description here"></textarea>
                            </div> --}}
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
                                <input id="file"
                                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                    type="file" name="file[]" accept=".jpg, .png, .xlsx, .docx, .txt" multiple>
                            </div>

                        </div>
                        <button type="button" {{-- onclick="formCheck()" --}} @click="formCheck()"
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
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
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
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
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
                                                        class="h-7 w-7 rounded-md p-1 hover:bg-gray-600"
                                                        method="post">
                                                        @method('DELETE')
                                                        <button onclick="confirmDelete({{ $lesson->id }})"
                                                            class="h-full w-full" type="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
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
    </div>


    @section('script')
        <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
        <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        {{-- File Pond --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.1.5/purify.min.js"
            integrity="sha512-JatFEe90fJU2nrgf27fUz2hWRvdYrSlTEV8esFuqCtfiqWN8phkS1fUl/xCfYyrLDQcNf3YyS0V9hG7U4RHNmQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script type="text/javascript">
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



            function stream() {
                return {
                    posts: @if ($posts)
                        @json($posts)
                    @endif ,
                    batch: @if ($batch)
                        @json($batch)
                    @endif ,
                    tempFiles: @json($temp_files ?? $temp_files),
                    edit: false,
                    selectedFiles: null,
                    selectedPost: null,
                    imageExtensions: ['jpeg', 'jpg', 'png', 'jfif'],
                    quill: null,
                    filepondInstance: null,
                    init() {
                        this.posts.forEach(post => {
                            post.formattedDate = this.formatDate(post.formatted_created_at);

                            //Sort files by type
                            post.files.sort((a, b) => {
                                const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp',
                                    'jfif'
                                ];
                                const extA = a.filename.split('.').pop().toLowerCase();
                                const extB = b.filename.split('.').pop().toLowerCase();

                                const isImageA = imageExtensions.includes(extA);
                                const isImageB = imageExtensions.includes(extB);

                                if (isImageA && !isImageB) {
                                    return 1;
                                } else if (!isImageA && isImageB) {
                                    return -1;
                                } else {
                                    return extA.localeCompare(extB);
                                }
                            });
                        });

                        this.tempFiles = this.tempFiles.map(file => {
                            return {
                                source: file.id,
                                options: {
                                    type: 'local',
                                },
                            }
                        })
                        this.selectedFiles = this.tempFiles;

                        this.imageLayout();
                        this.quillInit();
                        this.filePond_config();

                        @if (session('status'))
                            this.notification("{{ session('status') }}", "{{ session('message') }}",
                                "{{ session('title') ?? session('title') }}");
                        @endif

                        this.$nextTick(() => {
                            this.formatLinks();
                        })

                    },
                    formatDate(createdAtText) {
                        var createdAtMoment = moment(createdAtText, 'YYYY-MM-DD HH:mm');
                        var diffInMonths = moment().diff(createdAtMoment, 'weeks');
                        var formattedDate;
                        if (diffInMonths <= 1) {
                            formattedDate = createdAtMoment.calendar();
                        } else {
                            formattedDate = createdAtMoment.format('MM/DD/YYYY hh:mm A');
                        }
                        return formattedDate;
                    },
                    imageLayout() {
                        this.$nextTick(() => {
                            this.posts.forEach(post => {
                                var elem = document.querySelector('#post_' + post.id);
                                // console.log(elem);

                                if (elem) {
                                    try {
                                        var msnry = new Masonry(elem, {
                                            itemSelector: '.image-item',
                                            columnWidth: '.image-item',
                                            percentPosition: true,
                                            gutter: 5,

                                        });
                                        // console.log(msnry.items.length + ' filtered items');

                                        imagesLoaded(elem).on('progress', function() {
                                            msnry.layout();
                                        });
                                    } catch (error) {
                                        console.log(error);
                                    }
                                    // console.log(post.id);
                                } else {
                                    // console.warn('Element not found for post id:', post.id);
                                }
                            });
                        });
                    },
                    quillInit() {
                        const toolbarOptions = [
                            [{
                                'header': [1, 2, false]
                            }, 'bold', 'italic', 'link'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],

                        ];
                        this.quill = new Quill('#editor', {
                            theme: 'snow',
                            modules: {
                                toolbar: toolbarOptions
                            }
                        });
                    },
                    formCheck() {
                        $('#message').val(this.quill.root.innerHTML)
                        var rawMessage = this.quill.root.innerHTML

                        var messageValue = rawMessage.replace(/(<([^>]+)>)/gi, "").trim();
                        var fileValue = $('input[name="file[]"]').val();

                        if (messageValue.length === 0 && fileValue === '') {
                            alert('Please provide a message or upload a file.');
                            return
                        }
                        $('#post_form').submit()
                    },
                    sanitize(content) {
                        return DOMPurify.sanitize(content);
                    },
                    filePond_config() {
                        var stream = this
                        FilePond.registerPlugin(FilePondPluginImagePreview);
                        const input_element = document.querySelector('#file');
                        this.filepondInstance = FilePond.create(input_element);
                    },
                    editPost(postId) {
                        this.edit = true;

                        this.selectedPost = this.posts.filter(post => post.id === postId);
                        this.selectedFiles = this.selectedPost[0].files.map(file => {
                            return {
                                source: file.id,
                                options: {
                                    type: 'local',
                                },
                            }
                        })
                        this.filepondInstance.setOptions({
                            labelIdle: `Drag & Drop files or <span class="filepond--label-action">Browse</span>`,
                            allowReorder: true,
                            allowImagePreview: true,
                            allowMultiple: true,
                            files: this.selectedFiles,

                            server: {
                                process: {
                                    url: '{{ route('upload_temp_post_files') }}',
                                    ondata: (formData) => {
                                        formData.append('batch_id', '{{ $batch->id }}');
                                        return formData;
                                    },
                                },
                                revert: {
                                    url: '{{ route('revert_post_files') }}',
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                },
                                load: `/load_post_files/edit/{{ encrypt($batch->id) }}/`,
                                remove: (source, load, error) => {
                                    fetch(`/delete_post_files/{{ encrypt($batch->id) }}/${source}`, {
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
                            }
                        });

                        this.$nextTick(() => {
                            try {
                                this.quill.root.innerHTML = this.selectedPost[0].description;
                                // this.quill.clipboard.dangerouslyPasteHTML(0, this.selectedPost[0].description);
                                // this.quill.setSelection(0, 5);
                            } catch (error) {
                                console.error(error);
                            }
                        })

                        // this.quill.clipboard.dangerouslyPasteHTML(this.selectedPost[0].description);

                        console.log(this.quill);
                    },
                    createPost() {
                        this.edit = false;
                        this.quill.root.innerHTML = '';
                        this.filepondInstance.setOptions({
                            labelIdle: `Drag & Drop files or <span class="filepond--label-action">Browse</span>`,
                            allowReorder: true,
                            allowImagePreview: true,
                            allowMultiple: true,
                            files: this.tempFiles,

                            server: {
                                process: {
                                    url: '{{ route('upload_temp_post_files') }}',
                                    ondata: (formData) => {
                                        formData.append('batch_id', '{{ $batch->id }}');
                                        return formData;
                                    },
                                },
                                revert: {
                                    url: '{{ route('revert_post_files') }}',
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                },
                                load: `/load_post_files/create/{{ encrypt($batch->id) }}/`,
                                remove: (source, load, error) => {
                                    fetch(`/delete_post_files/{{ encrypt($batch->id) }}/${source}`, {
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
                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message,
                            title ?? title);
                        toastr.options.closeButton = true;
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "showDuration": "300",
                            "hideDuration": "800",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    },
                    deletePostConfirmation() {
                        var form = event.target.closest('form');

                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
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
                    formatLinks() {
                        $('.description a').addClass('bg-gray-700 hover:bg-gray-700/75 text-white py-1.5 px-3 rounded-sm')
                        $('.description p').addClass('my-1')

                        // $('.description p').each(function() {
                        //     var text = $(this).text();
                        //     var urlRegex = /(https?:\/\/[^\s]+)/g;
                        //     var formattedText = text.replace(urlRegex, function(url) {
                        //         return '<a href="' + url +
                        //             '" target="_blank" rel="noopener noreferrer" class="bg-gray-700 hover:bg-gray-700/75 text-white py-1.5 px-3 rounded-sm">' +
                        //             url + '</a>';
                        //     });
                        //     $(this).html(formattedText);
                        // });
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
