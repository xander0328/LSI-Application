<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="md:flex flex-row items-center md:space-x-1 text-2xl font-semibold text-white">
                <div>{{ __('Assignments') }}</div>
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
                        <div class="m-1.5 flex-row">
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
    <div x-data="assignmentList" id="course_list"
        class="mx-4 mt-4 flex flex-col-reverse md:pt-44 pt-40 pb-20  text-white">
        <template x-if="batch.course.structure == 'big'">
            <div>
                <template x-for="uc in batch.unit_of_competency" :key="uc.id">
                    <div x-data="{ open: false }">
                        <h2 :id="`accordion-collapse-heading-${uc.id}`" x-transition>
                            <button type="button" @click="open = !open" :class="open ? 'bg-sky-800' : 'bg-gray-700 '"
                                class="mt-2 flex w-full items-center justify-between gap-3 rounded-b-md rounded-t-md bg-gray-700 p-2 px-3 font-medium text-white hover:bg-sky-700 hover:text-white">
                                <div class="flex space-x-2 items-center">
                                    <div class="flex items-center">
                                        <span
                                            class="text-white font-medium text-sm w-6 h-6 inline-flex justify-center items-center rounded-full "
                                            :class="open ? 'bg-sky-950' : 'bg-sky-700'" x-text="uc.lesson.length">
                                        </span>
                                    </div>
                                    <div class="text-start" x-text="uc.title"></div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="h-3 w-3 shrink-0 " :class="{ 'rotate-180': !open }"
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
                                    <div class="flex space-x-2 items-center my-1.5 rounded-md bg-sky-700 p-1.5">
                                        <div class="flex items-center">
                                            <span
                                                class="text-white font-medium text-sm w-6 h-6 inline-flex justify-center items-center rounded-full bg-sky-950"
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
                                        <div class="mb-2 rounded-md bg-gray-800 p-px">
                                            <div class="my-2 w-full rounded-md bg-gray-800 px-3 py-px">
                                                <a :href=`/course/view_assignment/${assignment.id}`
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
                                                                <svg x-show="getAssignmentClass(assignment) == 'bg-yellow-700' "
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24">
                                                                    <title>book-clock-outline</title>
                                                                    <path fill="white"
                                                                        d="M20 11.26V4C20 2.9 19.11 2 18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H11.11C12.37 23.24 14.09 24 16 24C19.87 24 23 20.87 23 17C23 14.62 21.81 12.53 20 11.26M18 4V10.29C17.37 10.11 16.7 10 16 10C14.93 10 13.91 10.25 13 10.68V4H18M6 4H8V12L10.5 9.75L12.1 11.19C10.23 12.45 9 14.58 9 17C9 18.08 9.25 19.09 9.68 20H6V4M16 22C13.24 22 11 19.76 11 17S13.24 12 16 12 21 14.24 21 17 18.76 22 16 22M16.5 17.25L19.36 18.94L18.61 20.16L15 18V13H16.5V17.25Z" />
                                                                </svg>
                                                                <svg x-show="getAssignmentClass(assignment) == 'bg-sky-700'"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24">
                                                                    <title>book-check-outline</title>
                                                                    <path fill="white"
                                                                        d="M16.75 22.16L14 19.16L15.16 18L16.75 19.59L20.34 16L21.5 17.41L16.75 22.16M18 2C19.1 2 20 2.9 20 4V13.34C19.37 13.12 18.7 13 18 13V4H13V12L10.5 9.75L8 12V4H6V20H12.08C12.2 20.72 12.45 21.39 12.8 22H6C4.9 22 4 21.1 4 20V4C4 2.9 4.9 2 6 2H18Z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="w-full font-medium dark:text-white">
                                                            <div x-text="assignment.title"></div>
                                                            {{-- <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ mb_strimwidth($assignment->description, 0, 70, '...') }}
                                                            </div> --}}
                                                            <div class="text-sm sm:hidden text-gray-500"
                                                                x-text="assignment.due_date != null ? 'Due ' + moment(assignment.formattedDue).calendar(): 'No due'">
                                                            </div>
                                                            <template x-if="assignment.closing">
                                                                <div class="sm:hidden">
                                                                    <span
                                                                        class=" text-xs px-2 rounded bg-red-700 text-white">
                                                                        Closing
                                                                    </span>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                    <div class="hidden sm:block">
                                                        <div class="text-sm  text-gray-500"
                                                            x-text="assignment.due_date != null ? 'Due ' + moment(assignment.formattedDue).calendar(): 'No due'">
                                                        </div>
                                                        <template x-if="assignment.closing">
                                                            <div class="text-end">
                                                                <span
                                                                    class=" text-xs px-2 rounded bg-red-700 text-white">
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
        {{-- @if ($assignments->count() < 1)
            <div class="mb-2 rounded-md bg-gray-800 px-2 py-1 text-white/50">
                No Assignment
            </div>
        @endif --}}
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

            function assignmentList() {
                return {
                    batch: @json($batch ?? ''),
                    init() {
                        console.log(this.batch.unit_of_competency);

                    },
                    getAssignmentClass(assignment) {
                        const isClosed = assignment.closed;
                        const isClosing = assignment.closing;
                        const isDuePast = moment(assignment.formattedDue).isBefore(moment());
                        const complete = assignment.turn_ins && assignment.turn_ins.turned_in


                        if (complete) {
                            console.log(assignment);
                            return 'bg-sky-700'; // Sky blue if not closing or not closed
                        } else if ((isClosed || isDuePast) && isClosing) {
                            return 'bg-red-700'; // Red if closed or due date is past
                        } else if (!complete || !isClosed && (!isClosing || !isClosed) && !isDuePast) {
                            return 'bg-yellow-700'; // Yellow if not closed and due date is past
                        }

                        return '';
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
