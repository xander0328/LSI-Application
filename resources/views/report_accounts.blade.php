<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Report') }}
            </div>
        </div>
    </x-slot>
    <div x-data="report" class="mx-4 pb-4 pt-40 text-black md:mx-8 dark:text-white">
        <div class="rounded-lg bg-white p-4 shadow-md">
            <div class="mb-2 grid grid-cols-4 gap-6">
                <div class="flex items-center space-x-2">
                    <label for="role" class="block text-sm font-bold text-gray-900 dark:text-white">Role</label>
                    <select id="role" x-model="role" @change="console.log(role)"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        <option value="" selected>All</option>
                        <option value="student">Student</option>
                        <option value="guest">Guest</option>
                        <option value="instructor">Instructor</option>
                    </select>
                </div>
                <div class="col-span-2 flex w-full items-center space-x-2">
                    <label for="course"
                        class="block whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">Date
                        Created</label>
                    <div class="relative w-full">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="datepicker-account-created-from" type="text"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="From">
                    </div>
                    <span>
                        -

                    </span>
                    <div class="relative w-full">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="datepicker-account-created-to" type="text"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="To">
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <label for="status" class="block text-sm font-bold text-gray-900 dark:text-white">Status</label>
                    <select id="status"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        <option value="" selected>All</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div x-cloak x-show="role === 'student'" class="mt-4">
                <div class="mb-2 flex items-center">
                    <span class="me-2 whitespace-nowrap text-sm font-light">
                        Advanced Filters
                    </span>
                    <hr class="w-full">

                </div>
                <div class="grid grid-cols-4 gap-6">
                    <div class="flex items-center space-x-2">
                        <label for="course"
                            class="block text-sm font-bold text-gray-900 dark:text-white">Course</label>
                        <select id="course"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option selected>All</option>
                            <template x-for="courses in course_list">
                                <option :value="course.id" x-text="course.name"></option>
                            </template>
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="student_status"
                            class="block whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">Student
                            Status</label>
                        <select id="student_status" x-model="student_status"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option value="" selected>All</option>
                            <option value="completed" selected>Completed</option>
                            <option value="incomplete" selected>Incomplete</option>
                        </select>
                    </div>
                    <div x-show="student_status === 'completed'" class="flex items-center space-x-2">
                        <label for="completed-datepicker"
                            class="block whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">Completed
                            at</label>
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="completed-at-datepicker" type="text"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Select Date">
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label for="completed-datepicker"
                            class="block whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">Batch
                            Started</label>
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="course-started-datepicker" type="text"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Select Date">
                        </div>
                    </div>

                </div>
            </div>
            <div class="mt-2">
                <button class="w-full rounded-lg bg-cyan-400 p-1">Load</button>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function report() {
                return {
                    role: '',
                    student_status: '',
                    course_list: [],
                    init() {
                        const dpAccountCreatedFrom = flatpickr("#datepicker-account-created-from", {
                            dateFormat: "Y-m-d",
                            onChange: function(selectedDates) {
                                dpAccountCreatedTo.set('minDate', selectedDates[0]);
                            }
                        });

                        const dpAccountCreatedTo = flatpickr("#datepicker-account-created-to", {
                            dateFormat: "Y-m-d",
                        });

                        const dpStudentCompletedAt = flatpickr("#completed-at-datepicker", {
                            dateFormat: "Y-m-d",
                        });
                        const dpStudentCourseStarted = flatpickr("#course-started-datepicker", {
                            dateFormat: "Y-m-d",
                        });
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
