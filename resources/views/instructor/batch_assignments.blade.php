<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $batch->course->name }}</span>
            </div>
            <div>Batch: {{ $batch->name }}</div>
        </div>
        <x-course-nav :selected="'assignment'" :batch="$batch->id"></x-course-nav>

    </x-slot>
    <div x-data="assignmentList" id="course_list" class="mx-8 pb-4 pt-48 text-white">
        {{-- <div class="relative flex pt-2">
            <x-dropdown width="lg" align="left">
                <x-slot name="trigger">
                    <button
                        class="flex cursor-pointer rounded-md bg-sky-700 px-4 py-2 text-sm text-white transition duration-150 ease-in-out hover:bg-sky-800 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="mr-1 h-5 w-5">
                            <path fill="currentColor"
                                d="M12,15.5A3.5,3.5 0 0,1 8.5,12A3.5,3.5 0 0,1 12,8.5A3.5,3.5 0 0,1 15.5,12A3.5,3.5 0 0,1 12,15.5M19.43,12.97C19.47,12.65 19.5,12.33 19.5,12C19.5,11.67 19.47,11.34 19.43,11L21.54,9.37C21.73,9.22 21.78,8.95 21.66,8.73L19.66,5.27C19.54,5.05 19.27,4.96 19.05,5.05L16.56,6.05C16.04,5.66 15.5,5.32 14.87,5.07L14.5,2.42C14.46,2.18 14.25,2 14,2H10C9.75,2 9.54,2.18 9.5,2.42L9.13,5.07C8.5,5.32 7.96,5.66 7.44,6.05L4.95,5.05C4.73,4.96 4.46,5.05 4.34,5.27L2.34,8.73C2.21,8.95 2.27,9.22 2.46,9.37L4.57,11C4.53,11.34 4.5,11.67 4.5,12C4.5,12.33 4.53,12.65 4.57,12.97L2.46,14.63C2.27,14.78 2.21,15.05 2.34,15.27L4.34,18.73C4.46,18.95 4.73,19.03 4.95,18.95L7.44,17.94C7.96,18.34 8.5,18.68 9.13,18.93L9.5,21.58C9.54,21.82 9.75,22 10,22H14C14.25,22 14.46,21.82 14.5,21.58L14.87,18.93C15.5,18.67 16.04,18.34 16.56,17.94L19.05,18.95C19.27,19.03 19.54,18.95 19.66,18.73L21.66,15.27C21.78,15.05 21.73,14.78 21.54,14.63L19.43,12.97Z" />
                        </svg>
                        Manage
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="m-1.5">
                        <a @click="triggerModal('assignment')"
                            class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                            <div>Assignment</div>
                        </a>

                        <template x-if="course.structure != 'small'">
                            <a @click="triggerModal('lesson')"
                                class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                </svg>
                                <div>Lesson</div>
                            </a>
                        </template>

                        <template x-if="course.structure == 'big'">
                            <a @click="triggerModal('uc')"
                                class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                </svg>
                                <div>Unit of Competency</div>
                            </a>
                        </template>

                    </div>
                </x-slot>
            </x-dropdown>
        </div> --}}
        <template x-if="course.structure == 'big'">
            <div>
                <template x-for="uc in uc" :key="uc.id">
                    <div x-data="{ open: false }">
                        <h2 :id="`accordion-collapse-heading-${uc.id}`" x-transition>
                            <button type="button" @click="open = !open" :class="open ? 'bg-sky-800' : 'bg-gray-700 '"
                                class="mt-2 flex w-full items-center justify-between gap-3 rounded-b-md rounded-t-md bg-gray-700 p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white">
                                <div>
                                    <div x-text="uc.title"></div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-3 w-3 shrink-0 rotate-180" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </div>

                            </button>
                        </h2>
                        <div x-show="open" x-transition>
                            <template x-if="uc.lesson.length < 1">
                                <div class="my-2 rounded-md bg-gray-800 p-1.5 text-center text-sm text-white/75">No
                                    Lesson
                                </div>
                            </template>
                            <template x-for="lesson in uc.lesson" :key="lesson.id">
                                <div class="px-2 py-1.5">
                                    <div class="text-md my-1.5 rounded-md bg-sky-700 p-1.5" x-text="lesson.title">
                                    </div>
                                    <template x-if="lesson.assignment.length < 1">
                                        <div
                                            class="mb-2 rounded-md bg-gray-800 p-1.5 text-center text-sm text-white/75">
                                            No
                                            Assignment
                                        </div>
                                    </template>
                                    <template x-for="assignment in lesson.assignment" :key="assignment.id">
                                        <div class="mb-2 rounded-md bg-gray-800 p-px">
                                            <div class="my-2 w-full rounded-md bg-gray-800 px-3 py-px">
                                                <a :href=`/list_turn_ins/${assignment.id}`
                                                    class="flex items-center justify-between">
                                                    <div class="flex items-center justify-start gap-4">
                                                        <div>
                                                            <div class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full p-2"
                                                                :class="{
                                                                    'bg-sky-700': !assignment.closed,
                                                                    'bg-red-700': assignment.closed,
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
                            </template>
                        </div>
                    </div>
                </template>
                <template x-if="uc.length < 1">
                    <div>No Assignments</div>
                </template>
            </div>

        </template>
        <template x-if="course.structure == 'medium'">
            <template x-if="uc != null">
                <template x-for="lesson in uc[0].lesson" :key="lesson.id">
                    <div x-data="{ open: false }">
                        <h2 :id="`accordion-collapse-heading-${uc.id}`" x-transition>
                            <button type="button" @click="open = !open" :class="open ? 'bg-sky-800' : 'bg-gray-700 '"
                                class="mt-2 flex w-full items-center justify-between gap-3 rounded-b-md rounded-t-md bg-gray-700 p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white"
                                :data-accordion-target="`#accordion-collapse-body-${uc.id}`" aria-expanded="false"
                                :aria-controls="`accordion-collapse-body-${uc.id}`">
                                <div>
                                    <div x-text="lesson.title"></div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-3 w-3 shrink-0 rotate-180" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </div>

                            </button>
                        </h2>
                        <div x-show="open" x-transition>
                            <template x-if="lesson.assignment.length < 1">
                                <div class="mx-1 my-2 rounded-md bg-gray-800 p-1.5 text-center text-sm text-white/75">
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
                                                            'bg-red-700': assignment.closed,
                                                        }">
                                                        <svg x-show="assignment.closed"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>book-cancel-outline</title>
                                                            <path fill="white"
                                                                d="M12.18 20C12.36 20.72 12.65 21.39 13.04 22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.18C19.5 12.07 19 12 18.5 12C18.33 12 18.17 12 18 12.03V4H13V12L10.5 9.75L8 12V4H6V20H12.18M23 18.5C23 21 21 23 18.5 23S14 21 14 18.5 16 14 18.5 14 23 16 23 18.5M20 21.08L15.92 17C15.65 17.42 15.5 17.94 15.5 18.5C15.5 20.16 16.84 21.5 18.5 21.5C19.06 21.5 19.58 21.35 20 21.08M21.5 18.5C21.5 16.84 20.16 15.5 18.5 15.5C17.94 15.5 17.42 15.65 17 15.92L21.08 20C21.35 19.58 21.5 19.06 21.5 18.5Z" />
                                                        </svg>
                                                        <svg x-show="!assignment.closed"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
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
                                                    'bg-red-700': assignment.closed,
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
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="time"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    <div class="flex rounded-lg">
                                        <label class="inline-flex w-full cursor-pointer items-center">
                                            <input type="checkbox" id="due_date_toggle" class="peer sr-only">
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
                                            datepicker-autoselect-today id="due_date" type="text" name="due_date"
                                            autocomplete="off"
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
                                        <label for="closing" class="ms-2">Close submissions after due
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
                                                <option selected>Select</option>

                                                <template x-for="uc in uc" :key="uc.id">
                                                    <option :value="uc.id" x-text="uc.title"></option>
                                                </template>

                                            </select>

                                        </div>
                                    </template>
                                    <div class="col-span-2">
                                        <label for="lesson"
                                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Lesson</label>

                                        <select id="lesson" name="lesson" required
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                            <option selected>Select</option>

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
                            <div class="text-xs text-white">
                                <a class="flex cursor-pointer items-center"
                                    onclick="toggleShowAddFile('assignment')">Attach File/s<svg id="icon_assignment"
                                        class="ml-px h-4 w-4 text-gray-800 dark:text-white"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 9-7 7-7-7" />
                                    </svg>
                                </a>
                            </div>

                            <div id="show_addFile_assignment" class="col-span-2 hidden">
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
                <div class="relative rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Lessons
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
                                                        class="my-2 flex items-center justify-between bg-gradient-to-r from-sky-700 p-1.5">
                                                        <span x-text="uc.title"></span>
                                                        <button @click="addLesson(uc.id)"
                                                            class="rounded-md p-2 hover:bg-sky-700">
                                                            <svg class="h-4 w-4 text-white"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <template x-if="uc.lesson.length < 1">
                                                        <div class="p-2 text-sm text-gray-400">No lesson</div>
                                                    </template>

                                                    <template x-for="lesson in uc.lesson" :key="lesson.id">
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
                                                </div>
                                            </template>
                                            <template x-if="uc.length < 1">
                                                <div class="p-2 text-center text-sm text-gray-400">
                                                    No lessons yet. Create a unit of competency first before adding a
                                                    lesson.
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
                                                    Lesson</button>
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
                                                    No lessons
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
                <div class="relative rounded-lg bg-gray-700">
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
                                                class="flex items-center justify-between rounded-md bg-gray-700 p-2 text-sm hover:bg-gray-800/75">
                                                <span x-text="uc.title"></span>
                                                <div class="flex">
                                                    <button @click="editModal('uc', uc.id, '')"
                                                        class="me-1 h-7 w-7 rounded-md p-1 hover:bg-gray-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>Edit</title>
                                                            <path fill="white"
                                                                d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('delete_uc') }}"
                                                        class="h-7 w-7 rounded-md p-1 hover:bg-gray-600"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="uc_id" :value="uc.id">

                                                        <button @click.prevent="confirmDelete()" class="h-full w-full"
                                                            type="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>Delete</title>
                                                                <path fill="white"
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
                <div class="relative rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Lesson Name
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
                                    <div class="mb-2 block text-sm font-medium text-white">Current
                                        name: <span class="font-bold" x-text="selectedLesson.title"></span></div>
                                    <label for="lesson" class="mb-2 block text-sm font-medium text-white">Change
                                        to:</label>
                                    <div class="grid grid-cols-9">
                                        @csrf
                                        <input type="hidden" name="lesson_id" :value="selectedLesson.id">
                                        <div class="col-span-8">
                                            <input type="text" id="new_lesson_name" name="new_lesson_name"
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                                placeholder="New Lesson Name" :value="selectedLesson.title"
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
                <div class="relative rounded-lg bg-gray-700">
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
                                    <div class="mb-2 block text-sm font-medium text-white">Current
                                        name: <span class="font-bold" x-text="selectedUc.title"></span></div>
                                    <label for="lesson" class="mb-2 block text-sm font-medium text-white">Change
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
                <div class="relative rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Add Lesson
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
                                    <template x-if="course.structure == 'big'">
                                        <div class="mb-2 block text-sm font-medium text-white">Add a lesson to: <span
                                                class="font-bold" x-text="selectedUc.title"></span></div>
                                    </template>
                                    <div class="grid grid-cols-9">
                                        @csrf
                                        <input type="hidden" name="batch_id" :value="batch.id">
                                        <input type="hidden" name="uc_id" :value="selectedUc.id">
                                        <input autocomplete="on" list="options" id="lesson_title"
                                            name="lesson_title"
                                            class="col-span-8 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Lesson Title" required />
                                        <datalist id="options">
                                            <template x-for="lesson in all_lessons" :key="lesson">
                                                <option :value="lesson"></option>
                                            </template>
                                            <!-- Add more options as needed -->
                                        </datalist>

                                        <button type="submit"
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

        {{-- Add UC Modal --}}
        <div x-cloak x-show="showAddUc" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700">
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
                                    <div class="mb-2 block text-sm font-medium text-white">Add a unit of competency
                                    </div>
                                    <div class="grid grid-cols-9">
                                        @csrf
                                        <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                                        <input autocomplete="on" list="options_uc_title" id="uc_title"
                                            name="uc_title"
                                            class="col-span-8 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                            placeholder="Unit of Competency Title" required />
                                        <datalist id="options_uc_title">
                                            <template x-for="uc in all_ucs" :key="uc">
                                                <option :value="uc"></option>
                                            </template>
                                        </datalist>

                                        <button type="submit"
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

        {{-- Speed Dial --}}
        <template x-if="batch.completed_at == null">
            <div data-dial-init class="group fixed bottom-6 end-6">
                <div id="speed-dial-menu-text-inside-button-square"
                    class="mb-4 flex hidden flex-col items-center space-y-2">
                    <button type="button" @click="triggerModal('assignment')"
                        class="h-[56px] w-[56px] rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                        <svg class="mx-auto mb-1 h-4 w-4" fill="currentColor"xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <title>note-edit-outline</title>
                            <path
                                d="M18.13 12L19.39 10.74C19.83 10.3 20.39 10.06 21 10V9L15 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.89 21 5 21H11V19.13L11.13 19H5V5H12V12H18.13M14 4.5L19.5 10H14V4.5M19.13 13.83L21.17 15.87L15.04 22H13V19.96L19.13 13.83M22.85 14.19L21.87 15.17L19.83 13.13L20.81 12.15C21 11.95 21.33 11.95 21.53 12.15L22.85 13.47C23.05 13.67 23.05 14 22.85 14.19Z" />
                        </svg>
                        <span class="mb-px block text-xs font-medium">Assignment</span>
                    </button>
                    <button type="button" @click="triggerModal('lesson')"
                        class="h-[56px] w-[56px] rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                        <svg class="mx-auto mb-1 h-4 w-4" fill="currentColor"xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <title>note-edit-outline</title>
                            <path
                                d="M18.13 12L19.39 10.74C19.83 10.3 20.39 10.06 21 10V9L15 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.89 21 5 21H11V19.13L11.13 19H5V5H12V12H18.13M14 4.5L19.5 10H14V4.5M19.13 13.83L21.17 15.87L15.04 22H13V19.96L19.13 13.83M22.85 14.19L21.87 15.17L19.83 13.13L20.81 12.15C21 11.95 21.33 11.95 21.53 12.15L22.85 13.47C23.05 13.67 23.05 14 22.85 14.19Z" />
                        </svg>
                        <span class="mb-px block text-xs font-medium">Lesson</span>
                    </button>
                    <button type="button" @click="triggerModal('uc')"
                        class="h-[56px] w-[56px] rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                        <svg class="mx-auto mb-1 h-4 w-4" fill="currentColor"xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <title>note-edit-outline</title>
                            <path
                                d="M18.13 12L19.39 10.74C19.83 10.3 20.39 10.06 21 10V9L15 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.89 21 5 21H11V19.13L11.13 19H5V5H12V12H18.13M14 4.5L19.5 10H14V4.5M19.13 13.83L21.17 15.87L15.04 22H13V19.96L19.13 13.83M22.85 14.19L21.87 15.17L19.83 13.13L20.81 12.15C21 11.95 21.33 11.95 21.53 12.15L22.85 13.47C23.05 13.67 23.05 14 22.85 14.19Z" />
                        </svg>
                        <span class="mb-px block text-xs font-medium">Unit of Competency</span>
                    </button>

                </div>
                <button type="button" data-dial-toggle="speed-dial-menu-text-inside-button-square"
                    aria-controls="speed-dial-menu-text-inside-button-square" aria-expanded="false"
                    class="flex h-14 w-14 items-center justify-center rounded-lg bg-blue-700 text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
                <svg class="w-6 h-6 text-gray-800 dark:text-white"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7"/>
                </svg>
            `;
                } else {
                    icon.innerHTML = `
                <svg class="h-3 w-3 text-gray-800 dark:text-white"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                </svg>
            `;
                }
            }

            var toggle = $('#due_date_toggle')
            toggle.click(function() {
                var due_inputs = $('#due_inputs')
                due_inputs.toggleClass('hidden')

                if ($(this).is(':checked')) {
                    $('#due_date').prop('required', true);
                    $('#due_time').prop('required', true);

                } else {
                    $('#due_date').prop('required', false);
                    $('#due_time').prop('required', false);
                }
            })

            // Post assignment
            $(document).ready(function() {
                $('#post_assignment').submit(function(event) {
                    if ($('#lesson').val() == 'Select') {
                        alert('Select lesson');
                        event.preventDefault();
                    } else {
                        $('#post_assignment').submit();
                    }
                    // console.log($('#lesson').val());
                    // if ($('#due_date_toggle').is(':checked') && $('#due_date').val() === '') {
                    //     alert('Set due date');
                    //     return ''
                    // }

                });

                $('#due_date_toggle').on('change', function() {
                    $('#due_date').val('')
                })

                function isDateBeforeToday(date) {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    return new Date(date) < today;
                }

                $('#due_date').on('change', function() {
                    var selectedDate = $(this).val();
                    if (isDateBeforeToday(selectedDate)) {
                        alert('The selected date cannot be less than today.');
                        $(this).val('');
                    }
                });

                $('#add_lesson_button').on('click', function() {
                    $('#create-assignment-modal').addClass('hidden')
                    console.log($('#create-assignment-modal'));
                })

            })

            $('#due_date').on('keypress', function(e) {
                e.preventDefault();
            });

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
                        console.log(this.batch);

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
                }
            }
        </script>
    @endsection
</x-app-layout>
