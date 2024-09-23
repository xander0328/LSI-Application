<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }

        .no-scroll {
        overflow: hidden;
        }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Offered Courses') }}
            </div>
            <div>
                <button onclick="window.dispatchEvent(new CustomEvent('add-course-modal'))"
                    class="flex items-center rounded-lg bg-sky-700 px-3.5 py-2.5 text-center text-xs font-medium text-white hover:bg-blue-800 md:px-5 md:text-sm"
                    type="button">
                    <svg class="h-4 w-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg> Add Course
                </button>
            </div>
        </div>

    </x-slot>
    <div x-data="manageCourse" id="main-div" class="mx-4 pb-4 pt-40 md:mx-8">
        <ul class="space-y-2 font-semibold text-white">
            <template x-if="courses.length == 0">
                <div>
                    <div class="rounded-lg bg-sky-950 p-4 text-center text-slate-400">No course added
                    </div>
                </div>
            </template>
            <template x-if="courses.length > 0">
                <template x-for="course in courses" :key="course.id">
                    <li id="course-item" class="rounded-md bg-gray-800 p-2">
                        <div>
                            <div class="mb-px flex items-center justify-between">
                                <div class="my-1 py-1 text-sm text-sky-400 md:text-base" x-text="course.name"></div>
                                <div class="flex">

                                    <div class="flex justify-between align-middle">
                                        <div class="hidden rounded-lg p-2 hover:bg-gray-800 md:flex md:inline-flex">
                                            <label class="inline-flex w-full cursor-pointer items-center">
                                                <input @change="courseToggle(course.id)" type="checkbox"
                                                    :checked="course.available" class="course-toggle peer sr-only">
                                                <div
                                                    class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600">
                                                </div>
                                                <span
                                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Enrollment</span>
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <x-dropdown width="40" align="right">
                                                <x-slot name="trigger">
                                                    <button
                                                        class="inline-flex items-center rounded-md border border-transparent bg-white text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                                        <svg class="h-7 w-7 text-white hover:text-sky-500"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z" />
                                                        </svg>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <div class="m-1.5">
                                                        <div class="flex rounded-lg p-2 hover:bg-gray-800 md:hidden">
                                                            <label
                                                                class="inline-flex w-full cursor-pointer items-center">
                                                                <input @change="courseToggle(course.id)" type="checkbox"
                                                                    :checked="course.available"
                                                                    class="course-toggle peer sr-only">
                                                                <div
                                                                    class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600">
                                                                </div>
                                                                <span
                                                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Enrollment</span>
                                                            </label>
                                                        </div>

                                                        <div class="flex rounded-lg p-2 hover:bg-gray-800">
                                                            <label
                                                                class="inline-flex w-full cursor-pointer items-center">
                                                                <input @change="featureToggle(course.id)"
                                                                    type="checkbox" :checked="course.featured"
                                                                    class="peer sr-only"
                                                                    :class="'feature-toggle-' + course.id">
                                                                <div
                                                                    class="peer relative h-5 w-9 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-4 after:w-4 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white rtl:peer-checked:after:translate-x-[-100%] dark:border-gray-500 dark:bg-gray-600">
                                                                </div>
                                                                <span
                                                                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Feature</span>
                                                            </label>
                                                        </div>

                                                        <hr class="my-1 opacity-50">

                                                        <a @click="editCourse(course.id)"
                                                            class="flex w-full cursor-pointer items-center space-x-1 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                                                            </svg>
                                                            <div>Edit</div>
                                                        </a>

                                                        <x-dropdown-link hover_bg="hover:bg-red-900"
                                                            class="flex cursor-pointer items-center space-x-1 rounded-md px-1.5"
                                                            @click.prevent="deleteCourseConfirmation(course.id)">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                            </svg>
                                                            <div>
                                                                Delete
                                                            </div>
                                                        </x-dropdown-link>

                                                        <hr class="my-1 opacity-50">

                                                        <div>
                                                            <a :href=`/courses/${course.id}/enrollees`
                                                                class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                                <div class="mr-1"><svg
                                                                        class="h-5 w-5 text-gray-800 dark:text-white"
                                                                        aria-hidden="true"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="currentColor" viewBox="0 0 24 24">
                                                                        <path fill-rule="evenodd"
                                                                            d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4c0 1.1.9 2 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.8-3.1a5.5 5.5 0 0 0-2.8-6.3c.6-.4 1.3-.6 2-.6a3.5 3.5 0 0 1 .8 6.9Zm2.2 7.1h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1l-.5.8c1.9 1 3.1 3 3.1 5.2ZM4 7.5a3.5 3.5 0 0 1 5.5-2.9A5.5 5.5 0 0 0 6.7 11 3.5 3.5 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4c0 1.1.9 2 2 2h.5a6 6 0 0 1 3-5.2l-.4-.8Z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </div>Enrollees
                                                                <span
                                                                    class="ms-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-sky-900 text-xs font-semibold text-white"
                                                                    x-text="course.enrollees_count"></span>
                                                            </a>
                                                        </div>

                                                        <div>
                                                            <a @click.prevent="triggerBatchesModal(course.id)"
                                                                class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                                <div class="mr-1">
                                                                    <svg class="h-5 w-5 text-gray-800 dark:text-white"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor">
                                                                        <path
                                                                            d="M23,2H1A1,1 0 0,0 0,3V21A1,1 0 0,0 1,22H23A1,1 0 0,0 24,21V3A1,1 0 0,0 23,2M22,20H20V19H15V20H2V4H22V20M10.29,9.71A1.71,1.71 0 0,1 12,8C12.95,8 13.71,8.77 13.71,9.71C13.71,10.66 12.95,11.43 12,11.43C11.05,11.43 10.29,10.66 10.29,9.71M5.71,11.29C5.71,10.58 6.29,10 7,10A1.29,1.29 0 0,1 8.29,11.29C8.29,12 7.71,12.57 7,12.57C6.29,12.57 5.71,12 5.71,11.29M15.71,11.29A1.29,1.29 0 0,1 17,10A1.29,1.29 0 0,1 18.29,11.29C18.29,12 17.71,12.57 17,12.57C16.29,12.57 15.71,12 15.71,11.29M20,15.14V16H16L14,16H10L8,16H4V15.14C4,14.2 5.55,13.43 7,13.43C7.55,13.43 8.11,13.54 8.6,13.73C9.35,13.04 10.7,12.57 12,12.57C13.3,12.57 14.65,13.04 15.4,13.73C15.89,13.54 16.45,13.43 17,13.43C18.45,13.43 20,14.2 20,15.14Z" />
                                                                    </svg>
                                                                </div>Batches
                                                                <span
                                                                    class="ms-2 inline-flex h-4 w-4 items-center justify-center rounded-full bg-sky-900 text-sm font-semibold text-white"
                                                                    x-text="course.batches_count"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr class="border border-gray-500">
                            <div @click="$('#description-'+course.id).toggleClass('line-clamp-3')"
                                :id="'description-' + course.id"
                                class="my-2 line-clamp-3 cursor-pointer text-xs font-thin md:text-sm">
                                <span class="" x-text="course.description"></span>
                            </div>
                            <div class="text-xs font-thin">
                                <span>Code:</span> <span x-text="course.code"></span>
                            </div>
                            <div class="text-xs font-thin">
                                <span>Duration:</span> <span x-text="course.training_hours"></span>
                                hours
                            </div>
                        </div>
                    </li>
                </template>
            </template>
        </ul>

        {{-- Add Course Modal --}}
        <div x-cloak x-show="courseModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" x-text="modalTitle"></h3>
                        <button type="button"
                            @click="courseModal = false; document.body.classList.remove('no-scroll');"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form id="courseModalForm" class="p-4 md:p-5" method="POST" action="{{ route('add_course') }}">
                        @csrf
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <input type="hidden" id="course_id" name="course_id">
                            <input type="hidden" id="edit" name="edit" x-model="edit">
                            <div class="col-span-2">
                                <label for="image"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Image</label>
                                <input id="image" required
                                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                                    type="file" name="image" accept="image/*" multiple>
                            </div>
                            <div class="col-span-2">
                                <label for="name"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="name" id="name"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Type course name" required>
                            </div>
                            <div class="col-span-2">
                                <label for="code"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Code</label>
                                <input type="text" name="code" id="code" maxlength="5"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Type course code (max: 5 characters)" required>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="training_hours"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Training
                                    Hours</label>
                                <input type="number" name="training_hours" id="training_hours"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Hours" required>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select name="category" id="category" required
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option selected="">Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="registration_fee"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Registration
                                    Fee</label>
                                <input type="number" name="registration_fee" id="registration_fee"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Philippine Peso" required>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="bond_deposit"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Bond
                                    Deposit</label>
                                <input type="number" name="bond_deposit" id="bond_deposit"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Philippine Peso" required>
                            </div>
                            <div class="col-span-2">
                                <label for="description"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Course
                                    Description</label>
                                <textarea required name="description" id="description" rows="4"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Type course description"></textarea>
                            </div>
                            <template x-if="selectedCourse.length > 0">
                                <div x-cloak x-show="modalTitle === 'Edit Course'" class="col-span-2">
                                    <label for="description"
                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Course
                                        Structure</label>
                                    <ul class="grid w-full gap-1">
                                        <li x-show="selectedCourse[0].structure === 'small'">

                                            <label for="small"
                                                class="inline-flex h-full w-full cursor-pointer justify-between rounded-lg border border-gray-200 bg-white p-5 peer-checked:border-sky-600 peer-checked:text-sky-600 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:peer-checked:text-sky-500">
                                                <div class="block">
                                                    <div class="text-md w-full">
                                                        Acitivities Only
                                                    </div>
                                                </div>
                                            </label>
                                        </li>
                                        <li x-show="selectedCourse[0].structure === 'medium'">

                                            <label for="medium"
                                                class="inline-flex h-full w-full cursor-pointer justify-between rounded-lg border border-gray-200 bg-white p-5 peer-checked:border-sky-600 peer-checked:text-sky-600 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:peer-checked:text-sky-500">
                                                <div class="block">
                                                    <div class="text-md w-full">
                                                        Learning Outcome
                                                    </div>
                                                    <div class="flex w-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1.5 w-4"
                                                            viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M20 16L14.5 21.5L13.08 20.09L16.17 17H10.5C6.91 17 4 14.09 4 10.5V4H6V10.5C6 13 8 15 10.5 15H16.17L13.09 11.91L14.5 10.5L20 16Z" />
                                                        </svg>Activity
                                                    </div>
                                                </div>
                                            </label>
                                        </li>
                                        <li x-show="selectedCourse[0].structure === 'big'">

                                            <label for="big"
                                                class="inline-flex h-full w-full cursor-pointer justify-between rounded-lg border border-gray-200 bg-white p-5 peer-checked:border-sky-600 peer-checked:text-sky-600 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:peer-checked:text-sky-500">
                                                <div class="block">
                                                    <div class="text-md w-full">
                                                        Unit of Competency
                                                    </div>
                                                    <div class="flex w-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1.5 w-4"
                                                            viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M20 16L14.5 21.5L13.08 20.09L16.17 17H10.5C6.91 17 4 14.09 4 10.5V4H6V10.5C6 13 8 15 10.5 15H16.17L13.09 11.91L14.5 10.5L20 16Z" />
                                                        </svg>Learning Outcome
                                                    </div>
                                                    <div class="flex w-full ps-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="me-1.5 w-4"
                                                            viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M20 16L14.5 21.5L13.08 20.09L16.17 17H10.5C6.91 17 4 14.09 4 10.5V4H6V10.5C6 13 8 15 10.5 15H16.17L13.09 11.91L14.5 10.5L20 16Z" />
                                                        </svg>Activity
                                                    </div>
                                                </div>
                                            </label>
                                        </li>
                                    </ul>

                                </div>
                            </template>
                            <div x-cloak x-show="modalTitle !== 'Edit Course'" class="col-span-2">
                                <div class="mb-2 block text-sm font-medium text-white">Course Structure</div>
                                <ul class="grid w-full gap-1">
                                    <li>
                                        <input type="radio" id="small" name="structure" value="small"
                                            required class="peer hidden">
                                        <label for="small"
                                            class="inline-flex h-full w-full cursor-pointer justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-500 hover:bg-gray-100 hover:text-gray-600 peer-checked:border-sky-600 peer-checked:text-sky-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-800/75 dark:hover:text-gray-300 dark:peer-checked:text-sky-500">
                                            <div class="block">
                                                <div class="text-md w-full">
                                                    Acitivities Only
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="medium" name="structure" value="medium"
                                            class="peer hidden">
                                        <label for="medium"
                                            class="inline-flex h-full w-full cursor-pointer justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-500 hover:bg-gray-100 hover:text-gray-600 peer-checked:border-sky-600 peer-checked:text-sky-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-800/75 dark:hover:text-gray-300 dark:peer-checked:text-sky-500">
                                            <div class="block">
                                                <div class="text-md w-full">
                                                    Learning Outcome
                                                </div>
                                                <div class="flex w-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1.5 w-4"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M20 16L14.5 21.5L13.08 20.09L16.17 17H10.5C6.91 17 4 14.09 4 10.5V4H6V10.5C6 13 8 15 10.5 15H16.17L13.09 11.91L14.5 10.5L20 16Z" />
                                                    </svg>Activity
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="big" name="structure" value="big"
                                            class="peer hidden" required />
                                        <label for="big"
                                            class="inline-flex h-full w-full cursor-pointer justify-between rounded-lg border border-gray-200 bg-white p-5 text-gray-500 hover:bg-gray-100 hover:text-gray-600 peer-checked:border-sky-600 peer-checked:text-sky-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-800/75 dark:hover:text-gray-300 dark:peer-checked:text-sky-500">
                                            <div class="block">
                                                <div class="text-md w-full">
                                                    Unit of Competency
                                                </div>
                                                <div class="flex w-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1.5 w-4"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M20 16L14.5 21.5L13.08 20.09L16.17 17H10.5C6.91 17 4 14.09 4 10.5V4H6V10.5C6 13 8 15 10.5 15H16.17L13.09 11.91L14.5 10.5L20 16Z" />
                                                    </svg>Learning Outcome
                                                </div>
                                                <div class="flex w-full ps-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="me-1.5 w-4"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M20 16L14.5 21.5L13.08 20.09L16.17 17H10.5C6.91 17 4 14.09 4 10.5V4H6V10.5C6 13 8 15 10.5 15H16.17L13.09 11.91L14.5 10.5L20 16Z" />
                                                    </svg>Activity
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="-ms-1 me-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add new course
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- List of Batches Modal --}}
        <div x-cloak x-show="showBatchesModal" x-transition:enter="transition ease-out duration-200"
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
                            Batches | <span class="text-xs" x-text="selectedCourse.name"></span>
                        </h3>
                        <button type="button"
                            @click="showBatchesModal = !showBatchesModal; document.body.classList.remove('no-scroll');"
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
                    <div class="relative p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">

                                <div class="text-white">
                                    <div>
                                        <button @click="create_new_batch(selectedCourse.id)" :disabled="dataLoading"
                                            class="mb-1.5 w-full rounded-md bg-sky-700 p-2 text-sm hover:bg-sky-800 disabled:cursor-not-allowed">Create
                                            New Batch</button>
                                    </div>
                                    <div id="list_uc">
                                        <template x-if="selectedCourse?.batches?.length < 1">
                                            <div class="p-2 text-center text-sm text-gray-400">No batches</div>
                                        </template>

                                        <template x-for="batch in selectedCourse.batches" :key="batch.id">
                                            <div
                                                class="flex items-center justify-between rounded-md bg-gray-700 p-2 text-sm hover:bg-gray-800/75">
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        :class="{
                                                            'bg-lime-900 text-lime-300': batch.instructor_id,
                                                            'bg-red-900 text-red-300': !batch.instructor_id,
                                                        }"
                                                        class="me-1 inline-flex items-center rounded px-2 py-0.5 text-sm font-medium">
                                                        <svg class="h-5 w-5" fill="currentColor"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>school</title>
                                                            <path
                                                                d="M12,3L1,9L12,15L21,10.09V17H23V9M5,13.18V17.18L12,21L19,17.18V13.18L12,17L5,13.18Z" />
                                                        </svg>
                                                    </span>
                                                    <span
                                                        class="ms-0.5 inline-flex items-center rounded bg-sky-900 px-2 py-0.5 text-sm font-medium text-sky-300">
                                                        <span class="me-1 flex items-center">
                                                            <svg class="h-5 w-5" fill="currentColor"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>account-circle</title>
                                                                <path
                                                                    d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z" />
                                                            </svg>
                                                        </span>
                                                        <span class="font-sans" x-text="batch.enrollee_count"></span>
                                                    </span>
                                                    <span class="ms-2"
                                                        x-text="selectedCourse.code +'-'+ batch.name"></span>
                                                </div>
                                                <div class="flex">
                                                    <a class="h-7 w-7 cursor-pointer rounded-md p-1 hover:bg-gray-600"
                                                        @click="seeBatchData(batch.id); showBatchesModal = false">
                                                        <svg class="h-full w-full" fill="currentColor"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>eye-outline</title>
                                                            <path
                                                                d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('delete_batch') }}"
                                                        class="h-7 w-7 rounded-md p-1 hover:bg-red-900"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="batch_id" :value="batch.id">

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
                        <div role="status" x-show="dataLoading"
                            class="absolute inset-0 z-50 flex items-center justify-center bg-black/25">
                            <svg aria-hidden="true"
                                class="h-8 w-8 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Batch Data --}}
        <div x-cloak x-show="showBatchDataModal" x-transition:enter="transition ease-out duration-200"
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
                            Batch Information | <span class="text-xs"
                                x-text="`${selectedCourse.code}-${selectedBatch.name}`"></span>
                        </h3>
                        <button type="button" @click="showBatchDataModal = false; showBatchesModal = true;"
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
                    <div class="relative p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">

                                <div class="text-white">
                                    <div>
                                        <div class="mb-2">
                                            <span>Course: </span><span x-text="selectedCourse.name"></span>
                                        </div>

                                        <template x-if="!selectedBatch?.instructor">
                                            <div
                                                class="mb-2 flex items-center justify-between rounded-lg border border-gray-700 bg-gray-800 p-2">
                                                <div
                                                    class="flex items-center justify-between whitespace-nowrap rounded-lg p-2 text-white">
                                                    <img src="{{ asset('images/temporary/profile.png') }}"
                                                        class="h-12 w-12 rounded-full" alt="profile">
                                                    <div class="pl-3">
                                                        <h3 class="text-lg font-semibold text-white">No Instructor
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <a @click="seeAssignInstructor(selectedBatch?.id)"
                                                        class="cursor-pointer rounded border border-sky-700 px-2.5 py-1 text-sky-700 hover:bg-sky-700 hover:text-white">
                                                        Assign
                                                    </a>
                                                </div>
                                            </div>
                                        </template>

                                        <template x-if="selectedBatch?.instructor">
                                            <div
                                                class="mb-2 flex justify-between rounded-lg border border-gray-700 bg-gray-800 p-2 text-white">
                                                <div class="flex items-center whitespace-nowrap rounded-lg">
                                                    <img :src="'{{ asset('storage/instructor_files/') }}/' +
                                                    selectedBatch?.instructor?.user_id + '/' + selectedBatch?.instructor
                                                        ?.folder + '/' + selectedBatch?.instructor?.id_picture"
                                                        class="h-12 w-12 rounded-full" alt="profile">
                                                    <div class="pl-3">
                                                        <h3 class="text-lg font-semibold text-white"
                                                            x-text="`${selectedBatch?.instructor?.user.fname ?? ''} ${selectedBatch?.instructor?.user.lname ?? ''}`">
                                                        </h3>
                                                        <div class="font-normal text-gray-400"
                                                            x-text="selectedBatch?.instructor?.user.email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center">
                                                    <a @click="unassignInstructor(selectedBatch?.id)"
                                                        class="cursor-pointer rounded border border-pink-700 p-1 text-pink-700 hover:bg-pink-700 hover:text-white">
                                                        <svg class="h-4 w-4" fill="currentColor"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>minus</title>
                                                            <path d="M19,13H5V11H19V13Z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="selectedBatch?.enrollee?.length > 0">
                                            <div>
                                                <div class="rounded-t-lg bg-gray-800 p-2 text-sm text-white/50">
                                                    Trainees</div>
                                                <div class="text-white">
                                                    <template x-for="(enrollee, index) in selectedBatch.enrollee"
                                                        :key="enrollee.id">
                                                        <div
                                                            class="border-white/25 p-2 last:rounded-b-lg odd:bg-gray-800 even:bg-gray-800/75">
                                                            <div
                                                                x-text="`${enrollee.user.lname}, ${enrollee.user.fname} ${enrollee.user.mname ? enrollee.user.mname.charAt(0)+'.' : ''}`">
                                                            </div>
                                                            <div class="text-sm text-white/50"
                                                                x-text="enrollee.user.email">
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="status" x-show="dataLoading"
                            class="absolute inset-0 z-50 flex items-center justify-center bg-black/25">
                            <svg aria-hidden="true"
                                class="h-8 w-8 animate-spin fill-blue-600 text-gray-200 dark:text-gray-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instructors Modal --}}
        <div x-cloak x-show="showInstructorsModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative max-h-full w-full max-w-lg p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700">

                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div class="col-span-2">

                                <label for="instructors"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Select
                                    instructor</label>
                                <select id="instructor" x-model="selectedInstructorId"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                                    <option value="" selected>Choose instructor</option>
                                    <template x-for="instructor in instructors" :key="instructor.id">
                                        <option :value="instructor.id"
                                            x-text="`${instructor.user.fname} ${instructor.user.mname ? instructor.user.mname.charAt(0) + '.' : ''} ${instructor.user.lname}`">
                                        </option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4 px-4 pb-4 text-center">
                        <button @click="assignInstructor()" type="button"
                            class="basis-1/2 items-center rounded-lg bg-sky-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-sky-800">
                            Assign
                        </button>
                        <button
                            @click="showInstructorsModal = !showInstructorsModal; document.body.classList.remove('no-scroll');"
                            type="button"
                            class="basis-1/2 rounded-lg border border-gray-600 bg-gray-800 px-5 py-2.5 text-sm font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-md p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Edit
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="edit-modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="POST" action="{{ route('add_course') }}">
                    @csrf
                    <div class="mb-4 grid grid-cols-2 gap-4">
                        <div class="hidden"><input type="number" name="course_id" id="course_id"></div>
                        <div class="col-span-2">
                            <label for="name"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="edit_name"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Type course name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="code"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Code</label>
                            <input type="text" name="code" id="edit_code" maxlength="5"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Type course code (max: 5 characters)" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Training
                                Hours</label>
                            <input type="number" name="training_hours" id="edit_training_hours"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="Hours" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select name="category" id="edit_category"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <option selected="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Course
                                Description</label>
                            <textarea name="description" id="edit_description" rows="4"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Type course description"></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="mr-2 h-5 w-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m5 12 4.7 4.5 9.3-9" />
                        </svg>
                        <span class="mr-2">Save</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @section('script')
        <script type="text/javascript">
            function manageCourse() {
                return {
                    courses: @json($courses),
                    courseModal: false,
                    selectedCourse: [],
                    selectedBatch: [],
                    edit: false,
                    filepond: '',
                    modalTitle: '',
                    tempImage: @json($temp_image),
                    instructors: [],
                    selectedInstructorId: '',

                    // Modals
                    showBatchesModal: false,
                    showBatchDataModal: false,
                    showInstructorsModal: false,

                    // Loading Utility
                    xhr: null,
                    dataLoading: false,

                    init() {
                        console.log(this.courses);
                        this.filepondInit();
                        window.addEventListener('add-course-modal', () => {
                            this.addCourse();
                        });

                        @if (session('status'))
                            this.notification("{{ session('status') }}", "{{ session('message') }}",
                                "{{ session('title') ?? session('title') }}");
                        @endif
                    },
                    filepondInit() {
                        FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginGetFile);
                        const input_element = document.querySelector('#image');
                        this.filepond = FilePond.create(input_element);
                    },
                    addCourse() {
                        this.edit = false;
                        this.courseModal = true;
                        this.modalTitle = 'Create New Course'
                        $('#courseModalForm')[0].reset();
                        $('#course_id').val('');
                        this.selectedCourse = [];


                        document.body.classList.add('no-scroll');

                        var files = this.tempImage ? [{
                            source: this.tempImage['id'],
                            options: {
                                type: 'local',
                            },
                        }, ] : [];

                        this.filepond.setOptions({
                            labelIdle: `Drag & Drop image file or <span class="filepond--label-action">Browse</span>`,
                            name: 'image',
                            allowReorder: true,
                            allowImagePreview: true,
                            allowMultiple: false,
                            required: true,
                            files: files,

                            server: {
                                process: {
                                    url: '{{ route('upload_course_image') }}',
                                    ondata: (formData) => {
                                        return formData;
                                    },
                                },
                                revert: {
                                    url: '{{ route('revert_course_image') }}',
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                },
                                load: `load_course_image/create/`,
                                remove: (source, load, error) => {
                                    fetch(`delete_course_image/create/${source}`, {
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
                    editCourse(courseId) {
                        var course = this;
                        this.edit = true;
                        this.courseModal = true;
                        this.modalTitle = 'Edit Course';
                        this.selectedCourse = this.courses.filter(course => course.id === courseId);
                        // console.log(this.selectedCourse);
                        $('#name').val(this.selectedCourse[0].name)
                        $('#code').val(this.selectedCourse[0].code)
                        $('#training_hours').val(this.selectedCourse[0].training_hours)
                        $('#category').val(this.selectedCourse[0].course_category_id)
                        $('#description').val(this.selectedCourse[0].description)
                        $('#course_id').val(this.selectedCourse[0].id)
                        $('#registration_fee').val(this.selectedCourse[0].registration_fee)
                        $('#bond_deposit').val(this.selectedCourse[0].bond_deposit)
                        $('#' + this.selectedCourse[0].structure).prop('checked', true)
                        document.body.classList.add('no-scroll');

                        var files = this.selectedCourse[0].folder ? [{
                            source: this.selectedCourse[0].id,
                            options: {
                                type: 'local',
                            },
                        }, ] : []

                        this.filepond.setOptions({
                            labelIdle: `Drag & Drop image file or <span class="filepond--label-action">Browse</span>`,
                            name: 'image',
                            allowReorder: true,
                            allowImagePreview: true,
                            allowMultiple: false,
                            allowReplace: false,
                            files: files,

                            server: {
                                process: {
                                    url: '{{ route('upload_course_image') }}',
                                    ondata: (formData) => {
                                        return formData;
                                    },
                                },
                                revert: {
                                    url: '{{ route('revert_course_image') }}',
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                },
                                load: `load_course_image/edit/`,
                                remove: (source, load, error) => {
                                    fetch(`delete_course_image/edit/${source}`, {
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
                    courseToggle(course_id) {
                        this.abortFetch('ajax')
                        var thisFunction = this
                        this.selectedCourse = this.courses.filter(course => course.id === course_id)
                        // console.log(this.selectedCourse[0].name);
                        this.xhr = $.ajax({
                            url: '{{ route('course_toggle') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                course_id: course_id
                            },
                            success: function(response) {
                                thisFunction.selectedCourse[0].available = !thisFunction.selectedCourse[0]
                                    .available
                                thisFunction.notification('success', thisFunction.selectedCourse[0]
                                    .available ?
                                    'Enrollment resumed' : 'Enrollment stopped', thisFunction
                                    .selectedCourse[0].name)
                                // Update UI based on response
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    },
                    featureToggle(courseId) {
                        var thisFunction = this

                        var featuredCourses = this.courses.filter(course => course.featured);
                        this.selectedCourse = this.courses.find(course => course.id === courseId)

                        // Check if the selected course is already featured
                        if (this.selectedCourse.featured) {
                            // If the course is already featured, remove it from the featured list
                            this.abortFetch('ajax');
                            this.xhr = $.ajax({
                                url: '{{ route('feature_toggle') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    course_id: courseId
                                },
                                success: function(response) {
                                    thisFunction.selectedCourse.featured = false;
                                    thisFunction.notification('success', 'Course is removed from featured list',
                                        thisFunction.selectedCourse.name);
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {
                            // If not featured yet, check the number of featured courses
                            if (featuredCourses.length < 3) {
                                // Mark the course as featured
                                this.abortFetch('ajax');
                                this.xhr = $.ajax({
                                    url: '{{ route('feature_toggle') }}',
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        course_id: courseId
                                    },
                                    success: function(response) {
                                        thisFunction.selectedCourse.featured = true;
                                        thisFunction.notification('success', 'Course is now in featured list',
                                            thisFunction.selectedCourse.name);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            } else {
                                // If the limit is reached, notify the user and revert the checkbox
                                this.notification('error',
                                    `Sorry, the number of featured courses is limited to 3. Current: ${featuredCourses[0].name}, ${featuredCourses[1].name}, and ${featuredCourses[2].name}`,
                                    '');

                                this.$nextTick(() => {
                                    // Ensure Alpine.js reactivity updates the UI accordingly
                                    document.querySelector(`.feature-toggle-${courseId}`).checked = false;
                                });
                            }
                        }
                    },
                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message, title ??
                            title);
                    },
                    deleteCourseConfirmation(courseId) {
                        var form = event.target.closest('form');
                        // this.selectedCourse = this.selectedCourse.filter(course => course.id == courseId);

                        Swal.fire({
                            icon: 'warning',
                            title: "You won't be able to revert this!",
                            text: "Input your password to confirm",
                            input: "password",
                            inputAttributes: {
                                autocapitalize: "on"
                            },
                            showCancelButton: true,
                            confirmButtonText: "Delete this course",
                            showLoaderOnConfirm: true,
                            preConfirm: async (password) => {
                                try {
                                    const url = ` {{ route('delete_course') }} `;
                                    const response = await fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            course_id: courseId,
                                            password: password
                                        })
                                    });
                                    if (!response.ok) {
                                        const error = await response.json();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Failed',
                                            text: error.message
                                        });
                                        // throw new Error(error.message);
                                    }
                                    return response.json();
                                } catch (error) {
                                    Swal.showValidationMessage(`Request failed: ${error}`);
                                }
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    message: 'Course deleted successfully'
                                });

                                var index = this.courses.findIndex(course => course.id === courseId)
                                this.courses.splice(index, 1);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    message: 'Course not deleted'
                                });
                                console.log(result);

                            }
                        });

                    },
                    triggerBatchesModal(courseId) {
                        this.selectedCourse = this.courses.find(course => course.id === courseId)
                        this.abortFetch('ajax')
                        this.dataLoading = true
                        var t = this
                        this.xhr = $.ajax({
                            url: '{{ route('get_course_batches') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                course_id: courseId
                            },
                            success: function(response) {
                                console.log(response);
                                t.selectedCourse.batches = response.course.batches
                                t.dataLoading = false
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                        this.showBatchesModal = !this.showBatchesModal;
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
                    create_new_batch(courseId) {
                        // console.log(this.courses.find(course => course.id === courseId));
                        this.abortFetch('ajax')
                        var courses = this.courses
                        var i = this
                        this.xhr = $.ajax({
                            url: "{{ route('create_new_batch') }}",
                            type: "POST",
                            data: {
                                course_id: courseId, // Make sure this matches the request parameter in your Laravel method
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    let course = courses.find(course => course.id === courseId);
                                    if (course) {
                                        course.batches.push(response.new_batch)
                                    }

                                    i.notification(response.status, response.message, response.title)
                                } else {
                                    alert(response.message || 'Failed to create batch.');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle different error scenarios
                                let errorMessage = 'Error: ' + error;
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                alert(errorMessage);
                            }
                        });
                    },

                    // Batch Data Modal
                    seeBatchData(batchId) {
                        document.body.classList.add('no-scroll');
                        this.selectedBatch = this.selectedCourse.batches.find(batch => batch.id === batchId)
                        this.abortFetch('ajax')
                        this.dataLoading = true
                        var t = this
                        this.xhr = $.ajax({
                            url: '{{ route('get_batch_data') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                batch_id: batchId
                            },
                            success: function(response) {
                                console.log(response);
                                t.selectedBatch = response.batch
                                // t.selectedCourse.batches = response.course.batches
                                t.dataLoading = false
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                t.notification('error', 'Fetching batch data error. Please try again.', '')
                            }
                        });
                        this.showBatchDataModal = !this.showBatchDataModal;
                    },
                    unassignInstructor(batchId) {
                        // this.selectedBatch = this.selectedCourse.batches.find(batch => batch.id === batchId)
                        console.log(this.selectedBatch);
                        this.abortFetch('ajax')
                        this.dataLoading = true
                        var t = this
                        this.xhr = $.ajax({
                            url: '{{ route('unassign_instructor') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                batch_id: batchId
                            },
                            success: function(response) {
                                // console.log(response);

                                if (response.status == 'success') {
                                    t.selectedBatch.instructor_id = null
                                    t.selectedBatch.instructor = null
                                    let course = t.selectedCourse.batches.find(batch => batch.id === t.selectedBatch
                                        .id)
                                    course.instructor_id = null
                                }

                                // console.log(t.selectedBatch);

                                // t.selectedCourse.batches = response.course.batches
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                t.notification('error', 'Connection error', '')
                            }
                        });
                    },
                    seeAssignInstructor(batchId) {
                        this.abortFetch('ajax')
                        this.dataLoading = true
                        var t = this
                        this.xhr = $.ajax({
                            url: '{{ route('get_all_instructors') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                console.log(response);

                                t.instructors = response.instructors
                                console.log(t.instructors);

                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                t.notification('error', 'Connection error', '')
                            }
                        });
                        this.showInstructorsModal = true
                    },

                    // Assign Instructor Modal
                    assignInstructor() {
                        if (this.selectedInstructorId) {
                            this.abortFetch('ajax')
                            this.dataLoading = true
                            var t = this
                            this.xhr = $.ajax({
                                url: '{{ route('assign_instructor') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    batch_id: t.selectedBatch.id,
                                    instructor_id: t.selectedInstructorId
                                },
                                success: function(response) {
                                    console.log(response);
                                    if (response.status == 'success') {
                                        t.selectedBatch.instructor_id = response.instructor.id
                                        t.selectedBatch.instructor = response.instructor
                                        let course = t.selectedCourse.batches.find(batch => batch.id === t
                                            .selectedBatch.id)
                                        course.instructor_id = response.instructor.id

                                        var instructor = response.instructor
                                        t.notification('success',
                                            `${instructor.user.fname} ${instructor.user.mname ? instructor.user.mname.charAt(0) + '.' : ''} ${instructor.user.lname} is assigned to ${t.selectedBatch.name}`,
                                            'Instructor Assigning')
                                        t.showInstructorsModal = false
                                        t.selectedInstructorId = ''
                                    }

                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                    t.notification('error', 'Connection error', '')
                                }
                            });
                        } else {
                            this.notification('error', 'Select an instructor first', '')
                        }

                    },

                    // Utility
                    abortFetch(type) {
                        // Abort the current fetch request if there's an ongoing one
                        if (type == 'fetch') {
                            if (this.controller) {
                                this.controller.abort();
                            }
                        }

                        if (type == 'ajax') {
                            if (this.xhr) {
                                this.xhr.abort();
                            }
                        }
                    },

                }
            }
        </script>
    @endsection
</x-app-layout>
