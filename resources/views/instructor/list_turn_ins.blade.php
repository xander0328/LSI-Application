<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="md:flex flex-row items-center md:space-x-1 text-2xl font-semibold text-white">
                <div>{{ __('Course') }}</div>
                <div class="hidden md:block text-slate-600">|</div>
                <div class="md:text-lg text-sm leading-none font-normal text-sky-500">{{ $batch->course->name }}</div>
            </div>
            <div class="hidden md:flex items-center">
                <div class="flex space-x-1 mr-4">
                    <div class="text-white/75"> Batch: </div>
                    <div>
                        {{ $batch->course->code }}-{{ $batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex md:hidden items-center">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center p-1  rounded-md hover:bg-gray-900/50">
                            <svg class="h-7 w-7 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>dots-vertical</title>
                                <path
                                    d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="m-1.5 flex flex-col">
                            <div class="my-2 flex justify-center text-xs space-x-1">
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
    <div x-data="turnIns()" class="mx-4 md:mx-8 mt-2 pt-44 md:pt-48 text-white">
        <div class="mb-2 flex items-center justify-end">
            <div class="mx-1 my-1 flex rounded-lg p-2 hover:bg-gray-800">
                <label class="inline-flex w-full cursor-pointer items-center">
                    <input @change="closeSubmission()" type="checkbox"
                        :checked="assignment_details.closed ? true : false" class="assignment-toggle peer sr-only">
                    <div
                        class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-yellow-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-300">Close submissions</span>
                </label>
            </div>
            <button id="dropdownMenuIconHorizontalButton" data-dropdown-toggle="dropdownDotsHorizontal"
                class="my-1 inline-flex items-center rounded-lg bg-white p-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800"
                type="button">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="white"
                    viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                </svg>
            </button>

            <div id="dropdownDotsHorizontal"
                class="z-10 hidden w-52 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-800">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownMenuIconHorizontalButton">
                    <li>
                        <a href="javascript:void(0)" data-action="{{ route('get_assignment', $assignment->id) }}"
                            @click="triggerModal()"
                            class="m-1 flex items-center rounded-lg p-2 py-1 align-middle hover:bg-gray-700">
                            <svg class="h-5 w-6 text-gray-800 dark:text-white" xmlns="http://www.w3.org/2000/svg"
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
                                class="flex w-full items-center rounded-lg p-1 px-2 align-text-bottom hover:bg-gray-700">
                                <svg class="h-5 w-6 text-gray-800 dark:text-white" aria-hidden="true"
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
        <div class="rounded-lg bg-gray-700 p-4">
            <div class="text-2xl font-semibold text-white"> {{ $assignment->title }}
            </div>
            <div class="flex items-center p-px text-sm">
                <span
                    class="relative mr-px inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="white"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" />
                    </svg>
                </span>
                {{ $assignment->points }} points |
                <span
                    class="relative mx-px ml-2 inline-flex h-4 w-4 items-center justify-center overflow-hidden rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
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
                    <div class="mb-2 p-px text-sm text-gray-500">None</div>
                @else
                    <pre class="text-wrap mb-2 p-px font-sans text-sm">{{ $assignment->description }}</pre>
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
            <div class="md:flex flex-row space-y-1 md:space-x-2 md:space-y-0 mb-2 items">
                <div class="flex w-full md:w-1/2 items-center space-x-1">
                    <span class="text-sm">Sort by</span>
                    <select x-model="sort_by" @change="filterRecords"
                        class="flex-1 w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-center text-white">
                        <option value="lname">Surname</option>
                        <option value="fname">First name</option>
                        <option value="turned_in">Turn in status</option>
                        <option value="grade">Grade</option>
                    </select>
                </div>
                <select x-model="sort_direction"
                    class="w-full md:w-1/2 rounded-md bg-gray-700 px-2.5 py-1 text-sm text-center text-white"
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
                                :class="open ? 'bg-sky-800' : 'bg-gray-700 rounded-b-md'"
                                class="mt-2 flex w-full items-center justify-between gap-3 rounded-t-md bg-gray-700 p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white">
                                <div>
                                    <div x-text="student.user.lname + ', ' + student.user.fname "></div>
                                    <div class="flex justify-start" :id="`grade_status_${student.id}`">
                                        <span
                                            :class="student.enrollee_grades && (student.enrollee_grades.grade != 0 || student
                                                    .enrollee_grades.grade ==
                                                    null) ?
                                                'bg-sky-600' :
                                                'bg-yellow-600'"
                                            class="rounded-full p-1 px-2 text-xs"
                                            x-text="student.enrollee_grades && (student.enrollee_grades.grade != 0 || student
                                                    .enrollee_grades.grade ==
                                                    null) ? 'Graded' : 'Not Graded'">
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <span class="me-2 text-sm italic"
                                        x-text="student.enrollee_turn_in && student.enrollee_turn_in.turned_in ? 'Turned in' : 'Not turned in'">

                                    </span>
                                    <svg class="h-3 w-3 shrink-0 " :class="!open ? 'rotate-180' : ''"
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
                            <div class="rounded-b-md bg-gray-800 p-3">
                                <div class="mb-2 text-sm">Submitted Files</div>
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
                                            <div class="mb-2" x-data="{ path: `{{ asset('storage/assignments/') }}/${student.batch_id}/${assignment_id}/${student.id}/${file.folder}/${file.filename}`, 'imageShow': false }">
                                                <x-file-type-checker-alpine></x-file-type-checker-alpine>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <hr class="mt-2 border-t-2 border-gray-600">

                                <div class="mt-2 flex flex-col space-y-3 items-center">
                                    {{-- {{ $student }} --}}
                                    <div class="w-full">
                                        <div class="me-2 text-sm mb-1.5">Remarks:</div>
                                        <textarea required name="remarks" :id="`remarks_${student.id}`" :value="student.enrollee_grades?.remark ?? ''"
                                            rows="4"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Type your remarks"></textarea>
                                    </div>

                                    <div class="w-full">
                                        <div class="me-2 text-sm mb-1.5">Grade:</div>
                                        <input
                                            class="me-2 block w-full rounded-lg p-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            type="number" :value="student.enrollee_grades?.grade ?? 0"
                                            name="grade" :id="`grade_${student.id}`">
                                    </div>
                                    <div @click="grade_changed(student.id)" class="w-full flex justify-end">
                                        <div
                                            class="cursor-pointer rounded-md p-2 hover:bg-sky-800 bg-sky-800/20 flex space-x-2 items-center ">
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
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-2xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Update Assignment
                        </h3>
                        <button @click="showAssignmentModal = !showAssignmentModal" type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
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
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="time"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    <div class="flex rounded-lg">
                                        <label class="inline-flex w-full cursor-pointer items-center">
                                            <input type="checkbox" id="due_date_toggle" name="set_due"
                                                class="peer sr-only" @change="$('#due_inputs').toggle('hidden')"
                                                :checked="assignment_details.due_date != null ? true : false">
                                            <div
                                                class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600 dark:peer-focus:ring-blue-800">
                                            </div>
                                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Set due</span>
                                        </label>
                                    </div>
                                </label>
                                <div id="due_inputs" x-show="assignment_details.due_date != null"
                                    class="grid grid-cols-2 gap-2">
                                    <div class="relative mb-px max-w-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
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
                                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
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
                                    <div class="col-span-2 flex items-center text-xs text-white">
                                        <input type="checkbox" :checked="assignment_details.closing"
                                            class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
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
                                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Unit
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
                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Lesson</label>

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
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                <input type="text" id="title" name="title"
                                    x-model="assignment_details.title"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Title" required />
                            </div>
                            <div class="col-span-2">
                                <label for="description"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea x-model="assignment_details.description" id="description" name="description" rows="2"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Assignment description"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="max_point"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Maximum
                                    Point</label>
                                <input x-model="assignment_details.points" type="number" id="max_point"
                                    name="max_point" required aria-describedby="helper-text-explanation"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Points" required />
                            </div>
                            <div class="text-xs text-white">
                                <a class="flex cursor-pointer items-center" @click="toggleShowAddFile()">Attach
                                    File/s
                                    <svg x-show="showAddFileModal" class="ml-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m5 15 7-7 7 7" />
                                    </svg>
                                    <svg x-show="!showAddFileModal" class="ml-2 h-4 w-4 text-gray-800 dark:text-white"
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
                <svg class="h-3 w-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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
                        console.log(this.assignment_details);
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
                            return '<span class="bg-yellow-600 rounded-full p-1 px-2 text-xs">Not graded</span>';
                        } else if (student.grades.grade > 0) {
                            return '<span class="bg-sky-600 rounded-full p-1 px-2 text-xs">Graded</span>';
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

            // function startFCM() {
            //     messaging
            //         .requestPermission()
            //         .then(function() {
            //             return messaging.getToken()
            //         })
            //         .then(function(response) {
            //             $.ajaxSetup({
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 }
            //             });
            //             $.ajax({
            //                 url: '{{ route('store.token') }}',
            //                 type: 'POST',
            //                 data: {
            //                     token: response
            //                 },
            //                 dataType: 'JSON',
            //                 success: function(response) {
            //                     console.log('Token stored.');
            //                 },
            //                 error: function(error) {
            //                     console.log(error);
            //                 },
            //             });
            //         }).catch(function(error) {
            //             console.log(error);
            //         });
            // }
            // messaging.onMessage(function(payload) {
            //     const title = payload.notification.title;
            //     const options = {
            //         body: payload.notification.body,
            //         icon: payload.notification.icon,
            //     };
            //     new Notification(title, options);
            // });
        </script>
    @endsection
</x-app-layout>
