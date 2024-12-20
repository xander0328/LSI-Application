<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="flex-row items-center text-2xl font-semibold text-sky-950 dark:text-white md:flex md:space-x-1">
                <div>{{ __('Assignments') }}</div>
                <div class="hidden text-slate-600 md:block">|</div>
                <div class="text-sm font-normal leading-none text-sky-500 md:text-lg">{{ $batch->course->name }}</div>
            </div>
            <div class="hidden items-center md:flex">
                <div class="mr-4 flex space-x-1">
                    <div class="text-black text-white/75"> Batch: </div>
                    <div>
                        {{ $batch->course->code }}-{{ $batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex items-center md:hidden">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md p-1 hover:bg-gray-900/50">
                            <svg class="h-7 w-7 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>dots-vertical</title>
                                <path
                                    d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="m-1.5 flex-row">
                            <div class="my-2 flex justify-center space-x-1 text-xs">
                                <div class="text-black text-white/75"> Batch: </div>
                                <div>
                                    {{ $batch->course->code }}-{{ $batch->name }}
                                </div>
                            </div>
                            <x-course-nav :selected="'assignment'" :batch="$batch->id"></x-course-nav>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div class="hidden md:block">

            <x-course-nav :selected="'assignment'" :batch="$batch->id"></x-course-nav>
        </div>

    </x-slot>
    <div x-data="assignmentComponent()" id="course_list" class="mx-8 pb-4 pt-44 text-black dark:text-white md:pt-48">

        <div x-cloak x-show="$store.sharedState.assignmentUpdate"
            class="p-4 flex bg-white/80 rounded-lg items-center justify-between text-sm">
            <span>New Update</span>
            <span class="px-2 py-1 bg-sky-600 hover:bg-sky-700 rounded text-white">
                <a class="cursor-pointer" @click="location.reload()">REFRESH</a>
            </span>
        </div>
        <div class="my-4">
            <div x-cloak id="status"
                :class="{
                    'bg-sky-700': status == 'completed',
                    'bg-yellow-700': status === 'pending' && assignment === 'open',
                    'bg-red-700': status === 'pending' && assignment === 'closed',
                }"
                class="flex items-center justify-between rounded-md p-2 text-white" :class="statusColor">
                {{-- <div id="turn_in_status" class="text-md flex items-center" x-html="status"></div> --}}
                <div class="flex items-center">
                    <div
                        class="relative mr-2 inline-flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-white p-1.5">
                        <svg x-show="status === 'completed'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>book-check-outline</title>
                            <path fill="#0369a1"
                                d="M16.75 22.16L14 19.16L15.16 18L16.75 19.59L20.34 16L21.5 17.41L16.75 22.16M18 2C19.1 2 20 2.9 20 4V13.34C19.37 13.12 18.7 13 18 13V4H13V12L10.5 9.75L8 12V4H6V20H12.08C12.2 20.72 12.45 21.39 12.8 22H6C4.9 22 4 21.1 4 20V4C4 2.9 4.9 2 6 2H18Z" />
                        </svg>
                        <svg x-show="status === 'pending' && assignment === 'closed'" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <title>book-cancel-outline</title>
                            <path fill="#b91c1c"
                                d="M12.18 20C12.36 20.72 12.65 21.39 13.04 22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.18C19.5 12.07 19 12 18.5 12C18.33 12 18.17 12 18 12.03V4H13V12L10.5 9.75L8 12V4H6V20H12.18M23 18.5C23 21 21 23 18.5 23S14 21 14 18.5 16 14 18.5 14 23 16 23 18.5M20 21.08L15.92 17C15.65 17.42 15.5 17.94 15.5 18.5C15.5 20.16 16.84 21.5 18.5 21.5C19.06 21.5 19.58 21.35 20 21.08M21.5 18.5C21.5 16.84 20.16 15.5 18.5 15.5C17.94 15.5 17.42 15.65 17 15.92L21.08 20C21.35 19.58 21.5 19.06 21.5 18.5Z" />
                        </svg>
                        <svg x-show="status === 'pending' && assignment === 'open'" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <title>book-clock-outline</title>
                            <path fill="#a16207"
                                d="M20 11.26V4C20 2.9 19.11 2 18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H11.11C12.37 23.24 14.09 24 16 24C19.87 24 23 20.87 23 17C23 14.62 21.81 12.53 20 11.26M18 4V10.29C17.37 10.11 16.7 10 16 10C14.93 10 13.91 10.25 13 10.68V4H18M6 4H8V12L10.5 9.75L12.1 11.19C10.23 12.45 9 14.58 9 17C9 18.08 9.25 19.09 9.68 20H6V4M16 22C13.24 22 11 19.76 11 17S13.24 12 16 12 21 14.24 21 17 18.76 22 16 22M16.5 17.25L19.36 18.94L18.61 20.16L15 18V13H16.5V17.25Z" />
                        </svg>
                    </div>
                    <div class="text-lg" x-text="assignmentStatus"></div>
                </div>

                <div>
                    <button @click="assignmentAction()" id="turn_in_button"
                        class="rounded-md p-2 px-4 text-sm hover:bg-gray-700"
                        :class="{
                            'bg-sky-900/75': status == 'completed',
                            'bg-yellow-900/75': status === 'pending',
                            'bg-red-900/75': status === 'closed',
                            'cursor-not-allowed': assignmentButton.disable,
                        }"
                        :disabled="assignmentButton.disable">

                        <span x-cloak x-show="!isPending" x-text="assignmentButton.text"></span>
                        <span x-cloak x-show="isPending">
                            <div role="status">
                                <svg aria-hidden="true"
                                    class="h-5 w-5 animate-spin fill-white text-gray-200 dark:text-gray-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </span>
                    </button>
                </div>
            </div>
            <div class="flex justify-end p-2 text-xs italic" id="assignment_info" x-text="info"></div>
            <div>
                <div class="text-2xl font-semibold text-black dark:text-white"> {{ $assignment->title }}
                </div>
            </div>

            <div class="mb-1.5 flex items-center p-px text-sm">
                <span
                    class="relative mr-px inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" />
                    </svg>
                </span>
                {{ $assignment->points }} points |
                <span
                    class="relative mx-px ml-2 inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
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
            <div class="mb-1.5 p-px text-xs">
                @if (!$assignment->closed)
                    @if ($assignment->closing)
                        Submission will be closed after due
                    @endif
                @endif
            </div>
            @if ($student_grade && $student_grade->grade != 0)
                <span class="rounded-md bg-sky-800 p-2 text-sm text-white">
                    Your grade: {{ $student_grade->grade }}
                </span>
            @else
                <div class="text-xs">
                    <span class="rounded bg-yellow-700 px-2 py-1 text-white">
                        Not graded yet
                    </span>
                </div>
            @endif

        </div>
        @if ($student_grade && $student_grade->remark != null)
            <div class="mb-4 rounded-lg bg-gray-700/50 p-2">
                <div class="text-sm font-bold">Facilitator's Remarks</div>
                <pre class="text-wrap p-px font-sans text-sm italic">" {{ $student_grade->remark }} "</pre>
            </div>
        @endif
        <div>
            <div class="text-sm font-bold">Instructions</div>
            <div x-data="{ open: false }">
                @if ($assignment->description == null)
                    <div class="mb-4 p-px text-sm text-gray-700">None</div>
                @else
                    <pre :class="open ? '' : 'cursor-pointer line-clamp-6'" @click="open = !open"
                        class="text-wrap mb-4 p-px font-sans text-sm">{{ $assignment->description }}</pre>
                @endif
            </div>
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
        <div class="rounded-md bg-white p-4 dark:bg-gray-800">
            <div class="mb-1.5 text-sm font-bold">Your work</div>
            <div id="works_container">
                <template x-if="links.length > 0">
                    <div class="mb-2">
                        <div class="text-xs">Links</div>
                        <template x-for="link in links">
                            <div
                                class="flex items-center space-x-3 rounded-md bg-gray-200 p-2 dark:bg-gray-700 dark:hover:bg-gray-700/75">
                                <svg class="h-5 w-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>link-variant</title>
                                    <path
                                        d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
                                </svg>
                                <a class="w-full" :href="link.url" x-text="link.url"></a>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="hasSubmittedFiles">
                    <div>
                        <div class="text-xs">Files</div>
                        <template x-for="file in submittedFiles" :key="file.id">
                            <div class="mb-1.5" x-data="{ path: `{{ asset('storage/assignments/' . $batch->id . '/' . $assignment->id . '/' . $enrollee->id) }}/${file.folder}/${file.filename}`, imageShow: false }">
                                <x-file-type-checker-alpine></x-file-type-checker-alpine>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <div x-cloak>
                <button type="button" id="attach_button" @click="triggerAttachModal"
                    :class="{
                        'cursor-not-allowed': assignmentButton.disable || status == 'completed',
                    }"
                    :disabled="assignmentButton.disable || status == 'completed'"
                    class="inline-flex items-center rounded-lg bg-sky-950 p-2 text-center text-xs font-medium text-white hover:bg-blue-700 focus:outline-none">
                    <svg class="me-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M7.5,18A5.5,5.5 0 0,1 2,12.5A5.5,5.5 0 0,1 7.5,7H18A4,4 0 0,1 22,11A4,4 0 0,1 18,15H9.5A2.5,2.5 0 0,1 7,12.5A2.5,2.5 0 0,1 9.5,10H17V11.5H9.5A1,1 0 0,0 8.5,12.5A1,1 0 0,0 9.5,13.5H18A2.5,2.5 0 0,0 20.5,11A2.5,2.5 0 0,0 18,8.5H7.5A4,4 0 0,0 3.5,12.5A4,4 0 0,0 7.5,16.5H17V18H7.5Z" />
                    </svg>
                    Attach
                </button>
            </div>
        </div>

        {{-- Turn In Attachment Modal --}}
        <div x-cloak x-show="openModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" id="temp-upload-modal" tabindex="-1" aria-hidden="true"
            class="absolute inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-2xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Attachments
                        </h3>
                        {{-- <button type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button> --}}
                    </div>
                    <!-- Modal body -->
                    <div class="space-y-8 p-4 md:p-5">
                        <form id="turn_in_form" action="" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $enrollee->id }}">
                            <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                            <div class="flex justify-between">
                                <div class="text-black dark:text-white">Links</div>
                                <button type="button" class="rounded bg-sky-600 px-3 py-1 text-sm text-white"
                                    @click="addLink">
                                    Add Link
                                </button>
                            </div>
                            <div class="mb-4 space-y-2">
                                <template x-for="(link, index) in links" :key="index">
                                    <div class="flex items-center space-x-2">
                                        <input type="url" name="links[]" x-model="link.url"
                                            class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 px-2.5 py-1.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                            placeholder="Enter link" required />
                                        <button type="button" class="rounded-md bg-red-500 p-1 text-white"
                                            @click="removeLink(index)">
                                            <svg class="h-5 w-5" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <title>close</title>
                                                <path
                                                    d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <hr class="mb-4 text-white opacity-25">
                            <div class="mb-1 text-black dark:text-white">Files</div>
                            <input type="file" name="turn_in_attachments[]" id="turn_in_attachments">
                        </form>
                        <div>
                            <button @click="triggerAttachModal" type="button"
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
                <input type="hidden" name="user_id" value="{{ $enrollee->id }}">
                <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                <div><input type="file" name="turn_in_attachment[]" id=""></div>
            </form> --}}
    </div>
    @section('script')
        <script>
            function assignmentComponent() {
                return {
                    openModal: false,
                    status: '',
                    info: '',
                    statusColor: '',
                    assignmentButton: {
                        text: '',
                        disable: false
                    },
                    assignmentStatus: '',
                    isPending: false,
                    pond: '',
                    pondFiles: '',
                    submittedFiles: [],
                    hasSubmittedFiles: false,
                    links: [],

                    init() {
                        // console.log(this.pondFiles);
                        this.getTurnInFiles();
                        this.turnInStatus();
                        this.filepondInit();

                        setInterval(() => this.turnInStatus(), 5000);

                    },

                    addLink() {
                        this.links.push({
                            url: ''
                        });
                    },
                    removeLink(index) {
                        this.links.splice(index, 1);
                    },

                    async getTurnInFiles() {
                        var t = this
                        this.links = []
                        fetch("{{ route('get_files', $assignment->id) }}")
                            .then(response => response.json())
                            .then(data => {
                                this.submittedFiles = data.files;
                                console.log(data);
                                if (data.files != 'no files') {
                                    this.pondFiles = data.files.map(file => {
                                        return {
                                            source: file.id,
                                            options: {
                                                type: 'local',
                                            },
                                        }
                                    });
                                    console.log(this.pondFiles);
                                    this.hasSubmittedFiles = true;
                                } else {
                                    this.hasSubmittedFiles = false;
                                }

                                if (data.links != 'no links') {

                                    data.links.forEach(function(link) {
                                        t.links.push({
                                            url: link.link

                                        }); // Each URL is wrapped in its own array
                                    });
                                    console.log(t.links);
                                }
                            })
                            .catch(error => console.error('Error fetching files:', error));
                    },

                    processFiles(data) {
                        // Process files and return HTML string
                        // ... (implement file processing logic here)
                    },

                    turnInStatus() {
                        fetch('/course/turn_in_status', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    assignment_id: {{ $assignment->id }},
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                this.status = data.status;
                                this.assignment = data.assignment;

                                if (data.status == 'completed') {
                                    this.info = 'Turned in ' + (data.late ? 'late' : '')
                                    this.assignmentButton.text = 'Undo turn in'
                                    this.assignmentStatus = 'Completed'
                                } else {
                                    this.info = 'Not turned in '
                                    this.assignmentButton.text = 'Turn in'
                                    this.assignmentStatus = 'Pending'

                                }
                                this.assignmentButton.disable = false;


                                if (data.assignment == 'closed') {
                                    this.info += '. Assignment closed.'
                                    this.assignmentButton.disable = true;
                                    this.assignmentStatus = data.status !== 'completed' ? 'Closed' : 'Completed'
                                }
                                this.isPending = false;

                            })
                            .catch(error => console.error('Error fetching status:', error));
                    },

                    assignmentAction() {
                        this.isPending = true;
                        this.assignmentButton.disable = true;
                        var t = this;
                        fetch('/course/assignment_action', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    batch_id: {{ $enrollee->batch->id }},
                                    assignment_id: {{ $assignment->id }},
                                })
                            })
                            .then(response => response.json())
                            .then(data => {


                            })
                            .catch(error => console.error('Error:', error))
                            .finally(() => {
                                // t.isPending = false;
                            });
                    },

                    filepondInit() {
                        const input_element = document.querySelector('#turn_in_attachments');
                        this.pond = FilePond.create(input_element)
                    },

                    triggerAttachModal() {
                        this.openModal = !this.openModal;

                        this.pond.setOptions({
                            allowMultiple: true,
                            allowReorder: true,
                            allowImagePreview: true,
                            files: this.pondFiles,
                            server: {
                                process: {
                                    url: '{{ route('turn_in_files') }}',
                                    ondata: (formData) => {
                                        formData.append('assignment_id', '{{ $assignment->id }}');
                                        formData.append('batch_id', '{{ $enrollee->batch->id }}');
                                        return formData;
                                    },
                                },
                                load: '/load_files/{{ $enrollee->batch->id }}/{{ $assignment->id }}/',
                                revert: {
                                    url: '{{ route('revert') }}',
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

                        if (!this.openModal) {
                            this.uploadLinks();
                            this.getTurnInFiles();
                        }
                    },

                    messages: [
                        "🎉 Awesome job! Your assignment has been submitted! Keep shining! ✨",
                        "🚀 Well done! You've turned in your assignment. Celebrate your success! 🎊",
                        "🌟 Congratulations! Assignment submitted! You're one step closer to your goals! 🎈"
                    ],

                    uploadLinks() {
                        this.isPending = true;
                        this.assignmentButton.disable = true;
                        var t = this;
                        fetch('/course/upload_links', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    batch_id: {{ $enrollee->batch->id }},
                                    assignment_id: {{ $assignment->id }},
                                    links: t.links,
                                })
                            })
                            .then(response => response.json())
                            .then(data => {


                            })
                            .catch(error => console.error('Error:', error))
                            .finally(() => {
                                // t.isPending = false;
                            });
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
