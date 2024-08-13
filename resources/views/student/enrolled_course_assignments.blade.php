<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Enrolled Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $enrollee->course->name }}</span>
            </div>
            <div>Batch: {{ $enrollee->batch->name }}</div>
        </div>
        <x-course-nav :selected="'assignment'"></x-course-nav>

    </x-slot>
    <div id="course_list" class="mx-8 mt-2 flex flex-col-reverse pt-44 text-white">
        @foreach ($assignments as $post)
            <div class="mb-2 rounded-md bg-gray-800 p-px">
                <div class="my-2 w-full rounded-md bg-gray-800 px-3 py-px">
                    <a href="{{ route('view_assignment', $post->id) }}" class="flex items-center justify-between">
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
                                <div>{{ $post->title }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ mb_strimwidth($post->description, 0, 70, '...') }}</div>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            @if ($post->due_date != null)
                                Due {{ $post->due_date }}
                            @else
                                No due
                            @endif
                        </div>
                    </a>

                </div>
            </div>
        @endforeach
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

            function assignmentList(){
                return{
                    
                }
            }
        </script>
    @endsection
</x-app-layout>
