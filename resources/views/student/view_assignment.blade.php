<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Enrolled Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $enrollee->course->name }}</span>
            </div>
            <div>Batch: {{ $enrollee->batch->name }}</div>
        </div>
        <div class="mt-2 flex items-center justify-start text-white">
            <a href="{{ route('enrolled_course') }}">
                <button class="flex items-center justify-center rounded-sm px-2 py-px text-white hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">
                        <title>post-outline</title>
                        <path fill="white"
                            d="M19 5V19H5V5H19M21 3H3V21H21V3M17 17H7V16H17V17M17 15H7V14H17V15M17 12H7V7H17V12Z" />
                    </svg>
                    Stream
                </button>
            </a>

            <a href="{{ route('enrolled_course_assignment') }}">
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
    <div id="course_list" class="mx-8 pb-4 pt-44 text-white">
        {{-- <div>
            <a href="{{ route('enrolled_course_assignment') }}">
                <button class="flex items-center justify-center rounded-full p-2 text-white hover:bg-gray-700">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">
                        <title>arrow-left</title>
                        <path fill="white"
                            d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" />
                    </svg>
                </button></a>
        </div> --}}

        <div class="my-4">
            <div id="status" class="flex items-center justify-between rounded-sm p-2 text-white">
                <div id="turn_in_status" class="text-md flex items-center">

                </div>
                <div>
                    <button onclick="assignment_action()" id="turn_in_button" class="p-2 px-4 text-sm hover:bg-gray-700"
                        disabled>Turn in</button>
                </div>
            </div>
            <div class="flex justify-end italic" id="assignment_info">

            </div>
            <div>
                <div class="text-2xl font-semibold text-white"> {{ $assignment->title }}
                </div>
            </div>

            <div class="mb-1.5 flex items-center p-px text-sm">
                <span
                    class="relative mr-px inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>star</title>
                        <path fill="white"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" />
                    </svg>
                </span>
                {{ $assignment->points }} points |
                <span
                    class="relative mx-px ml-2 inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>calendar-month</title>
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
            @if ($student_grade)
                <span class="rounded-md bg-sky-800 p-2 text-sm">
                    Your grade: {{ $student_grade->grade }}
                </span>
            @else
                <div class="p-px text-xs">
                    Not graded yet
                </div>
            @endif
            <div class="p-px text-xs">
                @if (!$assignment->closed)
                    @if ($assignment->closing)
                        Submission will be closed after due
                    @endif
                @endif
            </div>

        </div>
        <div>
            <div class="text-sm">Instructions</div>
            @if ($assignment->description == null)
                <div class="mb-4 p-px text-sm text-gray-700">None</div>
            @else
                <pre class="mb-4 p-px text-sm">{{ $assignment->description }}</pre>
            @endif
            <div class="mb-6">
                @foreach ($assignment->assignment_files as $files)
                    <x-file-type-checker :files="$files" :path="asset(
                        'storage/' .
                            'assignments/' .
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
        <div>
            <div>Your work</div>
            <div id="works_container">

            </div>

            <div>
                <button type="button" id="attach_button" data-modal-target="temp-upload-modal"
                    data-modal-toggle="temp-upload-modal"
                    class="inline-flex items-center rounded-lg p-2 text-center text-xs font-medium text-white hover:bg-blue-700 hover:bg-blue-800 focus:outline-none">
                    <svg class="me-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <title>attachment</title>
                        <path fill="currentColor"
                            d="M7.5,18A5.5,5.5 0 0,1 2,12.5A5.5,5.5 0 0,1 7.5,7H18A4,4 0 0,1 22,11A4,4 0 0,1 18,15H9.5A2.5,2.5 0 0,1 7,12.5A2.5,2.5 0 0,1 9.5,10H17V11.5H9.5A1,1 0 0,0 8.5,12.5A1,1 0 0,0 9.5,13.5H18A2.5,2.5 0 0,0 20.5,11A2.5,2.5 0 0,0 18,8.5H7.5A4,4 0 0,0 3.5,12.5A4,4 0 0,0 7.5,16.5H17V18H7.5Z" />
                    </svg>
                    Attach
                </button>
            </div>

            {{-- Turn In Attachment Modal --}}
            <div data-modal-backdrop="static" id="temp-upload-modal" tabindex="-1" aria-hidden="true"
                class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
                <div class="relative max-h-full w-full max-w-2xl p-4">
                    <!-- Modal content -->
                    <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Upload files
                            </h3>
                            <button type="button"
                                class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="temp-upload-modal">
                                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="space-y-8 p-4 md:p-5">
                            <form id="turn_in_form" action="" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="batch_id" value="{{ $batch->id }}">

                                <input type="file" name="turn_in_attachments[]" id="turn_in_attachments">
                            </form>
                            <div>
                                <button data-modal-hide="default-modal" type="button"
                                    class="w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none">
                                    Done
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <form name="your_work" id="your_work" action="{{ route('turn_in_assignment') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                <div><input type="file" name="turn_in_attachment[]" id=""></div>
            </form> --}}
        </div>
    </div>
    @section('script')
        <script>
            // import * as FilePond from 'filepond';
            // import 'filepond/dist/filepond.min.css';
            // import FilePondPluginGetFile from 'filepond-plugin-get-file';

            document.addEventListener('DOMContentLoaded', function() {
                const posts = document.querySelectorAll('.post');

                posts.forEach(function(post) {
                    const description = post.querySelector('.description');
                    const content = description.innerHTML;

                    const urlRegex = /(https?:\/\/\S+)/g;

                    const replacedContent = content.replace(urlRegex,
                        '<a class="hover:text-underlined text-sky-500" href="$1" target="_blank">$1</a>');

                    description.innerHTML = replacedContent;
                });

                const inputElement = document.querySelector('#turn_in_attachments');

                // FilePond.registerPlugin(FilePondPluginGetFile)
                const pond = FilePond.create(inputElement)
                FilePond.setOptions({
                    allowMultiple: true,
                    allowReorder: true,
                    allowImagePreview: true,
                    server: {
                        process: {
                            url: '{{ route('turn_in_files') }}',
                            ondata: (formData) => {
                                formData.append('assignment_id', '{{ $assignment->id }}');
                                formData.append('batch_id', '{{ $enrollee->batch->id }}');
                                return formData;
                            },
                        },
                        load: '/load_files/{{ $enrollee->batch->id }}/',
                        revert: {
                            url: '{{ route('revert') }}',
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            ondata: (formData) => {
                                formData.append('assignment_id', '{{ $assignment->id }}');
                                formData.append('batch_id', '{{ $enrollee->batch->id }}');
                                return formData;
                            }
                        },
                        remove: (source, load, error) => {
                            fetch(`/delete_file/{{ $enrollee->batch->id }}/{{ $assignment->id }}/${source}`, {
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

                // document.body.appendChild(pond.element);

                fetch(`/get_files/{{ $assignment->id }}`)
                    .then(response => response.json())
                    .then(files => {
                        // files.forEach(file => {
                        //     pond.addFile(
                        //         `{{ asset('storage/assignments') }}/{{ $enrollee->batch->id }}/{{ $assignment->id }}/temp/${file.folder}/${file.filename}`, {
                        //             metadata: {
                        //                 id: file.id,
                        //             }
                        //         });
                        // });

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
                    })
                    .catch(error => console.error('Error loading files:', error));

                $('#turn_in_form').submit(function(event) {
                    event.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: formData,
                        success: function(response) {
                            $('#turn_in_form')[0].reset()
                            pond.removeFiles();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            })

            var isPending = false
            $(document).ready(function() {
                var file_number

                function getTurnInFiles() {
                    $.ajax({
                        url: "{{ route('get_files', $assignment->id) }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var size = 0;
                            for (var i in data) {
                                if (data) {
                                    size++;
                                }
                            }

                            if (size !== file_number) {
                                file_number = size
                                // console.log(data);

                                let filesHtml = '';
                                data.forEach(data => {

                                    const batchId = {{ $enrollee->batch->id }};
                                    const assignmentId = {{ $assignment->id }};
                                    const href =
                                        `{{ asset('storage/assignments/${batchId}/${assignmentId}/' . auth()->user()->id . '/${data.folder}/${data.filename}') }}`;
                                    // console.log(href);
                                    if (data.file_type == 'application/pdf') {
                                        filesHtml += `<div class="mb-2">
                            <a target="_blank" class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="${href}">
                                <svg class="mr-2 h-6 w-6" fill="rgb(185 28 28)" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>file-pdf-box</title>
                                    <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
                                </svg>
                                ${data.filename.split('/').pop().split('_').slice(2).join('_')}
                            </a>
                        </div>`;
                                    } else if (data.filename.endsWith('.docx') || data.filename
                                        .endsWith(
                                            '.doc')) {
                                        filesHtml += `
                        <div class="mb-2">
                            <a target="_blank" download class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="${href}">
                                <svg class="mr-2 h-6 w-6" fill="rgb(2 132 199)" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>file-word-box</title>
                                    <path d="M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                </svg>
                                ${data.filename.split('/').pop().split('_').slice(2).join('_')}
                            </a>
                        </div>`;
                                    } else if (data.filename.endsWith('.xlsx') || data.filename
                                        .endsWith(
                                            '.xls') || data.filename.endsWith('.csv')) {
                                        filesHtml += `
                        <div class="mb-2">
                            <a target="_blank" download class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="${href}">
                                <svg class="mr-2 h-6 w-6" fill="rgb(22 163 74)" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>file-excel-box</title>
                                    <path d="M16.2,17H14.2L12,13.2L9.8,17H7.8L11,12L7.8,7H9.8L12,10.8L14.2,7H16.2L13,12M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                </svg>
                                ${data.filename.split('/').pop().split('_').slice(2).join('_')}
                            </a>
                        </div>`;
                                    } else if (data.filename.endsWith('.txt')) {
                                        filesHtml += `
                        <div class="mb-2">
                            <a target="_blank" download class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="${href}">
                                <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>text-box</title>
                                    <path d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                </svg>
                                ${data.filename.split('/').pop().split('_').slice(2).join('_')}
                            </a>
                        </div>`;

                                    } else if (/\.(jpg|jpeg|png|gif)$/i.test(data.filename)) {
                                        filesHtml += `
                        <div class="mb-2">
                            <a target="_blank" class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="${href}">
                                <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>text-box</title>
                                    <path d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                </svg>
                                ${data.filename.split('/').pop().split('_').slice(2).join('_')}
                            </a>
                        </div>`;

                                    } else {
                                        filesHtml += `
                        <div class="mb-2">
                            <a target="_blank" download class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="${href}">
                                <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>file-document</title>
                                    <path d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M15,18V16H6V18H15M18,14V12H6V14H18Z" />
                                </svg>
                                ${data.filename.split('/').pop().split('_').slice(2).join('_')}
                            </a>
                        </div>`;


                                    }
                                })
                                $('#works_container').html(filesHtml);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching messages: ' + error);
                        }
                    });
                }

                getTurnInFiles();
                setInterval(getTurnInFiles, 3000);

                //icon_status
                var init_status;

                function turn_in_status() {
                    $.ajax({
                        url: `/turn_in_status`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            assignment_id: {{ $assignment->id }},
                        },
                        success: function(data) {
                            let status = '';
                            let info = '';
                            let color = '';
                            let button = '';

                            // if (init_status !== data.status) {
                            //     init_status = data.status
                            if (data.status === 'completed') {
                                status = `
                <div class="relative mr-2 inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>book-check-outline</title><path fill="#0369a1" d="M16.75 22.16L14 19.16L15.16 18L16.75 19.59L20.34 16L21.5 17.41L16.75 22.16M18 2C19.1 2 20 2.9 20 4V13.34C19.37 13.12 18.7 13 18 13V4H13V12L10.5 9.75L8 12V4H6V20H12.08C12.2 20.72 12.45 21.39 12.8 22H6C4.9 22 4 21.1 4 20V4C4 2.9 4.9 2 6 2H18Z" /></svg>
                </div>
                <span>Completed</span>`;
                                color = 'bg-sky'
                                button = 'Undo turn in'

                                if (data.assignment === 'closed') {
                                    info =
                                        `<span class="p-2 text-xs text-gray-300">Turned in. Assignment closed</span>`
                                } else {
                                    info = `<span class="p-2 text-xs text-gray-300">Turned in</span>`
                                }


                            } else if (data.status === 'pending' && data.assignment === 'closed') {
                                status = `
                <div class="relative mr-2 inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>book-cancel-outline</title><path fill="#b91c1c" d="M12.18 20C12.36 20.72 12.65 21.39 13.04 22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.18C19.5 12.07 19 12 18.5 12C18.33 12 18.17 12 18 12.03V4H13V12L10.5 9.75L8 12V4H6V20H12.18M23 18.5C23 21 21 23 18.5 23S14 21 14 18.5 16 14 18.5 14 23 16 23 18.5M20 21.08L15.92 17C15.65 17.42 15.5 17.94 15.5 18.5C15.5 20.16 16.84 21.5 18.5 21.5C19.06 21.5 19.58 21.35 20 21.08M21.5 18.5C21.5 16.84 20.16 15.5 18.5 15.5C17.94 15.5 17.42 15.65 17 15.92L21.08 20C21.35 19.58 21.5 19.06 21.5 18.5Z" /></svg>
                </div>
                <span>Closed</span>`;
                                color = 'bg-red'
                                button = 'Turn in'
                                info =
                                    `<span class="p-2 text-xs text-gray-300">Not turned in. Assignment closed</span>`


                            } else if (data.status === 'pending') {
                                status = `
                    <div class="relative mr-2 inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>book-clock-outline</title>
                            <path fill="#a16207" d="M20 11.26V4C20 2.9 19.11 2 18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H11.11C12.37 23.24 14.09 24 16 24C19.87 24 23 20.87 23 17C23 14.62 21.81 12.53 20 11.26M18 4V10.29C17.37 10.11 16.7 10 16 10C14.93 10 13.91 10.25 13 10.68V4H18M6 4H8V12L10.5 9.75L12.1 11.19C10.23 12.45 9 14.58 9 17C9 18.08 9.25 19.09 9.68 20H6V4M16 22C13.24 22 11 19.76 11 17S13.24 12 16 12 21 14.24 21 17 18.76 22 16 22M16.5 17.25L19.36 18.94L18.61 20.16L15 18V13H16.5V17.25Z" />
                        </svg>
                    </div>
                    <span>Pending</span>`;
                                color = 'bg-yellow'
                                button = 'Turn in'
                                info =
                                    `<span class="p-2 text-xs text-gray-300">Not turned in</span>`
                            }

                            $('#turn_in_status').html(status);
                            $('#turn_in_button').html(button);
                            $('#assignment_info').html(info)
                            $('#status').removeClass('bg-red-700');
                            $('#status').removeClass('bg-sky-700');
                            $('#status').removeClass('bg-yellow-700');
                            $('#status').addClass(color + '-700');
                            $('#turn_in_button').removeClass('bg-red-800');
                            $('#turn_in_button').removeClass('bg-sky-800');
                            $('#turn_in_button').removeClass('bg-yellow-800');
                            $('#turn_in_button').addClass(color + '-800');

                            if (data.assignment === 'closed') {
                                $('#turn_in_button').attr('disabled', true);
                                $('#turn_in_button').addClass('cursor-not-allowed');
                                $('#attach_button').attr('disabled', true)
                            } else {
                                $('#turn_in_button').attr('disabled', false);
                                $('#turn_in_button').removeClass('cursor-not-allowed');
                                $('#attach_button').attr('disabled', false)
                                $('#attach_button').removeClass('cursor-not-allowed');


                            }

                            if (data.status === 'completed') {
                                $('#attach_button').attr('disabled', true)
                                $('#attach_button').addClass('cursor-not-allowed');
                            } else {}
                            // }

                            // console.log(data);


                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }

                turn_in_status();
                if (!isPending) {
                    setInterval(turn_in_status, 2000)
                }
            });

            function assignment_action() {
                isPending = true
                $.ajax({
                    url: `/assignment_action`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        batch_id: {{ $enrollee->batch->id }},
                        assignment_id: {{ $assignment->id }},
                    },
                    success: function(data) {
                        // console.log(data);
                    },
                    error: function(error) {
                        console.log(error);
                    },
                    complete: function() {
                        isPending = false
                        // console.log('Request completed');
                    }
                })
            }

            var current_ajax_status

            setInterval(function() {
                if (current_ajax_status !== isPending) {
                    current_ajax_status = isPending
                    if (!isPending) {
                        // console.log("The request is completed.");
                    } else {
                        // console.log("The request is pending.");
                        loading = `<div role="status">
                        <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>`
                        $('#turn_in_button').html(loading)
                        $('#turn_in_button').attr('disabled', true)
                    }
                }

            }, 100)
        </script>
    @endsection
</x-app-layout>
