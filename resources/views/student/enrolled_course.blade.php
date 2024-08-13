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

        {{-- Display --}}
        ol {
        list-style-type: disc; /* Or circle, square, etc. for different bullet styles */
        padding-left: 20px; /* Adjust the indentation as needed */
        }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="flex items-center text-2xl font-semibold text-white">
                {{ __('Enrolled Course') }} <span class="mx-1.5 text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $enrollee->course->name }}</span>
            </div>
            <div>Batch: {{ $enrollee->batch ? $enrollee->batch->name : 'NONE' }}</div>
        </div>
        @if ($enrollee->batch)
            <x-course-nav :selected="'stream'"></x-course-nav>
        @endif

    </x-slot>
    <div x-data="stream" id="course_list" class="mx-8  flex flex-col-reverse pt-44 text-white">
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
                        <div class="flex items-center">
                            <svg class="mr-1 h-3 w-3 self-center text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <div x-text="post.formattedDate">
                                {{-- {{ \Carbon\Carbon::parse($post->created_at)->format('F d, Y h:m') }} --}}
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <div x-show="post.description" class="post mb-2">
                            <p x-html="sanitize(post.description)" class="description font-sans"></p>
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
    @section('script')
        <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
        <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.1.5/purify.min.js"
            integrity="sha512-JatFEe90fJU2nrgf27fUz2hWRvdYrSlTEV8esFuqCtfiqWN8phkS1fUl/xCfYyrLDQcNf3YyS0V9hG7U4RHNmQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     const posts = document.querySelectorAll('.post');

            //     posts.forEach(function(post) {
            //         const description = post.querySelector('.description');
            //         const content = description.innerHTML;

            //         // Regular expression to find URLs
            //         const urlRegex = /(https?:\/\/\S+)/g;

            //         // Replace URLs with anchor tags
            //         const replacedContent = content.replace(urlRegex,
            //             '<a class="hover:text-underlined text-sky-500" href="$1" target="_blank">$1</a>');

            //         // Update the description content
            //         description.innerHTML = replacedContent;
            //     });
            // })

            function stream() {
                return {
                    posts: @if ($posts)
                        @json($posts)
                    @endif ,
                    batch: @if ($batch)
                        @json($batch)
                    @endif ,
                    imageExtensions: ['jpeg', 'jpg', 'png', 'jfif'],
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

                        this.imageLayout();
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
                                console.log(elem);

                                if (elem) {
                                    try {
                                        var msnry = new Masonry(elem, {
                                            itemSelector: '.image-item',
                                            columnWidth: '.image-item',
                                            percentPosition: true,
                                            gutter: 5,

                                        });
                                        console.log(msnry.items.length + ' filtered items');

                                        imagesLoaded(elem).on('progress', function() {
                                            msnry.layout();
                                        });
                                    } catch (error) {
                                        console.log(error);
                                    }
                                    console.log(post.id);
                                } else {
                                    console.warn('Element not found for post id:', post.id);
                                }
                            });
                        });
                    },
                    sanitize(content) {
                        return DOMPurify.sanitize(content);
                    },
                    formatLinks() {
                        $('.description a').addClass(
                            "text-sky-400 hover:underline underline-offset-2"
                        )
                        $('.description p').addClass(' break-words')
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
