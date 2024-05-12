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
    <div id="course_list" class="mx-8 mt-2 pt-44 text-white">
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
            <div class="mb-2 flex items-center justify-between rounded-sm bg-yellow-700 p-2 text-white">
                <div class="text-md">Pending</div>
                <div>
                    <button id="turn_in" class="bg-yellow-800 p-2 px-4 text-sm hover:bg-gray-700">Turn in</button>
                </div>
            </div>
            <div>
                <div class="text-2xl font-semibold text-white"> {{ $assignment->title }}
                </div>
            </div>

            <div class="p-px text-sm">## points | Due
                {{ \Carbon\Carbon::parse($assignment->due_date)->format('F d, Y') }}
                {{ \Carbon\Carbon::parse($assignment->due_hour)->format('h:i A') }}</div>

        </div>
        <div>
            <div class="text-sm">Instructions</div>
            @if ($assignment->description == null)
                <div class="mb-4 p-px text-sm text-gray-700">None</div>
            @else
                <pre class="mb-4 p-px text-sm">{{ $assignment->description }}</pre>
            @endif
            <div class="mb-4">
                @foreach ($assignment->assignment_files as $files)
                    @if ($files->file_type == 'application/pdf')
                        <div class="mb-2">
                            <a target="_blank" class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="{{ asset('storage/' . $files->path) }}">
                                <svg class="mr-2 h-6 w-6" fill="rgb(185 28 28)" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>file-pdf-box</title>
                                    <path
                                        d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
                                </svg>
                                {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                        </div>
                    @endif
                    @if (Str::endsWith($files->path, '.docx') || Str::endsWith($files->path, '.doc'))
                        <div class="mb-2">
                            <a target="_blank" download
                                class="text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="{{ asset('storage/' . $files->path) }}">
                                <svg class="mr-2 h-6 w-6" fill="rgb(2 132 199)" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>file-word-box</title>
                                    <path
                                        d="M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                </svg>

                                {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                        </div>
                    @endif
                    @if (Str::endsWith($files->path, '.xlsx') || Str::endsWith($files->path, '.xls') || Str::endsWith($files->path, '.csv'))
                        <div class="mb-2">
                            <a target="_blank" download
                                class="ms2x text-md flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="{{ asset('storage/' . $files->path) }}">
                                <svg class="mr-2 h-6 w-6" fill="rgb(22 163 74)" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>file-excel-box</title>
                                    <path
                                        d="M16.2,17H14.2L12,13.2L9.8,17H7.8L11,12L7.8,7H9.8L12,10.8L14.2,7H16.2L13,12M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                </svg>
                                {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                        </div>
                    @endif
                    @if (Str::endsWith($files->path, '.txt'))
                        <div class="mb-2">
                            <a target="_blank" download
                                class="text-md ms-2 flex rounded-md bg-gray-800 p-2 hover:bg-gray-700"
                                href="{{ asset('storage/' . $files->path) }}">
                                <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <title>text-box</title>
                                    <path
                                        d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                                </svg>
                                {{ substr(str_replace('uploads/', '', $files->path), strpos(str_replace('uploads/', '', $files->path), '_') + 1) }}</a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div>
            <div>Your work</div>
            <form name="your_work" id="your_work" action="{{ route('turn_in_assignment') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                <div><input type="file" name="turn_in_attachment[]" id=""></div>
            </form>
        </div>
    </div>
    @section('script')
        <script>
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

                $('#turn_in').click(function(e) {
                    e.preventDefault();
                    var form = new FormData(this)
                    // console.log($('#your_work'));
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form,
                        processData: false, // Prevent jQuery from processing the data
                        contentType: false, // Prevent jQuery from setting contentType
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            })
        </script>
    @endsection
</x-app-layout>
