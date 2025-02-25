<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between text-black dark:text-white">
            <div class="flex-row items-center text-2xl font-semibold to-sky-950 dark:text-white md:flex md:space-x-1">
                <div>{{ __('Stream') }}</div>
                <div class="hidden text-slate-600 md:block">|</div>
                <div class="text-sm font-normal leading-none text-sky-500 md:text-lg">{{ $batch->course->name }}</div>
            </div>
            <div class="items-center hidden md:flex">
                <div class="flex mr-4 space-x-1">
                    <div class="text-white/75"> Batch: </div>
                    <div>
                        {{ $batch->course->code }}-{{ $batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex items-center md:hidden">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center p-1 rounded-md hover:bg-gray-900/50">
                            <svg class="text-white h-7 w-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>dots-vertical</title>
                                <path
                                    d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="m-1.5 flex-row">
                            <div class="flex justify-center my-2 space-x-1 text-xs">
                                <div class="text-white/75"> Batch: </div>
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
    <div x-data="comment" id="course_list"
        class="pt-40 pb-20 mx-4 my-6 text-black dark:text-white md:mx-8 md:pt-44">
        <div class="my-1.5 rounded-md bg-white p-3 shadow-md dark:bg-gray-800">
            <div class="mb-1.5 flex items-center justify-between px-2 text-xs">
                <div>
                    <div>
                        <div
                            class="relative inline-flex items-center justify-center w-8 h-8 p-1 overflow-hidden rounded-full bg-sky-800">
                            <svg class="self-center w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M9 22C8.4 22 8 21.6 8 21V18H4C2.9 18 2 17.1 2 16V4C2 2.9 2.9 2 4 2H20C21.1 2 22 2.9 22 4V16C22 17.1 21.1 18 20 18H13.9L10.2 21.7C10 21.9 9.8 22 9.5 22H9M10 16V19.1L13.1 16H20V4H4V16H10M18 14V6H13V14L15.5 12.5L18 14Z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between">
                    <div class="flex items-center me-2">
                        <svg class="self-center w-3 h-3 mr-1 text-black dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <div x-text="formatDate(post.formatted_created_at)"></div>
                    </div>
                </div>
            </div>
            <div class="p-2 text-sm md:text-base">
                <div x-show="post.description" class="mb-2 post">
                    <p x-html="sanitize(post.description)" class="font-sans description">
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
                                <div class="block image" :id="`post_${post.id}`">
                                    <template x-for="file in post.files" :key="file.id">
                                        <template x-if="imageExtensions.some(ext => file.filename.endsWith(ext))">
                                            <div class="border border-transparent rounded-md image-item hover:border-2 hover:border-solid hover:border-sky-700"
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
                    <div class="pt-2 mt-3 text-xs text-gray-500 border-t border-gray-500 dark:border-white/25 dark:text-white/50"
                        x-text="`Updated: ${moment(post.updated_at).format('lll')}`">
                    </div>
                </template>
            </div>
        </div>
        <div class="mt-4 text-lg">Comments</div>
        <div class="my-1.5 rounded-md bg-white p-3 shadow-md dark:bg-gray-800">
            <div class="flex items-center justify-between px-2 mb-4 text-xs">
                <div class="space-y-2">

                    <template x-for="comment in post.comments">
                        <div :class="{
                            'bg-sky-200': comment.user.id == user_id
                        }"
                            class="flex items-start gap-2.5 rounded-md p-2">
                            <template x-if="comment.user.role === 'instructor'">
                                <img class="w-8 h-8 border-2 rounded-full border-sky-950"
                                    :src="'{{ asset(':image') }}'.replace(':image',
                                        `storage/instructor_files/${comment.user.id}/${comment.user.instructor_info.folder}/${comment.user.instructor_info.id_picture}`
                                    )"
                                    alt="Jese image">
                            </template>
                            <template x-if="comment.user.role === 'student'">
                                <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg"
                                    alt="Jese image">
                            </template>
                            {{-- <div class="w-8 h-8 bg-white rounded-full"></div> --}}
                            <div class="leading-1.5 flex w-full flex-col">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-xs font-semibold text-gray-900 dark:text-white md:text-sm"
                                        x-text="comment.user.fname+' '+comment.user.lname">Bonnie
                                        Green</span>
                                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400 md:text-sm"
                                        x-text="formatDate(comment.formatted_created_at)">11:46</span>
                                </div>
                                <p class="py-1 text-xs font-normal text-gray-900 dark:text-white md:text-sm"
                                    x-text="comment.comment"></p>
                            </div>
                        </div>
                    </template>

                </div>

            </div>
            <form x-data="{ commentLoading: false }" method="POST"
                action="{{ auth()->user()->role == 'student' ? route('student.add_comment') : route('instructor.add_comment') }}"
                @keydown.enter="$event.target.form.submit(); commentLoading = true">
                <label for="chat" class="sr-only">Your message</label>
                <div class="flex items-center rounded-lg bg-gray-50 dark:bg-gray-700">
                    @csrf
                    <input type="hidden" name="post_id" :value="post.id">
                    <textarea rows="1" id="chat" name="comment" :readonly="commentLoading"
                        class="me-4 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Your comment"></textarea>
                    <button type="submit"
                        class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                        <svg x-cloak x-show="!commentLoading" class="w-5 h-5 rotate-90 rtl:-rotate-90"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 20">
                            <path
                                d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                        </svg>
                        <svg x-cloak x-show="commentLoading" aria-hidden="true"
                            class="inline w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Send message</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @section('script')
        <script>
            function comment() {
                return {
                    imageExtensions: ['jpeg', 'jpg', 'png', 'jfif'],
                    user_id: {{ auth()->user()->id }},
                    batch: @json($batch ?? ''),
                    post: @json($batch->only_post ?? ''),
                    init() {
                        console.log(this.post);

                    },
                    sanitize(content) {
                        return DOMPurify.sanitize(content);
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
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
