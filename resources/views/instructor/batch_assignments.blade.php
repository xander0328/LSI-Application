<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $batch->course->name }}</span>
            </div>
            <div>Batch: {{ $batch->name }}</div>
        </div>
        <x-course-nav :selected="'assignment'" :batch="$batch->id"></x-course-nav>

    </x-slot>
    <div id="course_list" class="mx-8 mt-2 pb-4 pt-44 text-white">
        <div class="mb-2 flex">
            <a data-modal-target="create-assignment-modal" data-modal-toggle="create-assignment-modal"
                class="block cursor-pointer rounded-md bg-sky-700 px-4 py-2 text-sm hover:bg-sky-800 hover:text-white">Create
                New</a>
        </div>
        @foreach ($assignments as $assignment)
            <div class="mb-2 rounded-md bg-gray-800 p-px">

                <div class="my-2 w-full rounded-md bg-gray-800 px-3 py-px">
                    <a href="{{ route('list_turn_ins', $assignment->id) }}" class="flex items-center justify-between">
                        <div class="flex items-center justify-start gap-4">
                            <div>
                                <div
                                    class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-sky-700 p-2">

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <title>book-clock-outline</title>
                                        <path fill="white"
                                            d="M20 11.26V4C20 2.9 19.11 2 18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H11.11C12.37 23.24 14.09 24 16 24C19.87 24 23 20.87 23 17C23 14.62 21.81 12.53 20 11.26M18 4V10.29C17.37 10.11 16.7 10 16 10C14.93 10 13.91 10.25 13 10.68V4H18M6 4H8V12L10.5 9.75L12.1 11.19C10.23 12.45 9 14.58 9 17C9 18.08 9.25 19.09 9.68 20H6V4M16 22C13.24 22 11 19.76 11 17S13.24 12 16 12 21 14.24 21 17 18.76 22 16 22M16.5 17.25L19.36 18.94L18.61 20.16L15 18V13H16.5V17.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-full font-medium dark:text-white">
                                <div>{{ $assignment->title }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ mb_strimwidth($assignment->description, 0, 70, '...') }}
                                </div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            @if ($assignment->due_date != null)
                                Due {{ $assignment->due_date }}
                            @else
                                No due
                            @endif
                        </div>
                    </a>

                </div>

            </div>
        @endforeach

    </div>
    {{-- Create Assignment Modal --}}
    <div id="create-assignment-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl p-4">
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
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                            <label for="time" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
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
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
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
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
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

                            <select id="lesson" name="lesson" required
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                <option selected>Select</option>
                                @foreach ($lessons as $lesson)
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
                            <input type="number" name="max_point" required
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const posts = document.querySelectorAll('.post');

                posts.forEach(function(post) {
                    const description = post.querySelector('.description');
                    const content = description.innerHTML;

                    // Regular expression to find URLs
                    const urlRegex = /(https?:\/\/\S+)/g;

                    // Replace URLs with anchor tags
                    const replacedContent = content.replace(urlRegex,
                        '<a class="hover:text-underlined text-sky-500" href="$1" target="_blank">$1</a>');

                    // Update the description content
                    description.innerHTML = replacedContent;
                });
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

            document.addEventListener('DOMContentLoaded', function() {
                const inputElement = document.querySelector('.assignment_files');
                const pond = FilePond.create(inputElement)
                FilePond.setOptions({
                    allowMultiple: true,
                    allowReorder: true,
                    allowImagePreview: true,
                    server: {
                        process: {
                            url: '{{ route('temp_upload_assignment') }}',
                            ondata: (formData) => {
                                formData.append('batch_id', '{{ $batch->id }}');
                                return formData;
                            },
                        },
                        load: '/load_files/{{ $batch->id }}',
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
                            fetch(`/delete_assignment_file/{{ $batch->id }}/${source}`, {
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

                fetch(`/get_assignment_files/{{ $batch->id }}`)
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

                        if (fileItems.length > 0)
                            toggleShowAddFile('assigment')
                    })
                    .catch(error => console.error('Error loading files:', error));

            })


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
                    if ($('#lesson').val() == 'Select') {
                        alert('Select lesson');
                        event.preventDefault();
                    } else {
                        $('#post_assignment').submit();
                    }
                    // console.log($('#lesson').val());
                    // if ($('#due_date_toggle').is(':checked') && $('#due_date').val() === '') {
                    //     alert('Set due date');
                    //     return ''
                    // }

                });

                $('#due_date_toggle').on('change', function() {
                    $('#due_date').val('')
                })

                function isDateBeforeToday(date) {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    return new Date(date) < today;
                }

                $('#due_date').on('change', function() {
                    var selectedDate = $(this).val();
                    if (isDateBeforeToday(selectedDate)) {
                        alert('The selected date cannot be less than today.');
                        $(this).val('');
                    }
                });

                $('#add_lesson_button').on('click', function() {
                    $('#create-assignment-modal').addClass('hidden')
                    console.log($('#create-assignment-modal'));
                })

            })

            $('#due_date').on('keypress', function(e) {
                e.preventDefault();
            });
        </script>
    @endsection
</x-app-layout>
