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
        src: url('/resources/font/Figtree-VariableFont_wght.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
        }

        .ql-editor {
        font-family: 'Figtree', Arial, sans-serif;
        font-size: 16px;
        color: #000; /* Text color */
        }
        {{-- 
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
        } --}}

        {{-- Displaying --}}
        ol {
        list-style-type: disc; /* Or circle, square, etc. for different bullet styles */
        padding-left: 20px; /* Adjust the indentation as needed */
        }

        [x-cloak] { display: none !important; }
    @endsection
    @section('style-links')
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between  text-black dark:text-white">
            <div
                class="md:flex flex-row items-center md:space-x-1 text-2xl font-semibold text-sky-950 dark: text-black dark:text-white">
                <div>{{ __('Stream') }}</div>
                <div class="hidden md:block text-slate-600">|</div>
                <div class="md:text-lg text-sm leading-none font-normal text-sky-500">{{ $batch->course->name }}</div>
            </div>
            <div class="hidden md:flex items-center">
                <div class="flex space-x-1 mr-4">
                    <div class=" text-black dark:text-white/75"> Batch: </div>
                    <div>
                        {{ $batch->course->code }}-{{ $batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex md:hidden items-center">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center p-1  rounded-md hover:bg-gray-900/50">
                            <svg class="h-7 w-7  text-black dark:text-white" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <title>dots-vertical</title>
                                <path
                                    d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="m-1.5 flex-row">
                            <div class="my-2 flex justify-center text-xs space-x-1">
                                <div class=" text-black dark:text-white/75"> Batch: </div>
                                <div>
                                    {{ $batch->course->code }}-{{ $batch->name }}
                                </div>
                            </div>
                            <x-course-nav :selected="'stream'" :batch="$batch->id"></x-course-nav>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div class="hidden md:block">

            <x-course-nav :selected="'stream'" :batch="$batch->id"></x-course-nav>
        </div>

    </x-slot>
    <div x-data="stream" id="course_list" class="mx-4 md:mx-8 pt-40 md:pt-44 pb-20  text-black dark:text-white">
        <div class="flex flex-col-reverse py-6">
            <template x-if="posts.length > 0">
                <template x-for="post in posts" :key="post.id">
                    <div class="my-1.5 rounded-md bg-white dark:bg-gray-800 p-3 shadow-md">
                        <div class="mb-1.5 flex items-center justify-between px-2 text-xs">
                            <div>
                                <div>
                                    <div
                                        class="relative inline-flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-sky-800 p-1">
                                        <svg class="w-5 self-center  text-white" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M9 22C8.4 22 8 21.6 8 21V18H4C2.9 18 2 17.1 2 16V4C2 2.9 2.9 2 4 2H20C21.1 2 22 2.9 22 4V16C22 17.1 21.1 18 20 18H13.9L10.2 21.7C10 21.9 9.8 22 9.5 22H9M10 16V19.1L13.1 16H20V4H4V16H10M18 14V6H13V14L15.5 12.5L18 14Z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div class="me-2 flex items-center">
                                    <svg class="mr-1 h-3 w-3 self-center  text-black dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <div x-text="post.formattedDate"></div>
                                </div>
                                <div class="relative cursor-pointer">
                                    <x-dropdown width="40" align="right">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center rounded-md border border-transparent bg-white text-sm font-medium leading-4 text-black  transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                                <svg class="h-7 w-7  text-black dark:text-white hover:text-sky-500"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="m-1.5">
                                                <a @click="editPost(post.id)"
                                                    class="flex w-full items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-black hover:text-white dark:text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
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
                                                        class="flex items-center space-x-1.5 rounded-md px-1.5"
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
                        <div class="p-2 text-sm md:text-base">
                            <div x-show="post.description" class="post mb-2">
                                <p x-html="sanitize(post.description)" class="description font-sans">
                                </p>
                            </div>
                            <div class="text-black dark:text-white">
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
                                                            x-data="{
                                                                path: `{{ asset('storage/uploads/') }}/${batch.id}/${post.id}/${file.filename}`,
                                                                imageShow: true,
                                                                lightbox: `statis-id`,
                                                            }">
                                                            <x-file-type-checker-alpine></x-file-type-checker-alpine>
                                                        </div>
                                                    </template>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            <template x-if="moment(post.created_at).format() != moment(post.updated_at).format()">
                                <div class="pt-2 mt-3 border-t border-gray-500 dark:border-white/25 text-xs  text-gray-500 dark:text-white/50"
                                    x-text="`Updated: ${moment(post.updated_at).format('lll')}`">
                                </div>
                            </template>
                            <div class="md:flex md:justify-end">
                                <div class="mt-1.5 text-white bg-sky-600 hover:bg-sky-700 rounded  md:w-1/5">
                                    <a :href="`{{ route('instructor.comments', ['post_id' => ':id']) }}`.replace(':id', post.id)"
                                        class="w-full p-1.5 flex space-x-1 items-center justify-center">
                                        <span>
                                            <svg class="h-4 w-4 mt-0.5" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <title>comment</title>
                                                <path
                                                    d="M9,22A1,1 0 0,1 8,21V18H4A2,2 0 0,1 2,16V4C2,2.89 2.9,2 4,2H20A2,2 0 0,1 22,4V16A2,2 0 0,1 20,18H13.9L10.2,21.71C10,21.9 9.75,22 9.5,22V22H9Z" />
                                            </svg>
                                        </span>
                                        <span>
                                            Comment
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
            <template x-if="posts.length == 0">
                <div class="bg-gray-700/35 mt-2.5 rounded-md p-2.5 text-center text-sm text-gray-300">No Post
                </div>
            </template>
            <template x-if="batch.length == 0">
                <div class="bg-gray-700/35 mt-2.5 rounded-md p-2.5 text-center text-sm text-gray-300">We will
                    contact you as
                    soon as
                    possible, feel free
                    to contact us here for inquiries</div>
            </template>

            {{-- Speed Dial --}}
            <template x-if="batch.completed_at == null">
                <div data-dial-init class="group fixed bottom-6 end-6">
                    <div id="speed-dial-menu-text-inside-button-square"
                        class="mb-4 flex hidden flex-col items-center space-y-2">
                        <button type="button" @click="edit = false; createPost()"
                            class="h-[56px] w-[56px] rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                            <svg class="mx-auto mb-1 h-4 w-4" fill="currentColor"xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>note-edit-outline</title>
                                <path
                                    d="M18.13 12L19.39 10.74C19.83 10.3 20.39 10.06 21 10V9L15 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.89 21 5 21H11V19.13L11.13 19H5V5H12V12H18.13M14 4.5L19.5 10H14V4.5M19.13 13.83L21.17 15.87L15.04 22H13V19.96L19.13 13.83M22.85 14.19L21.87 15.17L19.83 13.13L20.81 12.15C21 11.95 21.33 11.95 21.53 12.15L22.85 13.47C23.05 13.67 23.05 14 22.85 14.19Z" />
                            </svg>
                            <span class="mb-px block text-xs font-medium">Post</span>
                        </button>

                    </div>
                    <button type="button" data-dial-toggle="speed-dial-menu-text-inside-button-square"
                        aria-controls="speed-dial-menu-text-inside-button-square" aria-expanded="false"
                        class="flex h-14 w-14 items-center justify-center rounded-lg bg-blue-700   text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="h-5 w-5 transition-transform group-hover:rotate-45" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M9 1v16M1 9h16" />
                        </svg>
                        <span class="sr-only">Open actions menu</span>
                    </button>
                </div>
            </template>
        </div>

        {{-- Create Post Modal --}}
        <div x-cloak x-show="postModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900  dark:text-white" x-text="modalTitle">
                            Create New Post
                        </h3>
                        <button type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600  dark:text-white"
                            @click="triggerPostModal(); showAddFile = false;">
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
                            <div class="rounded-lg bg-white">
                                <div class="bg-white" id="editor"></div>
                            </div>
                        </div>
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="rounded-full text-xs  text-black dark:text-white">
                                <a class="flex cursor-pointer items-center" @click="toggleShowAddFile()">Attach
                                    File/s
                                    <svg x-show="showAddFile" class="ml-2 h-4 w-4  text-black dark:text-white"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m5 15 7-7 7 7" />
                                    </svg>
                                    <svg x-show="!showAddFile" class="ml-2 h-4 w-4 text-gray-800 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 9-7 7-7-7" />
                                    </svg>
                                </a>
                            </div>

                            <div x-show="showAddFile" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95" id="show_addFile_post"
                                class="col-span-2">
                                {{-- <label for="name"
                            class="mb-2 block text-sm font-medium text-gray-900  dark:text-white">Attach
                            File/s</label> --}}
                                <input id="file"
                                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                    type="file" name="file[]" accept=".jpg, .png, .xlsx, .docx, .txt" multiple>
                            </div>

                        </div>
                        <button type="button" @click="formCheck()"
                            class="w-full items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                            <div class="flex justify-center">
                                Post
                            </div>
                        </button>

                    </form>
                </div>
            </div>
        </div>

    </div>

    @section('script')
        <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
        <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        {{-- File Pond --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script> --}}

        <script type="text/javascript">
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
                    postModal: false,
                    modalTitle: '',
                    showAddFile: false,
                    init() {
                        console.log(this.batch);

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
                            container: '#toolbar',
                            modules: {
                                toolbar: toolbarOptions
                            }
                        });

                        $('[role="toolbar"]').addClass('rounded-t-lg')
                        $('#editor').addClass('rounded-b-lg')
                    },
                    formCheck() {
                        $('#message').val(this.quill.root.innerHTML)
                        var rawMessage = this.quill.root.innerHTML

                        var messageValue = rawMessage.replace(/(<([^>]+)>)/gi, "").trim();
                        var fileValue = $('input[name="file[]"]').val();

                        if (messageValue.length === 0 && fileValue === '') {
                            this.notification('error', 'Please provide a message or upload a file.', 'Empty Form')
                            return
                        }
                        $('#post_form').submit()
                    },
                    sanitize(content) {
                        return DOMPurify.sanitize(content);
                    },
                    filePond_config() {
                        FilePond.registerPlugin(FilePondPluginImagePreview);
                        const input_element = document.querySelector('#file');
                        this.filepondInstance = FilePond.create(input_element);
                    },
                    editPost(postId) {
                        this.edit = true;
                        this.triggerPostModal();
                        this.modalTitle = 'Edit Post'

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

                        if (this.selectedFiles.length > 0) {
                            this.toggleShowAddFile();
                        }

                        this.$nextTick(() => {
                            try {
                                this.quill.root.innerHTML = this.selectedPost[0].description;
                            } catch (error) {
                                console.error(error);
                            }
                        })

                        console.log(this.quill);
                    },
                    createPost() {
                        this.edit = false;
                        this.triggerPostModal();
                        this.modalTitle = 'Create New Post'

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

                        if (this.tempFiles.length > 0) {
                            this.toggleShowAddFile();
                        }
                    },
                    triggerPostModal() {
                        if (this.postModal == true) {
                            var res = confirm("Are you sure you want to close? This will be discarded. ")
                            if (res) {
                                this.postModal = !this.postModal;
                            }
                        } else {
                            this.postModal = !this.postModal;
                        }
                    },
                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message,
                            title ?? title);
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
                        $('.description a').addClass(
                            "text-sky-400 hover:underline underline-offset-2"
                        )
                        $('.description p').addClass(' break-words')

                    },
                    toggleShowAddFile() {
                        this.showAddFile = !this.showAddFile
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
