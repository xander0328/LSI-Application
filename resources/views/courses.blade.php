<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Offered Courses') }}
            </div>
            <div>
                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                    class="block flex items-center rounded-lg bg-sky-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300"
                    type="button">
                    <svg class="h-4 w-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg> Add Course
                </button>
            </div>
        </div>

    </x-slot>
    <div id="course_list" class="mx-8 my-4">
        <ul class="space-y-2 font-semibold text-white">
            @if ($courses->count() == 0)
                <div>
                    <div class="rounded-lg bg-sky-950 p-4 text-center text-slate-400">No course added
                    </div>
                </div>
            @else
                @foreach ($courses as $course)
                    <li id="course-item" class="rounded-md bg-gray-700 p-2">
                        <div>
                            <div class="mb-px flex justify-between align-middle">
                                <div class="my-1 py-1">{{ $course->name }}</div>
                                <div class="flex">

                                    <div>
                                        <button id="dropdownMenuIconHorizontalButton_{{ $course->id }}"
                                            data-dropdown-toggle="dropdownDotsHorizontal_{{ $course->id }}"
                                            class="inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                            type="button">
                                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 16 3">
                                                <path
                                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div id="dropdownDotsHorizontal_{{ $course->id }}"
                                            class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
                                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                                <li>
                                                    <a href="javascript:void(0)" id="edit_course"
                                                        data-id="{{ route('edit_course', $course->id) }}"
                                                        data-modal-target="edit-modal" data-modal-toggle="edit-modal"
                                                        class="m-1 flex items-center rounded-lg p-2 py-1 align-middle hover:bg-gray-800"><svg
                                                            class="h-5 w-6 text-gray-800 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m10.8 17.8-6.4 2.1 2.1-6.4m4.3 4.3L19 9a3 3 0 0 0-4-4l-8.4 8.6m4.3 4.3-4.3-4.3m2.1 2.1L15 9.1m-2.1-2 4.2 4.2" />
                                                        </svg>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)"
                                                        class="m-1 flex items-center rounded-lg p-2 py-1 align-middle hover:bg-gray-800">
                                                        <svg class="h-5 w-6 text-gray-800 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Disable</a>
                                                </li>
                                                <li>
                                                    <form id="delete-course" class="px-1"
                                                        action="{{ route('delete_course', $course->id) }}"
                                                        method="post">
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="flex w-full items-center rounded-lg p-1 px-2 align-text-bottom hover:bg-gray-800">
                                                            <svg class="h-5 w-6 text-gray-800 dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M8.6 2.6A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4c0-.5.2-1 .6-1.4ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            Delete</button>
                                                    </form>

                                                </li>
                                            </ul>
                                            <div class="py-2">
                                                <a href="#"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white">Separated
                                                    link</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr class="border border-gray-500">
                            <div class="mt-2 text-sm font-thin">
                                <span class="font-semibold text-sky-400">Description:</span> {{ $course->description }}
                            </div>
                            <div class="text-sm font-thin">
                                <span class="font-semibold text-sky-400">Hours:</span> {{ $course->training_hours }}
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>

    {{-- Add Course Modal --}}

    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Course
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="add_course" class="p-4 md:p-5" method="POST" action="{{ route('add_course') }}">
                    @csrf
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="name"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="name"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Type course name" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Training
                                Hours</label>
                            <input type="number" name="training_hours" id="training_hours"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Hours" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select name="category" id="category"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <option selected="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Course
                                Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Type course description"></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="-ms-1 me-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Add new course
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Course Modal End --}}

    {{-- Edit Course Modal --}}

    <!-- Main modal -->
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="edit-modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="POST" action="{{ route('add_course') }}">
                    @csrf
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="hidden"><input type="number" name="course_id" id="course_id"></div>
                        <div class="col-span-2">
                            <label for="name"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="edit_name"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Type course name" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Training
                                Hours</label>
                            <input type="number" name="training_hours" id="edit_training_hours"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Hours" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select name="category" id="edit_category"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <option selected="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Course
                                Description</label>
                            <textarea name="description" id="edit_description" rows="4"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Type course description"></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="mr-2 h-5 w-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m5 12 4.7 4.5 9.3-9" />
                        </svg>
                        <span class="mr-2">Save</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Course Modal End --}}

    @section('script')
        <script type="text/javascript">
            $(document).ready(function() {
                $('body').on('click', '#edit_course', function() {
                    var course = $(this).data('id')
                    $('#edit_name').val('');
                    $('#edit_training_hours').val('');
                    $('#edit_category').val('');
                    $('#edit_description').val('');

                    $.get(course, function(data) {
                        $('#edit-modal').show();
                        $('#course_id').val(data.id);
                        $('#edit_name').val(data.name);
                        $('#edit_training_hours').val(data.training_hours);
                        $('#edit_category').val(data.category);
                        $('#edit_description').val(data.description);
                    })

                })

                $('form#delete-course').submit(function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    var form = $(this);
                    var url = form.attr('action');

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Handle successful deletion
                            console.log(response.message);
                            // Example: Remove the deleted record from the DOM
                            form.closest('#course-item').remove();
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error(xhr.responseText);
                        }
                    });
                });
            })
        </script>
    @endsection
</x-app-layout>
