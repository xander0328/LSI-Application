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
                {{-- <div class="rounded-b-md bg-gray-700 p-2">
                    @if ($post->description != null)
                        <div class="post mb-2">
                            <pre class="description text-md font-sans">{{ $post->description }}</pre>
                        </div>
                    @endif
                    <div class="flex">
                        @foreach ($post->assignment_files as $files)
                            @if (Str::startsWith($files->file_type, 'image/'))
                                <div class="mb-2 mr-2"> <img class="h-48 w-auto" src="{{ 'storage/' . $files->path }}"
                                        alt="{{ str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path) }}">
                                </div>
                            @endif
                            @if ($files->file_type == 'application/pdf')
                                <div class="mb-2">
                                    <a target="_blank"
                                        class="text-md ms-2 flex rounded-md bg-gray-900 p-2 hover:bg-gray-800"
                                        href="{{ 'storage/' . $files->path }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(185 28 28)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-pdf-box</title>
                                            <path
                                                d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
                                        </svg>
                                        {{ substr(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), strpos(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif
                            @if (Str::endsWith($files->path, '.docx') || Str::endsWith($files->path, '.doc'))
                                <div class="mb-2">
                                    <a target="_blank" download
                                        class="text-md ms-2 flex rounded-md bg-gray-900 p-2 hover:bg-gray-800"
                                        href="{{ 'storage/' . $files->path }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(2 132 199)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-word-box</title>
                                            <path
                                                d="M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>

                                        {{ substr(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), strpos(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif
                            @if (Str::endsWith($files->path, '.xlsx') || Str::endsWith($files->path, '.xls') || Str::endsWith($files->path, '.csv'))
                                <div class="mb-2">
                                    <a target="_blank" download
                                        class="ms2x text-md flex rounded-md bg-gray-900 p-2 hover:bg-gray-800"
                                        href="{{ 'storage/' . $files->path }}">
                                        <svg class="mr-2 h-6 w-6" fill="rgb(22 163 74)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>file-excel-box</title>
                                            <path
                                                d="M16.2,17H14.2L12,13.2L9.8,17H7.8L11,12L7.8,7H9.8L12,10.8L14.2,7H16.2L13,12M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>
                                        {{ substr(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), strpos(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif
                            @if (Str::endsWith($files->path, '.txt'))
                                <div class="mb-2">
                                    <a target="_blank" download
                                        class="text-md ms-2 flex rounded-md bg-gray-900 p-2 hover:bg-gray-800"
                                        href="{{ 'storage/' . $files->path }}">
                                        <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>text-box</title>
                                            <path
                                                d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                        </svg>
                                        {{ substr(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), strpos(str_replace('assignment/' . $enrollee->batch->id . '/', '', $files->path), '_') + 1) }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div> --}}

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
        </script>
    @endsection
</x-app-layout>
