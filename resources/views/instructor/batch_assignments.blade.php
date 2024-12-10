<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="flex-row items-center text-2xl font-semibold text-sky-950 dark:text-white md:flex md:space-x-1">
                <div>{{ __('Assignment') }}</div>
                <div class="hidden text-slate-600 md:block">|</div>
                <div class="text-sm font-normal leading-none text-sky-500 md:text-lg">{{ $batch->course->name }}</div>
            </div>
            <div class="hidden items-center md:flex">
                <div class="mr-4 flex space-x-1 text-black dark:text-white/75">
                    <div class=""> Batch: </div>
                    <div>
                        {{ $batch->course->code }}-{{ $batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex items-center md:hidden">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md p-1 hover:bg-gray-900/50">
                            <svg class="h-7 w-7 text-black dark:text-white" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <title>dots-vertical</title>
                                <path
                                    d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="m-1.5 flex-row text-black dark:text-white/75">
                            <div class="my-2 flex justify-center space-x-1 text-xs">
                                <div class=""> Batch: </div>
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
    <div x-data="assignmentList" id="course_list" class="mx-4 pb-20 pt-44 text-white md:mx-8 md:pt-48">
        <template x-if="course.structure == 'big'">
            <div>
                <template x-for="uc in uc" :key="uc.id">
                    <div x-data="{ open: false }">
                        <h2 :id="`accordion-collapse-heading-${uc.id}`" x-transition>
                            <button type="button" @click="open = !open"
                                :class="open ? 'bg-sky-800' : 'dark:bg-gray-700 bg-gray-500 '"
                                class="mt-2 flex w-full items-center justify-between gap-3 rounded-b-md rounded-t-md p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white">
                                <div class="flex items-center space-x-2">
                                    <div class="flex items-center">
                                        <span
                                            class="inline-flex h-6 w-6 items-center justify-center rounded-full text-sm font-medium text-white"
                                            :class="open ? 'bg-sky-950' : 'bg-sky-700'" x-text="uc.lesson.length">
                                        </span>
                                    </div>
                                    <div class="text-start" x-text="uc.title"></div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="h-3 w-3 shrink-0" :class="{ 'rotate-180': !open }"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </div>

                            </button>
                        </h2>
                        <div x-show="open" x-transition>
                            <template x-if="uc.lesson.length < 1">
                                <div class="my-2 rounded-md bg-gray-800 p-1.5 text-center text-sm text-white/75">No
                                    Learning Outcome
                                </div>
                            </template>
                            <template x-for="lesson in uc.lesson" :key="lesson.id">
                                <div class="px-2 py-1.5">
                                    <div class="my-1.5 flex items-center space-x-2 rounded-md bg-sky-700 p-1.5">
                                        <div class="flex items-center">
                                            <span
                                                class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-sky-950 text-sm font-medium text-white"
                                                x-text="lesson.assignment.length">
                                            </span>
                                        </div>
                                        <div class="text-md" x-text="lesson.title">

                                        </div>
                                    </div>
                                    <template x-if="lesson.assignment.length < 1">
                                        <div
                                            class="mb-2 rounded-md bg-gray-800 p-1.5 text-center text-sm text-white/75">
                                            No
                                            Assignment
                                        </div>
                                    </template>
                                    <template x-for="assignment in lesson.assignment" :key="assignment.id">
                                        <div class="mb-2 rounded-md bg-white p-px dark:bg-gray-800">
                                            <div class="my-2 w-full rounded-md bg-white px-3 py-px dark:bg-gray-800">
                                                <a :href=`/list_turn_ins/${assignment.id}`
                                                    class="flex items-center justify-between">
                                                    <div class="flex items-center justify-start gap-4">
                                                        <div>
                                                            <div class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full p-2"
                                                                :class="getAssignmentClass(assignment)">
                                                                <svg x-show="getAssignmentClass(assignment) == 'bg-red-700'"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24">
                                                                    <title>book-cancel-outline</title>
                                                                    <path fill="white"
                                                                        d="M12.18 20C12.36 20.72 12.65 21.39 13.04 22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.18C19.5 12.07 19 12 18.5 12C18.33 12 18.17 12 18 12.03V4H13V12L10.5 9.75L8 12V4H6V20H12.18M23 18.5C23 21 21 23 18.5 23S14 21 14 18.5 16 14 18.5 14 23 16 23 18.5M20 21.08L15.92 17C15.65 17.42 15.5 17.94 15.5 18.5C15.5 20.16 16.84 21.5 18.5 21.5C19.06 21.5 19.58 21.35 20 21.08M21.5 18.5C21.5 16.84 20.16 15.5 18.5 15.5C17.94 15.5 17.42 15.65 17 15.92L21.08 20C21.35 19.58 21.5 19.06 21.5 18.5Z" />
                                                                </svg>
                                                                <svg x-show="getAssignmentClass(assignment) == 'bg-sky-700' || getAssignmentClass(assignment) == 'bg-yellow-700' "
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24">
                                                                    <title>book-clock-outline</title>
                                                                    <path fill="white"
                                                                        d="M20 11.26V4C20 2.9 19.11 2 18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H11.11C12.37 23.24 14.09 24 16 24C19.87 24 23 20.87 23 17C23 14.62 21.81 12.53 20 11.26M18 4V10.29C17.37 10.11 16.7 10 16 10C14.93 10 13.91 10.25 13 10.68V4H18M6 4H8V12L10.5 9.75L12.1 11.19C10.23 12.45 9 14.58 9 17C9 18.08 9.25 19.09 9.68 20H6V4M16 22C13.24 22 11 19.76 11 17S13.24 12 16 12 21 14.24 21 17 18.76 22 16 22M16.5 17.25L19.36 18.94L18.61 20.16L15 18V13H16.5V17.25Z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="w-full font-medium text-black/75 dark:text-white">
                                                            <div x-text="assignment.title"></div>
                                                            {{-- <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ mb_strimwidth($assignment->description, 0, 70, '...') }}
                                                            </div> --}}
                                                            <div class="text-sm text-gray-700 dark:text-gray-500 sm:hidden"
                                                                x-text="assignment.due_date != null ? 'Due ' + moment(assignment.formattedDue).calendar(): 'No due'">
                                                            </div>
                                                            <template x-if="assignment.closing">
                                                                <div class="sm:hidden">
                                                                    <span
                                                                        class="rounded bg-red-700 px-2 text-xs text-white">
                                                                        Closing
                                                                    </span>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <div class="hidden sm:block">
                                                        <div class="text-sm text-gray-700 dark:text-gray-500"
                                                            x-text="assignment.due_date != null ? 'Due ' + moment(assignment.due_date).format('ll'): 'No due'">
                                                        </div>
                                                        <template x-if="assignment.closing">
                                                            <div class="text-end">
                                                                <span
                                                                    class="rounded bg-red-700 px-2 text-xs text-white">
                                                                    Closing
                                                                </span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </a>

                                            </div>

                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
                <template x-if="uc.length < 1">
                    <div class="bg-gray-700/35 mt-2.5 rounded-md p-2.5 text-center text-sm text-gray-300">No Assignment
                    </div>
                </template>
            </div>

        </template>
        <template x-if="course.structure == 'medium'">
            <div>
                <template x-if="uc != null && uc[0].lesson.length > 0">
                    <template x-for="lesson in uc[0].lesson" :key="lesson.id">
                        <div x-data="{ open: false }">
                            <h2 :id="`accordion-collapse-heading-${uc.id}`" x-transition>
                                <button type="button" @click="open = !open"
                                    :class="open ? 'bg-sky-800' : 'bg-gray-700 '"
                                    class="mt-2 flex w-full items-center justify-between gap-3 rounded-b-md rounded-t-md bg-gray-700 p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white"
                                    :data-accordion-target="`#accordion-collapse-body-${uc.id}`" aria-expanded="false"
                                    :aria-controls="`accordion-collapse-body-${uc.id}`">
                                    <div>
                                        <div x-text="lesson.title"></div>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="h-3 w-3 shrink-0 rotate-180" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </div>

                                </button>
                            </h2>
                            <div x-show="open" x-transition>
                                <template x-if="lesson.assignment.length < 1">
                                    <div
                                        class="mx-1 my-2 rounded-md bg-gray-800 p-1.5 text-center text-sm text-white/75">
                                        No
                                        Assignment
                                    </div>
                                </template>
                                <template x-for="assignment in lesson.assignment" :key="assignment.id">
                                    <div class="mx-1 my-2 rounded-md bg-gray-800 p-px">
                                        <div class="my-2 w-full rounded-md bg-gray-800 px-3 py-px">
                                            <a :href=`/list_turn_ins/${assignment.id}`
                                                class="flex items-center justify-between">
                                                <div class="flex items-center justify-start gap-4">
                                                    <div>
                                                        <div class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full p-2"
                                                            :class="{
                                                                'bg-sky-700': !assignment.closed,
                                                                'bg-red-700': assignment.closed || (moment(assignment
                                                                            .due_date +" "+ assignment.due_hour).format() < moment()
                                                                    .format()),
                                                            }">
                                                            <svg x-show="assignment.closed"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>book-cancel-outline</title>
                                                                <path fill="white"
                                                                    d="M12.18 20C12.36 20.72 12.65 21.39 13.04 22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.18C19.5 12.07 19 12 18.5 12C18.33 12 18.17 12 18 12.03V4H13V12L10.5 9.75L8 12V4H6V20H12.18M23 18.5C23 21 21 23 18.5 23S14 21 14 18.5 16 14 18.5 14 23 16 23 18.5M20 21.08L15.92 17C15.65 17.42 15.5 17.94 15.5 18.5C15.5 20.16 16.84 21.5 18.5 21.5C19.06 21.5 19.58 21.35 20 21.08M21.5 18.5C21.5 16.84 20.16 15.5 18.5 15.5C17.94 15.5 17.42 15.65 17 15.92L21.08 20C21.35 19.58 21.5 19.06 21.5 18.5Z" />
                                                            </svg>
                                                            <svg x-show="!assignment.closed"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>book-clock-outline</title>
                                                                <path fill="white"
                                                                    d="M20 11.26V4C20 2.9 19.11 2 18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H11.11C12.37 23.24 14.09 24 16 24C19.87 24 23 20.87 23 17C23 14.62 21.81 12.53 20 11.26M18 4V10.29C17.37 10.11 16.7 10 16 10C14.93 10 13.91 10.25 13 10.68V4H18M6 4H8V12L10.5 9.75L12.1 11.19C10.23 12.45 9 14.58 9 17C9 18.08 9.25 19.09 9.68 20H6V4M16 22C13.24 22 11 19.76 11 17S13.24 12 16 12 21 14.24 21 17 18.76 22 16 22M16.5 17.25L19.36 18.94L18.61 20.16L15 18V13H16.5V17.25Z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="w-full font-medium dark:text-white">
                                                        <div x-text="assignment.title"></div>
                                                        {{-- <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ mb_strimwidth($assignment->description, 0, 70, '...') }}
                                                                </div> --}}
                                                    </div>
                                                </div>
                                                <div class="text-sm text-gray-500"
                                                    x-text=" assignment.due_date != null ? 'Due ' + moment(assignment.due_date).format('ll') : 'No due'">
                                                </div>
                                            </a>

                                        </div>

                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                </template>
                <template x-if="uc == null || uc[0].lesson.length < 1">
                    <div class="bg-gray-700/35 mt-2.5 rounded-md p-2.5 text-center text-sm text-gray-300">No Assignment
                    </div>
                </template>
            </div>
        </template>
        <template x-if="course.structure == 'small'">
            <template x-for="lesson in uc[0].lesson" :key="lesson.id">
                <div>
                    <template x-for="assignment in lesson.assignment" :key="assignment.id">
                        <div class="my-2 rounded-md bg-gray-800 p-px">
                            <div class="my-2 w-full rounded-md bg-gray-800 px-3 py-px">
                                <a :href=`/list_turn_ins/${assignment.id}` class="flex items-center justify-between">
                                    <div class="flex items-center justify-start gap-4">
                                        <div>
                                            <div class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full p-2"
                                                :class="{
                                                    'bg-sky-700': !assignment.closed,
                                                    'bg-red-700': assignment.closed || (moment(assignment
                                                                .due_date +" "+ assignment.due_hour).format() < moment()
                                                    .format()),
                                            }">
                                                <svg x-show="assignment.closed" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <title>book-cancel-outline</title>
                                                    <path fill="white"
                                                        d="M12.18 20C12.36 20.72 12.65 21.39 13.04 22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.18C19.5 12.07 19 12 18.5 12C18.33 12 18.17 12 18 12.03V4H13V12L10.5 9.75L8 12V4H6V20H12.18M23 18.5C23 21 21 23 18.5 23S14 21 14 18.5 16 14 18.5 14 23 16 23 18.5M20 21.08L15.92 17C15.65 17.42 15.5 17.94 15.5 18.5C15.5 20.16 16.84 21.5 18.5 21.5C19.06 21.5 19.58 21.35 20 21.08M21.5 18.5C21.5 16.84 20.16 15.5 18.5 15.5C17.94 15.5 17.42 15.65 17 15.92L21.08 20C21.35 19.58 21.5 19.06 21.5 18.5Z" />
                                                </svg>
                                                <svg x-show="!assignment.closed" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <title>book-clock-outline</title>
                                                    <path fill="white"
                                                        d="M20 11.26V4C20 2.9 19.11 2 18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H11.11C12.37 23.24 14.09 24 16 24C19.87 24 23 20.87 23 17C23 14.62 21.81 12.53 20 11.26M18 4V10.29C17.37 10.11 16.7 10 16 10C14.93 10 13.91 10.25 13 10.68V4H18M6 4H8V12L10.5 9.75L12.1 11.19C10.23 12.45 9 14.58 9 17C9 18.08 9.25 19.09 9.68 20H6V4M16 22C13.24 22 11 19.76 11 17S13.24 12 16 12 21 14.24 21 17 18.76 22 16 22M16.5 17.25L19.36 18.94L18.61 20.16L15 18V13H16.5V17.25Z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="w-full font-medium dark:text-white">
                                            <div x-text="assignment.title"></div>
                                            {{-- <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ mb_strimwidth($assignment->description, 0, 70, '...') }}
                                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500"
                                        x-text=" assignment.due_date != null ? 'Due ' + moment(assignment.due_date).format('ll') : 'No due'">
                                    </div>
                                </a>

                            </div>

                        </div>
                    </template>
                    <template x-if="lesson.assignment.length < 1">
                        <div class="bg-gray-700/35 mt-2.5 rounded-md p-2.5 text-center text-sm text-gray-300">No
                            Assignment
                        </div>
                    </template>
                </div>
            </template>
        </template>

        {{-- Create Assignment Modal --}}
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
                            Create New Assignment
                        </h3>
                        <button type="button" @click="showAssignmentModal = !showAssignmentModal"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form id="post_assignment" action="{{ route('post_assignment') }}" method="post"
                        enctype="multipart/form-data" class="p-4 md:p-5">
                        @csrf
                        <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                        <div x-data="{ showAddFile: false }" class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="time"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    <div class="flex rounded-lg">
                                        <label class="inline-flex w-full cursor-pointer items-center">
                                            <input @change="dueDateToggle()" name="set_due" type="checkbox"
                                                id="due_date_toggle" class="peer sr-only">
                                            <div
                                                class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600 dark:peer-focus:ring-blue-800">
                                            </div>
                                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                Set due</span>
                                        </label>
                                    </div>
                                </label>
                                <div id="due_inputs" class="grid hidden grid-cols-2 gap-2">
                                    <div class="relative mb-px max-w-sm">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input datepicker datepicker-autohide datepicker-buttons
                                            datepicker-autoselect-today id="due_date" type="text"
                                            @change="dueDateChanged" name="due_date" autocomplete="off"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Select date">
                                    </div>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 end-0 top-0 flex items-center pe-3.5">
                                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="time" id="due_time" name="due_hour"
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm leading-none text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            min="00:00" max="23:59" value="23:59" required />
                                    </div>
                                    <div class="col-span-2 flex items-center text-xs text-white">
                                        <input type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                            name="closing" id="closing">
                                        <label for="closing" class="ms-2 text-black dark:text-white">Close
                                            submissions after due
                                            date</label>
                                    </div>
                                </div>

                            </div>
                            <template x-if="course.structure != 'small'">
                                <div class="col-span-2">
                                    <template x-if="course.structure != 'medium'">
                                        <div class="col-span-2">
                                            <label for="uc"
                                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Unit
                                                of
                                                Competency</label>

                                            <select id="uc" name="uc" required x-model="selectedAssUc"
                                                @change="ucChanged()"
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                                <option value="" selected>Select</option>

                                                <template x-for="uc in uc" :key="uc.id">
                                                    <option :value="uc.id" x-text="uc.title"></option>
                                                </template>

                                            </select>

                                        </div>
                                    </template>
                                    <div class="col-span-2">
                                        <label for="lesson"
                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Learning
                                            Outcome</label>

                                        <select id="lesson" name="lesson" required
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                            <option value="" selected>Select</option>

                                            <template x-for="lesson in lessonOptions.lesson" :key="lesson.id">
                                                <option :value="lesson.id" x-text="lesson.title"></option>
                                            </template>

                                        </select>

                                    </div>
                                </div>
                            </template>
                            <div class="col-span-2">
                                <label for="title"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                <input type="text" id="title" name="title"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Title" required />
                            </div>
                            <div class="col-span-2">
                                <label for="description"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="description" name="description" rows="2"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Assignment description"></textarea>
                            </div>
                            <div class="col-span-2">
                                <label for="max_point"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Maximum
                                    Point</label>
                                <input type="number" name="max_point" required
                                    aria-describedby="helper-text-explanation"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Points" required />
                            </div>
                            <div x-data="{ open: false }" class="text-xs text-black dark:text-white">
                                <a class="flex cursor-pointer items-center"
                                    @click="open = !open; showAddFile = !showAddFile">Attach File/s<svg
                                        id="icon_assignment" :class="{ 'rotate-180': open }"
                                        class="ml-px h-4 w-4 text-black dark:text-white"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 9-7 7-7-7" />
                                    </svg>
                                </a>
                            </div>

                            <div id="show_addFile_assignment" :class="{ 'hidden': !showAddFile }"
                                class="col-span-2 hidden">
                                {{-- <label for="name"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Attach
                                File/s</label> --}}
                                {{-- <input
                                class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                type="file" name="file[]" accept=".jpg, .png, .xlsx, .docx, .txt" multiple> --}}
                                <input type="file" class="filepond assignment_files" name="assignment_files[]"
                                    multiple />
                            </div>

                        </div>
                        <div class="flex w-full rounded-md shadow-sm" role="group">
                            <button type="submit"
                                class="flex-1 items-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">

                                <div class="flex justify-center">
                                    Assign
                                </div>
                            </button>
                            {{-- <button data-dropdown-toggle="schedule_assign"
                            class="flex-none items-center bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            <svg class="h-4 w-4 text-gray-800 dark:text-white"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 9-7 7-7-7" />
                            </svg>

                        </button> --}}
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

        <!-- Dropdown menu -->
        <div id="dropdown"
            class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a
                        class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Post</a>
                </li>
                {{-- <li>
                    <a data-modal-target="create-assignment-modal" data-modal-toggle="create-assignment-modal"
                    class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Assignment</a>
                </li>
                <li>
            <a data-modal-target="add_lesson_modal" data-modal-toggle="add_lesson_modal"
            class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lesson</a>
        </li> --}}
            </ul>
        </div>

        {{-- List of Lesson Modal --}}
        <div x-cloak x-show="showLessonModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Learning Outcome
                        </h3>
                        <button type="button" @click="showLessonModal = !showLessonModal"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">

                                <div class="text-white">
                                    <template x-if="course.structure == 'big'">
                                        <div id="">
                                            <template x-for="uc in uc" :key="uc.id">
                                                <div>
                                                    <div
                                                        class="my-2 flex items-center justify-between bg-gradient-to-r from-sky-400 p-1.5 text-black dark:from-sky-700 dark:text-white">
                                                        <span x-text="uc.title"></span>
                                                        <button @click="addLesson(uc.id)"
                                                            class="rounded-md p-2 hover:bg-sky-400 dark:hover:bg-sky-700">
                                                            <svg class="h-4 w-4 text-black dark:text-white"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <template x-if="uc.lesson.length < 1">
                                                        <div class="p-2 text-sm text-gray-400">No learning outcome
                                                        </div>
                                                    </template>

                                                    <template x-for="lesson in uc.lesson" :key="lesson.id">
                                                        <div
                                                            class="flex items-center justify-between rounded-md bg-white p-2 text-sm text-black hover:bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800/75">
                                                            <span x-text="lesson.title"></span>
                                                            <div class="flex">
                                                                <button @click="editModal('lesson', uc.id, lesson.id)"
                                                                    class="me-1 h-7 w-7 rounded-md p-1 text-black hover:bg-gray-600/50 dark:text-white">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <title>Edit</title>
                                                                        <path fill="currentColor"
                                                                            d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                                    </svg>
                                                                </button>
                                                                <form action="{{ route('delete_lesson') }}"
                                                                    class="h-7 w-7 rounded-md p-1 hover:bg-gray-600/50"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="lesson_id"
                                                                        :value="lesson.id">

                                                                    <button @click.prevent="confirmDelete()"
                                                                        class="h-full w-full text-black dark:text-white"
                                                                        type="button">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24">
                                                                            <title>Delete</title>
                                                                            <path fill="currentColor"
                                                                                d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                                        </svg></button>
                                                                </form>
                                                            </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="uc.length < 1">
                                                <div class="p-2 text-center text-sm text-gray-400">
                                                    No learning outcomes yet. Create a unit of competency first before
                                                    adding a
                                                    learning outcome.
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="course.structure == 'medium'">
                                        <div>
                                            <div>
                                                <button
                                                    @click="showAddLesson = !showAddLesson; showLessonModal = !showLessonModal"
                                                    class="mb-1.5 w-full rounded-md bg-sky-700 p-2 text-sm hover:bg-sky-800">Add
                                                    Learning Outcome</button>
                                            </div>
                                            <template x-if="lesson.length > 0">
                                                <template x-for="lesson in lesson" :key="lesson.id">
                                                    <div
                                                        class="flex items-center justify-between rounded-md bg-gray-700 p-2 text-sm hover:bg-gray-800/75">
                                                        <span x-text="lesson.title"></span>
                                                        <div class="flex">
                                                            <button @click="editModal('lesson', uc.id, lesson.id)"
                                                                class="me-1 h-7 w-7 rounded-md p-1 hover:bg-gray-600">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24">
                                                                    <title>Edit</title>
                                                                    <path fill="white"
                                                                        d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                                </svg>
                                                            </button>
                                                            <form action="{{ route('delete_lesson') }}"
                                                                class="h-7 w-7 rounded-md p-1 hover:bg-gray-600"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="lesson_id"
                                                                    :value="lesson.id">

                                                                <button @click.prevent="confirmDelete()"
                                                                    class="h-full w-full" type="button">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <title>Delete</title>
                                                                        <path fill="white"
                                                                            d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                                    </svg></button>
                                                            </form>
                                                        </div>
                                                </template>
                                            </template>
                                            <template x-if="lesson.length < 1">
                                                <div class="p-2 text-center text-sm text-gray-400">
                                                    No learning outcomes
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- List of UC Modal --}}
        <div x-cloak x-show="showUCModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Unit of Competencies
                        </h3>
                        <button type="button" @click="showUCModal = !showUCModal"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">

                                <div class="text-white">
                                    <div>
                                        <button @click="showAddUc = !showAddUc; showUCModal = !showUCModal"
                                            class="mb-1.5 w-full rounded-md bg-sky-700 p-2 text-sm hover:bg-sky-800">Add
                                            Unit of
                                            Competency</button>
                                    </div>
                                    <div id="list_uc">
                                        <template x-if="uc.length < 1">
                                            <div class="p-2 text-center text-sm text-gray-400">No Unit of Competency
                                            </div>
                                        </template>

                                        <template x-for="uc in uc" :key="uc.id">
                                            <div
                                                class="flex items-center justify-between rounded-md bg-white p-2 text-sm text-black hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-800/75">
                                                <span x-text="uc.title"></span>
                                                <div class="flex">
                                                    <button @click="editModal('uc', uc.id, '')"
                                                        class="me-1 h-7 w-7 rounded-md p-1 text-black hover:bg-gray-600 dark:text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>Edit</title>
                                                            <path fill="currentColor"
                                                                d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('delete_uc') }}"
                                                        class="h-7 w-7 rounded-md p-1 text-black hover:bg-gray-600 dark:text-white"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="uc_id" :value="uc.id">

                                                        <button @click.prevent="confirmDelete()" class="h-full w-full"
                                                            type="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>Delete</title>
                                                                <path fill="currentColor"
                                                                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                            </svg></button>
                                                    </form>
                                                </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Lesson Modal --}}
        <div x-cloak x-show="showEditLesson" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Learning Outcome
                        </h3>
                        <button type="button"
                            @click="showEditLesson = !showEditLesson; showLessonModal = !showLessonModal"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <form action="{{ route('edit_lesson') }}" method="post">
                                    <div class="mb-2 block text-sm font-medium text-black dark:text-white">Current
                                        name: <span class="font-bold" x-text="selectedLesson.title"></span></div>
                                    <label for="lesson"
                                        class="mb-2 block text-sm font-medium text-black dark:text-white">Change
                                        to:</label>
                                    <div class="grid grid-cols-9">
                                        @csrf
                                        <input type="hidden" name="lesson_id" :value="selectedLesson.id">
                                        <div class="col-span-8">
                                            <input type="text" id="new_lesson_name" name="new_lesson_name"
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                                placeholder="New Learning Outcome Title" :value="selectedLesson.title"
                                                required />
                                        </div>
                                        <button @click.prevent="saveEdit('lesson')" type="button"
                                            class="ms-2 flex w-full items-center justify-center rounded-md bg-sky-700 p-2 px-3"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit UC Modal --}}
        <div x-cloak x-show="showEditUc" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Unit of Competency Name
                        </h3>
                        <button type="button" @click="showEditUc = !showEditUc; showUCModal = !showUCModal"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <form action="{{ route('edit_uc') }}" method="post">
                                    <div class="mb-2 block text-sm font-medium text-black dark:text-white">Current
                                        name: <span class="font-bold" x-text="selectedUc.title"></span></div>
                                    <label for="lesson"
                                        class="mb-2 block text-sm font-medium text-black dark:text-white">Change
                                        to:</label>
                                    <div class="grid grid-cols-9">
                                        @csrf
                                        <input type="hidden" name="uc_id" :value="selectedUc.id">
                                        <div class="col-span-8">
                                            <input type="text" id="new_uc_title" name="new_uc_title"
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                                placeholder="New Unit of Competency Title" :value="selectedUc.title"
                                                required />
                                        </div>
                                        <button @click.prevent="saveEdit('uc')" type="button"
                                            class="ms-2 flex w-full items-center justify-center rounded-md bg-sky-700 p-2 px-3"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add Lesson Modal --}}
        <div x-cloak x-show="showAddLesson" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700 bg-white">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Add Learning Outcome
                        </h3>
                        <button type="button"
                            @click="showAddLesson = !showAddLesson; showLessonModal = !showLessonModal"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <form action="{{ route('add_lesson') }}" method="post">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="batch_id" :value="batch.id">
                                        <input type="hidden" name="uc_id" :value="selectedUc.id">
                                        <input autocomplete="on" list="options" id="lesson_title"
                                            name="lesson_title"
                                            class="mb-2 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Learning Outcome Title" required />
                                        <datalist id="options">
                                            <template x-for="lesson in all_lessons" :key="lesson">
                                                <option :value="lesson"></option>
                                            </template>
                                            <!-- Add more options as needed -->
                                        </datalist>

                                        <button type="submit"
                                            class="flex w-full items-center justify-center rounded-md bg-sky-700 p-2 px-3 text-sm">
                                            <svg class="-ms-1 me-1 h-4 w-4" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <title>check-circle-outline</title>
                                                <path
                                                    d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M12 20C7.59 20 4 16.41 4 12S7.59 4 12 4 20 7.59 20 12 16.41 20 12 20M16.59 7.58L10 14.17L7.41 11.59L6 13L10 17L18 9L16.59 7.58Z" />
                                            </svg>
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Add UC Modal --}}
        <div x-cloak x-show="showAddUc" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700 bg-white">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Add Unit of Competency
                        </h3>
                        <button type="button" @click="showAddUc = !showAddUc; showUCModal = !showUCModal"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <form action="{{ route('add_uc') }}" method="post">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                                        <input autocomplete="on" list="options_uc_title" id="uc_title"
                                            name="uc_title"
                                            class="mb-2 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Unit of Competency Title" required />
                                        <datalist id="options_uc_title">
                                            <template x-for="uc in all_ucs" :key="uc">
                                                <option :value="uc"></option>
                                            </template>
                                        </datalist>

                                        <button type="submit"
                                            class="flex w-full items-center justify-center rounded-md bg-sky-700 p-2 px-3 text-sm">
                                            <svg class="-ms-1 me-1 h-4 w-4" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <title>check-circle-outline</title>
                                                <path
                                                    d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M12 20C7.59 20 4 16.41 4 12S7.59 4 12 4 20 7.59 20 12 16.41 20 12 20M16.59 7.58L10 14.17L7.41 11.59L6 13L10 17L18 9L16.59 7.58Z" />
                                            </svg>
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Speed Dial --}}
        <template x-if="batch.completed_at == null">
            <div data-dial-init class="group fixed bottom-6 end-6">
                <div id="speed-dial-menu-text-outside-button-square"
                    class="mb-4 flex hidden flex-col items-center space-y-2">

                    <button type="button" @click="triggerModal('assignment')"
                        class="relative h-[52px] w-[52px] rounded-md border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                        <svg class="mx-auto h-5 w-5" aria-hidden="true" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M21 10V9L15 3H5C3.89 3 3 3.89 3 5V19C3 20.11 3.9 21 5 21H11V19.13L19.39 10.74C19.83 10.3 20.39 10.06 21 10M14 4.5L19.5 10H14V4.5M22.85 14.19L21.87 15.17L19.83 13.13L20.81 12.15C21 11.95 21.33 11.95 21.53 12.15L22.85 13.47C23.05 13.67 23.05 14 22.85 14.19M19.13 13.83L21.17 15.87L15.04 22H13V19.96L19.13 13.83Z" />
                        </svg>
                        <span
                            class="absolute -start-24 top-1/2 mb-px block -translate-y-1/2 text-start text-sm font-medium">Assignment</span>
                    </button>

                    <template x-if="course.structure != 'small'">
                        <button type="button" @click="triggerModal('lesson')"
                            class="relative h-[52px] w-[52px] rounded-md bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                            <svg class="mx-auto h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <title>book-education</title>
                                <path
                                    d="M8.82 17L13 19.28V22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H7V9L9.5 7.5L12 9V2H18C19.1 2 20 2.89 20 4V12.54L18.5 11.72L8.82 17M24 17L18.5 14L13 17L18.5 20L24 17M15 19.09V21.09L18.5 23L22 21.09V19.09L18.5 21L15 19.09Z" />
                            </svg>
                            <span
                                class="absolute -start-24 top-1/2 mb-px block -translate-y-1/2 text-start text-sm font-medium">
                                <div>Learning</div>
                                <div> Outcome</div>
                            </span>
                        </button>
                    </template>

                    <template x-if="course.structure != 'small' && course.structure != 'medium'">
                        <button type="button" @click="triggerModal('uc')"
                            class="relative h-[52px] w-[52px] rounded-md bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                            <svg class="mx-auto h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 18 20">
                                <path
                                    d="M5 9V4.13a2.96 2.96 0 0 0-1.293.749L.879 7.707A2.96 2.96 0 0 0 .13 9H5Zm11.066-9H9.829a2.98 2.98 0 0 0-2.122.879L7 1.584A.987.987 0 0 0 6.766 2h4.3A3.972 3.972 0 0 1 15 6v10h1.066A1.97 1.97 0 0 0 18 14V2a1.97 1.97 0 0 0-1.934-2Z" />
                                <path
                                    d="M11.066 4H7v5a2 2 0 0 1-2 2H0v7a1.969 1.969 0 0 0 1.933 2h9.133A1.97 1.97 0 0 0 13 18V6a1.97 1.97 0 0 0-1.934-2Z" />
                            </svg>
                            <span
                                class="absolute -start-24 top-1/2 mb-px block -translate-y-1/2 text-start text-sm font-medium">
                                <div>Unit of</div>
                                <div>
                                    Competency
                                </div>
                            </span>
                        </button>
                    </template>

                    <button type="button"
                        @click="window.location.href = '{{ route('export_grades', ':id') }}'.replace(':id', batch.id) "
                        class="relative h-[52px] w-[52px] rounded-md bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                        <svg class="mx-auto h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 18 20">
                            <path
                                d="M5 9V4.13a2.96 2.96 0 0 0-1.293.749L.879 7.707A2.96 2.96 0 0 0 .13 9H5Zm11.066-9H9.829a2.98 2.98 0 0 0-2.122.879L7 1.584A.987.987 0 0 0 6.766 2h4.3A3.972 3.972 0 0 1 15 6v10h1.066A1.97 1.97 0 0 0 18 14V2a1.97 1.97 0 0 0-1.934-2Z" />
                            <path
                                d="M11.066 4H7v5a2 2 0 0 1-2 2H0v7a1.969 1.969 0 0 0 1.933 2h9.133A1.97 1.97 0 0 0 13 18V6a1.97 1.97 0 0 0-1.934-2Z" />
                        </svg>
                        <span
                            class="absolute -start-24 top-1/2 mb-px block -translate-y-1/2 text-start text-sm font-medium">
                            <div>Export</div>
                            <div>
                                Records
                            </div>
                        </span>
                    </button>
                </div>
                <button type="button" data-dial-toggle="speed-dial-menu-text-outside-button-square"
                    aria-controls="speed-dial-menu-text-outside-button-square" aria-expanded="false"
                    class="flex h-14 w-14 items-center justify-center rounded-md bg-blue-700 text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="h-5 w-5 transition-transform group-hover:rotate-45" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                    <span class="sr-only">Open actions menu</span>
                </button>
            </div>
        </template>

    </div>
    </div>

    {{-- Add UC Modal --}}
    </div>

    @section('script')
        <script>
            function assignmentList() {
                return {
                    batch: @json($batch),
                    uc: @json($batch['unit_of_competency']) ?? [],
                    lesson: @json(isset($batch->unit_of_competency[0]['lesson']) ? $batch->unit_of_competency[0]['lesson'] : []),
                    all_lessons: @json($all_lessons),
                    all_ucs: @json($all_ucs),
                    course: @json($batch['course']),
                    assignments: @json($assignments),
                    lessons: '',
                    competencies: '',
                    // Assignment
                    selectedAssUc: '',
                    lessonOptions: '',

                    // Modals
                    showAssignmentModal: false,
                    showLessonModal: false,
                    showUCModal: false,
                    showEditLesson: false,
                    showEditUc: false,
                    showAddLesson: false,
                    showAddUc: false,
                    selectedUc: [],
                    selectedLesson: [],

                    assignmentFiles: @json($temp_files),
                    filepondFiles: [],
                    init() {
                        console.log(this.assignments)
                        this.assignments.forEach(function(ass) {
                            console.log(!ass.closed && moment(ass.formattedDue).isSameOrAfter(moment()), )
                        })

                        if (this.assignmentFiles) {
                            this.filepondFiles = this.assignmentFiles.map(file => {
                                return {
                                    source: file.id,
                                    options: {
                                        type: 'local',
                                    },
                                }
                            })
                        }

                        // this.filepondFiles =
                        @if (session('status'))
                            this.notification("{{ session('status') }}", "{{ session('message') }}",
                                "{{ session('title') ?? session('title') }}");
                        @endif

                        this.filepondConfig();
                    },
                    triggerModal(type) {
                        if (type === "assignment") {
                            if (this.course.structure == 'medium') {
                                this.lessonOptions = this.uc[0]
                            }

                            this.showAssignmentModal = true;

                        } else if (type === "lesson") {
                            this.showLessonModal = true;
                        } else {
                            this.showUCModal = true;
                        }
                    },
                    editModal(type, ucId, lessonId) {
                        if (type == 'lesson') {
                            this.showEditLesson = !this.showEditLesson
                            this.showLessonModal = !this.showLessonModal
                            // console.log(this.uc[0]);

                            if (this.course.structure == 'big') {
                                this.selectedLesson = this.uc.lesson.find(lesson => lesson.id === lessonId)
                            } else {
                                this.selectedLesson = this.uc[0].lesson.find(lesson => lesson.id === lessonId)
                            }
                        } else if (type == 'uc') {
                            this.showEditUc = !this.showEditUc
                            this.showUCModal = !this.showUCModal

                            this.selectedUc = this.uc
                        }
                    },
                    dueDateChanged(date) {
                        console.log(date);
                        var today = new Date();
                        today.setHours(0, 0, 0, 0);

                        if (Date(date) < today) {
                            alert('The selected date cannot be less than today.');
                            $(this).val('');
                        }
                    },
                    confirmDelete() {
                        var form = event.target.closest('form');

                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this! All data related to this will also be deleted.",
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
                    saveEdit(type) {
                        if (type === 'lesson') {
                            var new_lesson_name = $('#new_lesson_name').val().trim()
                            var form = event.target.closest('form');

                            if (new_lesson_name === this.selectedLesson.title) {
                                this.notification('error', 'Please input a different name to proceed updating a lesson',
                                    'Change Lesson Name')
                            } else {
                                form.submit();
                            }
                        } else if ('uc') {
                            var new_uc_title = $('#new_uc_title').val().trim()
                            var form = event.target.closest('form');

                            if (new_uc_title === this.selectedUc.title) {
                                this.notification('error',
                                    'Please input a different name to proceed updating a unit of competency',
                                    'Change Unit of Competency Title')
                            } else {
                                form.submit();
                            }
                        }
                    },
                    addLesson(ucId) {
                        this.showAddLesson = true;
                        this.showLessonModal = !this.showLessonModal
                        // this.selectedUc = this.uc.find(uc => uc.id === ucId);
                        this.selectedUc = this.uc;
                    },
                    ucChanged() {
                        this.lessonOptions = this.uc.find(uc => uc.id == this.selectedAssUc);
                        console.log(this.lessonOptions);
                    },

                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message,
                            title ?? title);
                        toastr.options.closeButton = true;
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "showDuration": "300",
                            "hideDuration": "800",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    },

                    filepondConfig() {
                        FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginGetFile);
                        const inputElement = document.querySelector('.assignment_files');
                        const pond = FilePond.create(inputElement)
                        FilePond.setOptions({
                            allowMultiple: true,
                            allowReorder: true,
                            allowImagePreview: true,
                            files: this.filepondFiles,
                            server: {
                                process: {
                                    url: '{{ route('temp_upload_assignment') }}',
                                    ondata: (formData) => {
                                        formData.append('batch_id', '{{ $batch->id }}');
                                        return formData;
                                    },
                                },
                                load: '/load_assignment_files/{{ $batch->id }}/',
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
                                    fetch(`/delete_assignment_file/{{ $batch->id }}/${source}`, {
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

                    dueDateToggle() {
                        var toggle = $('#due_date_toggle')
                        var due_inputs = $('#due_inputs')
                        due_inputs.toggleClass('hidden')

                        if ($(toggle).is(':checked')) {
                            $('#due_date').prop('required', true);
                            $('#due_time').prop('required', true);

                        } else {
                            $('#due_date').prop('required', false);
                            $('#due_time').prop('required', false);
                        }
                    },

                    toggleShowAddFile() {

                    },

                    getAssignmentClass(assignment) {
                        const isClosed = assignment.closed;
                        const isClosing = assignment.closing;
                        const isDuePast = moment(assignment.formattedDue).isBefore(moment());


                        if ((!isClosing || !isClosed) && !isDuePast) {
                            console.log(assignment);
                            return 'bg-sky-700'; // Sky blue if not closing or not closed
                        } else if ((isClosed || isDuePast) && isClosing) {
                            return 'bg-red-700'; // Red if closed or due date is past
                        } else if (!isClosed && isDuePast) {
                            return 'bg-yellow-700'; // Yellow if not closed and due date is past
                        }

                        return ''; // Default case, if none of the conditions are met
                    },
                }
            }
        </script>
    @endsection
</x-app-layout>
