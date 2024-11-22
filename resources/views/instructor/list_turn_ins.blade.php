<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-black dark:text-white">
            <div class="flex-row items-center text-2xl font-semibold text-black dark:text-white md:flex md:space-x-1">
                <div>{{ __('Assignments') }}</div>
                <div class="hidden text-slate-600 md:block">|</div>
                <div class="text-sm font-normal leading-none text-sky-500 md:text-lg">{{ $batch->course->name }}</div>
            </div>
            <div class="items-center hidden md:flex">
                <div class="flex mr-4 space-x-1">
                    <div class="text-black dark:text-white/75"> Batch: </div>
                    <div>
                        {{ $batch->course->code }}-{{ $batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex items-center md:hidden">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center p-1 rounded-md hover:bg-gray-900/50">
                            <svg class="text-black h-7 w-7 dark:text-white" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <title>dots-vertical</title>
                                <path
                                    d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="m-1.5 flex flex-col">
                            <div class="flex justify-center space-x-1 text-xs">
                                <div class="text-white/75"> Batch: </div>
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
    <div x-data="turnIns()" class="mx-4 mt-2 text-black pt-44 dark:text-white md:mx-8 md:pt-48">
        <div class="flex items-center justify-end mb-2">
            <div
                class="flex p-2 mx-1 my-1 bg-white rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-800">
                <label class="inline-flex items-center w-full cursor-pointer">
                    <input @change="closeSubmission()" type="checkbox"
                        :checked="assignment_details.closed ? true : false" class="sr-only assignment-toggle peer">
                    <div
                        class="peer relative h-5 w-9 rounded-full border-gray-500 bg-gray-400 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-sky-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none rtl:peer-checked:after:translate-x-[-100%]">
                    </div>
                    <span class="text-sm font-medium text-black ms-3 dark:text-gray-300">Close submissions</span>
                </label>
            </div>
            <button id="dropdownMenuIconHorizontalButton" data-dropdown-toggle="dropdownDotsHorizontal"
                class="inline-flex items-center p-2 my-1 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800"
                type="button">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg>
            </button>

            <div id="dropdownDotsHorizontal"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-52 dark:divide-gray-600 dark:bg-gray-800">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownMenuIconHorizontalButton">
                    <li>
                        <a href="javascript:void(0)" data-action="{{ route('get_assignment', $assignment->id) }}"
                            @click="triggerModal()"
                            class="flex items-center p-2 py-1 m-1 align-middle rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                            <svg class="w-6 h-5 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>Edit
                        </a>
                    </li>

                    <li>
                        <form id="delete-course" class="px-1" action="{{ route('delete_assignment') }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="assignment_id" :value="assignment_details.id">
                            <button @click.prevent="confirmDelete()" type="submit"
                                class="flex items-center w-full p-1 px-2 align-text-bottom rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                                <svg class="w-6 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M8.6 2.6A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4c0-.5.2-1 .6-1.4ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Delete</button>
                        </form>

                    </li>
                </ul>
            </div>
        </div>
        <div class="p-4 bg-white rounded-lg dark:bg-gray-700">
            <div class="text-2xl font-semibold text-black dark:text-white"> {{ $assignment->title }}
            </div>
            <div class="flex items-center p-px text-sm">
                <span
                    class="relative inline-flex items-center justify-center w-4 h-4 mr-px overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" />
                    </svg>
                </span>
                {{ $assignment->points }} points |
                <span
                    class="relative inline-flex items-center justify-center w-4 h-4 mx-px ml-2 overflow-hidden rounded-full">
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
            <div class="p-px text-xs">
                @if (!$assignment->closed)
                    @if ($assignment->closing)
                        Submission will be closed after due
                    @endif
                @endif
            </div>
            <div>
                <div class="mt-4 text-sm font-bold">Instructions</div>
                @if ($assignment->description == null)
                    <div class="p-px mb-2 text-sm text-gray-500">None</div>
                @else
                    <pre class="p-px mb-2 font-sans text-sm text-wrap">{{ $assignment->description }}</pre>
                @endif
                <div class="mt-2">
                    @foreach ($assignment->assignment_files as $files)
                        <x-file-type-checker :files="$files" :path="asset(
                            'storage/assignments/' .
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
        </div>
        <br>
        <div class="pb-6">
            <div class="flex-row mb-2 space-y-1 items md:flex md:space-x-2 md:space-y-0">
                <div class="flex items-center w-full space-x-1 md:w-1/2">
                    <span class="text-sm">Sort by</span>
                    <select x-model="sort_by" @change="filterRecords"
                        class="w-full flex-1 rounded-md bg-white px-2.5 py-1 text-center text-sm text-black dark:bg-gray-700 dark:text-white">
                        <option value="lname">Surname</option>
                        <option value="fname">First name</option>
                        <option value="turned_in">Turn in status</option>
                        <option value="grade">Grade</option>
                    </select>
                </div>
                <select x-model="sort_direction"
                    class="w-full rounded-md bg-white px-2.5 py-1 text-center text-sm text-black dark:bg-gray-700 dark:text-white md:w-1/2"
                    @change="filterRecords">
                    <option value="desc">Descending</option>
                    <option value="asc">Ascending</option>
                </select>
            </div>
            <div id="accordion-collapse">
                <template x-for="student in filteredRecords " :key="student.id">
                    <div x-data="{ open: false }">
                        <h2 :id="`accordion-collapse-heading-${student.id}`" x-transition>
                            <button type="button" @click="open = !open"
                                :class="open ? 'bg-sky-800 text-white' :
                                    'bg-white dark:bg-gray-700 rounded-b-md text-black dark:text-white'"
                                class="flex items-center justify-between w-full gap-3 p-2 px-3 mt-2 font-medium rounded-t-md hover:bg-sky-700 hover:text-white dark:bg-gray-700">
                                <div>
                                    <div class="mb-1.5 text-start leading-none"
                                        x-text="student.user.lname + ', ' + student.user.fname ">
                                    </div>

                                    <div class="flex items-center justify-start space-x-1"
                                        :id="`grade_status_${student.id}`">
                                        <span
                                            :class="student.enrollee_grades && (student.enrollee_grades.grade != 0 || student
                                                    .enrollee_grades.grade ==
                                                    null) ?
                                                'bg-sky-600' :
                                                'bg-yellow-600'"
                                            class="p-1 px-2 text-xs text-white rounded-full"
                                            x-text="student.enrollee_grades && (student.enrollee_grades.grade != 0 || student
                                                    .enrollee_grades.grade ==
                                                    null) ? 'Graded' : 'Not Graded'">
                                        </span>
                                        <span class="text-sm italic md:hidden"
                                            x-text="student.enrollee_turn_in && student.enrollee_turn_in.turned_in ? 'Turned in' : 'Not turned in'">

                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="hidden text-sm italic me-2 md:block"
                                        x-text="student.enrollee_turn_in && student.enrollee_turn_in.turned_in ? 'Turned in' : 'Not turned in'">

                                    </span>
                                    <svg class="w-3 h-3 shrink-0" :class="!open ? 'rotate-180' : ''"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </div>

                            </button>
                        </h2>
                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-4">
                            <div class="p-3 bg-white rounded-b-md dark:bg-gray-800">
                                <div class="mb-1 text-sm">Links</div>
                                <template
                                    x-if="!student.enrollee_turn_in || student.enrollee_turn_in.turned_in == false || student.enrollee_turn_in.turn_in_links.length == 0">
                                    <div class="text-sm text-gray-500">
                                        None
                                    </div>
                                </template>
                                <template
                                    x-if="student.enrollee_turn_in && student.enrollee_turn_in.turned_in == true">
                                    <div>
                                        <template x-for="link in student.enrollee_turn_in.turn_in_links"
                                            :key="link.id">
                                            <div
                                                class="flex items-center p-2 mb-1 space-x-3 bg-gray-200 rounded-md dark:bg-gray-700 dark:hover:bg-gray-700/75">
                                                <svg class="w-5 h-5" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <title>link-variant</title>
                                                    <path
                                                        d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
                                                </svg>
                                                <a class="w-full" :href="link.link" x-text="link.link"></a>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <div class="mb-2"></div>

                                <div class="mb-1 text-sm">Files</div>
                                <template
                                    x-if="!student.enrollee_turn_in || student.enrollee_turn_in.turned_in == false || student.enrollee_turn_in.turn_in_files.length == 0">
                                    <div class="text-sm text-gray-500">
                                        None
                                    </div>
                                </template>

                                <template
                                    x-if="student.enrollee_turn_in && student.enrollee_turn_in.turned_in == true">
                                    <div>
                                        <template x-for="file in student.enrollee_turn_in.turn_in_files"
                                            :key="file.id">
                                            <div class="mb-1" x-data="{ path: `{{ asset('storage/assignments/') }}/${student.batch_id}/${assignment_id}/${student.id}/${file.folder}/${file.filename}`, 'imageShow': false }">
                                                <x-file-type-checker-alpine></x-file-type-checker-alpine>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <hr class="mt-2 border-t-2 border-gray-600">

                                <div class="flex flex-col items-center mt-2 space-y-3">
                                    {{-- {{ $student }} --}}
                                    <div class="w-full">
                                        <div class="mb-1.5 me-2 text-sm">Remarks:</div>
                                        <textarea required name="remarks" :id="`remarks_${student.id}`" :value="student.enrollee_grades?.remark ?? ''"
                                            rows="4"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Type your remarks"></textarea>
                                    </div>

                                    <div class="w-full">
                                        <div class="mb-1.5 me-2 text-sm">Grade:</div>
                                        <input
                                            class="block w-full p-2 text-sm rounded-lg me-2 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            type="number" :value="student.enrollee_grades?.grade ?? 0"
                                            name="grade" :id="`grade_${student.id}`">
                                    </div>
                                    <div @click="grade_changed(student.id)" class="flex justify-end w-full">
                                        <div
                                            class="flex items-center p-2 space-x-2 rounded-md cursor-pointer bg-sky-800/20 hover:bg-sky-800">
                                            <span>
                                                <svg class="w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d=" M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                                                </svg>
                                            </span>
                                            <span>Save</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </template>
                {{-- @endforeach --}}
            </div>

        </div>
        {{-- Assignment Modal --}}
        <div x-cloak x-show="showAssignmentModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-gray-800 bg-opacity-50">
            <div class="relative w-full max-w-2xl max-h-full p-4">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Update Assignment
                        </h3>
                        <button @click="showAssignmentModal = !showAssignmentModal" type="button"
                            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg ms-auto hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form id="edit_assignment" action="{{ route('post_assignment') }}" method="post"
                        enctype="multipart/form-data" class="p-4 md:p-5">
                        @csrf
                        <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="col-span-2">
                                <label for="time"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    <div class="flex rounded-lg">
                                        <label class="inline-flex items-center w-full cursor-pointer">
                                            <input type="checkbox" id="due_date_toggle" name="set_due"
                                                class="sr-only peer" @change="$('#due_inputs').toggle('hidden')"
                                                :checked="assignment_details.due_date != null ? true : false">
                                            <div
                                                class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600 dark:peer-focus:ring-blue-800">
                                            </div>
                                            <span class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">
                                                Set due</span>
                                        </label>
                                    </div>
                                </label>
                                <div id="due_inputs" x-show="assignment_details.due_date != null"
                                    class="grid grid-cols-2 gap-2">
                                    <div class="relative max-w-sm mb-px">
                                        <div
                                            class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input datepicker datepicker-autohide datepicker-buttons
                                            :value="moment(assignment_details.due_date).format('L')"
                                            datepicker-autoselect-today id="due_date" type="text" name="due_date"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Select date">
                                    </div>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 end-0 top-0 flex items-center pe-3.5">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="time" id="due_time" name="due_hour"
                                            :value="assignment_details.due_hour"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            min="00:00" max="23:59" value="23:59" required />
                                    </div>
                                    <div class="flex items-center col-span-2 text-xs text-white">
                                        <input type="checkbox" :checked="assignment_details.closing"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                            name="closing" id="closing">
                                        <label for="closing" class="ms-2">Close submissions after due
                                            date</label>
                                    </div>
                                </div>

                            </div>

                            <template x-if="course.course.structure != 'small'">
                                <div class="col-span-2">
                                    <template x-if="course.course.structure == 'big'">
                                        <div class="col-span-2">
                                            <label for="uc"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit
                                                of
                                                Competency</label>

                                            <select id="uc" name="uc" required
                                                x-model="assignment_details.unit_of_competency_id"
                                                @change="ucChanged()"
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                                <option value="" selected>Select</option>

                                                <template x-for="uc in course.unit_of_competency"
                                                    :key="uc.id">
                                                    <option :value="uc.id" x-text="uc.title"
                                                        :selected="uc.id === assignment_details.unit_of_competency_id">
                                                    </option>
                                                </template>

                                            </select>

                                        </div>
                                    </template>
                                    <div class="col-span-2">
                                        <label for="lesson"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lesson</label>

                                        <select id="lesson" name="lesson" x-model="assignment_details.lesson_id"
                                            required
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                            <option value="" selected>Select</option>
                                            <template x-for="lesson in selectedUc.lesson" :key="lesson.id">
                                                <option :value="lesson.id" x-text="lesson.title"
                                                    :selected="lesson.id === assignment_details.lesson_id"></option>
                                            </template>
                                        </select>

                                    </div>
                                </div>
                            </template>

                            <div class="col-span-2">
                                <label for="title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                <input type="text" id="title" name="title"
                                    x-model="assignment_details.title"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Title" required />
                            </div>
                            <div class="col-span-2">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea x-model="assignment_details.description" id="description" name="description" rows="2"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Assignment description"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="max_point"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Maximum
                                    Point</label>
                                <input x-model="assignment_details.points" type="number" id="max_point"
                                    name="max_point" required aria-describedby="helper-text-explanation"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Points" required />
                            </div>
                            <div class="text-xs">
                                <a class="flex items-center cursor-pointer" @click="toggleShowAddFile()">Attach
                                    File/s
                                    <svg x-show="showAddFileModal" class="w-4 h-4 ml-2 text-white"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m5 15 7-7 7 7" />
                                    </svg>
                                    <svg x-show="!showAddFileModal" class="w-4 h-4 ml-2 text-gray-800 dark:text-white"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 9-7 7-7-7" />
                                    </svg>
                                </a>
                            </div>

                            <div x-show="showAddFileModal" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95" id="show_addFile_assignment"
                                class="col-span-2">
                                <input type="file" class="filepond assignment_files" id="assignment_files"
                                    name="assignment_files[]" multiple />
                            </div>

                        </div>
                        <div class="flex w-full rounded-md shadow-sm" role="group">
                            <button type="submit"
                                class="flex-1 items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                                <div class="flex justify-center">
                                    Update
                                </div>
                            </button>
                        </div>

                        <div id="schedule_assign"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
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
    </div>

    @section('script')
        <script>
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
                </svg>`;
                } else {
                    icon.innerHTML = `
                <svg class="w-3 h-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>`;
                }
            }

            function turnIns() {
                return {
                    course: @json($batch),
                    maxPoint: {{ $assignment->points }},
                    assignment_id: {{ $assignment->id }},
                    assignment_details: @json($assignment),
                    assignment_files: [],
                    filepond_files: [],
                    sort_by: 'lname',
                    sort_direction: 'dsc',
                    filteredRecords: [], // Store the filtered records
                    students: @json($students),
                    showAssignmentModal: false,
                    showAddFileModal: false,
                    selectedUc: [],
                    init() {
                        this.ucChanged();
                        console.log(this.students);
                        this.students = this.students.map(student => {
                            if (!student.grades || student.grades.length === 0) {
                                student.grades = [{
                                    grade: 0
                                }];
                            }
                            if (!student.turn_ins || student.turn_ins.length === 0) {
                                student.turn_ins = [{
                                    turned_in: 0
                                }];
                            }
                            return student;
                        });
                        this.filteredRecords = this.students; // Initialize with all records

                        var assignmentLesson = this.selectedUc.lesson.find(lesson => lesson.id === this.assignment_details
                            .lesson_id);
                        this.assignment_files = assignmentLesson.assignment.find(assignment => assignment.id === this
                                .assignment_details
                                .id)
                            .assignment_files;

                        if (this.assignment_files) {
                            this.filepond_files = this.assignment_files.map(file => {
                                return {
                                    source: file.id,
                                    options: {
                                        type: 'local',
                                    },
                                }
                            })
                        }

                        if (this.filepond_files.length > 0) {
                            this.toggleShowAddFile();
                        }

                        this.filepond_config();

                    },
                    filterRecords() {
                        let sortedRecords = [...this.students];
                        if (this.sort_by) {
                            sortedRecords.sort((a, b) => {
                                let modifier = this.sort_direction === 'asc' ? 1 : -1;
                                if (this.sort_by === 'turned_in') {
                                    let aTurnedIn = a.enrollee_turn_in ? a.enrollee_turn_in[this.sort_by] : 0;
                                    let bTurnedIn = b.enrollee_turn_in ? b.enrollee_turn_in[this.sort_by] : 0;

                                    if (aTurnedIn < bTurnedIn) return -1 * modifier;
                                    if (aTurnedIn > bTurnedIn) return 1 * modifier;
                                } else if (this.sort_by === 'grade') {
                                    let aGrade = a.enrollee_grades ? a.enrollee_grades.grade : 0;
                                    let bGrade = b.enrollee_grades ? b.enrollee_grades.grade : 0;

                                    if (aGrade < bGrade) return -1 * modifier;
                                    if (aGrade > bGrade) return 1 * modifier;
                                } else {
                                    if (a.user[this.sort_by] < b.user[this.sort_by]) return -1 * modifier;
                                    if (a.user[this.sort_by] > b.user[this.sort_by]) return 1 * modifier;
                                }
                                return 0;
                            });

                            this.filteredRecords = sortedRecords;
                        } else {
                            this.filteredRecords = this.students;
                        }
                        // console.log(sortedRecords);
                    },
                    grade_changed(enrollee_id) {
                        let student = this.students.find(s => s.id === enrollee_id);
                        let remarks = $('#remarks_' + student.id).val();
                        let grade = $('#grade_' + student.id).val();
                        let desc = '';
                        let color = '';
                        const t = this;

                        if (grade > this.maxPoint) {
                            alert('You cannot rate more than maximum point!')
                            // student.grades[0].grade = this.maxPoint
                        } else {

                            fetch('{{ route('update_grade') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        enrollee_id: enrollee_id,
                                        assignment_id: {{ $assignment->id }},
                                        batch_id: {{ $batch->id }},
                                        grade: grade,
                                        remark: remarks,
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status == "success") {
                                        student.enrollee_grades = data.student_grade
                                        t.notification('success', data.trainee.user.fname + ' ' + data.trainee.user.lname,
                                            'Saved Changes')
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        }
                    },
                    getGradeStatus(student) {
                        if (student.grades.grade == 0 || student.grades.grade === null) {
                            return '<span class="p-1 px-2 text-xs bg-yellow-600 rounded-full">Not graded</span>';
                        } else if (student.grades.grade > 0) {
                            return '<span class="p-1 px-2 text-xs rounded-full bg-sky-600">Graded</span>';
                        }
                        return '';
                    },
                    confirmDelete() {
                        var form = event.target.closest('form');

                        Swal.fire({
                            title: "Are you sure?",
                            text: "Warning: All data related to this will also be deleted.",
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
                    closeSubmission() {
                        $.ajax({
                            url: '{{ route('assignment_toggle') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                assignment_id: {{ $assignment->id }}
                            },
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    },
                    triggerModal() {
                        this.showAssignmentModal = true;
                    },
                    ucChanged() {
                        this.selectedUc = this.course.unit_of_competency.find(uc => uc.id == this.assignment_details
                            .unit_of_competency_id)
                    },


                    filepond_config() {
                        const inputElement = document.querySelector('.assignment_files');
                        const pond = FilePond.create(inputElement)
                        FilePond.setOptions({
                            allowMultiple: true,
                            allowReorder: true,
                            files: this.filepond_files,
                            server: {
                                process: {
                                    url: '{{ route('temp_upload_assignment') }}',
                                    ondata: (formData) => {
                                        formData.append('batch_id', '{{ $batch->id }}');
                                        return formData;
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                },
                                load: '/get_uploaded_assignment_files/{{ $assignment->id }}/',
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
                                    fetch(`/delete_uploaded_assignment_file/{{ $assignment->id }}/${source}`, {
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
                    },
                    toggleShowAddFile() {
                        this.showAddFileModal = !this.showAddFileModal;
                    },

                    notification(status, message, title) {
                        toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            preventDuplicates: true,
                            positionClass: "toast-top-right",
                            showDuration: "100",
                            hideDuration: "100",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "slideDown",
                            hideMethod: "slideUp",
                        };
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message,
                            title ?? title);
                    },
                }
            }
        </script>
    @endsection
</x-app-layout>
