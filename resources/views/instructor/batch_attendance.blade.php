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
                        <div class="m-1.5 flex-row">
                            <div class="my-2 flex justify-center text-xs space-x-1">
                                <div class="text-white/75"> Batch: </div>
                                <div>
                                    {{ $batch->course->code }}-{{ $batch->name }}
                                </div>
                            </div>
                            <x-course-nav :selected="'attendance'" :batch="$batch->id"></x-course-nav>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div class="hidden md:block">

            <x-course-nav :selected="'attendance'" :batch="$batch->id"></x-course-nav>
        </div>

    </x-slot>
    <div x-data="studentData()" id="course_list" class="mx-4 md:mx-8 mt-2 pt-44 md:pt-48  text-white">
        {{-- <div class="mb-2 flex">
            <a @click="createNew()"
                class="block cursor-pointer rounded-md bg-sky-700 px-4 py-2 text-sm hover:bg-sky-800 hover:text-white">Create
                New</a>
        </div> --}}
        <div class="mb-2">
            <div class="mr-3 flex w-full items-center text-sm">
                <div class="me-1.5 whitespace-nowrap">Mode</div>
                <select x-model="filterMode" @change="filterRecords"
                    class="md:w-1/3 w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                    <option value="">All</option>
                    <option value="online">Online</option>
                    <option value="f2f">Face-to-Face</option>
                </select>

            </div>
        </div>
        <div x-show="filteredRecords.length > 0">
            <template x-for="record in filteredRecords" :key="record.id">
                <div class="mb-2 rounded-md bg-gray-800 p-px hover:bg-gray-800/75">

                    <div class="my-2 w-full rounded-md px-3 py-px">
                        <a @click="getRecordData(record)" class="cursor-pointer"
                            class="flex items-center justify-between">
                            <div class="flex items-center justify-start gap-4">
                                <div>
                                    <div :class="record.mode == 'online' ? 'bg-sky-700' : 'bg-yellow-700'"
                                        class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full p-2">
                                        <template x-if="record.mode === 'online'">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill="white"
                                                    d="M4,6H20V16H4M20,18A2,2 0 0,0 22,16V6C22,4.89 21.1,4 20,4H4C2.89,4 2,4.89 2,6V16A2,2 0 0,0 4,18H0V20H24V18H20Z" />
                                            </svg>
                                        </template>
                                        <template x-if="record.mode === 'f2f'">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill="white"
                                                    d="M20 17C21.1 17 22 16.1 22 15V4C22 2.9 21.1 2 20 2H9.5C9.8 2.6 10 3.3 10 4H20V15H11V17M15 7V9H9V22H7V16H5V22H3V14H1.5V9C1.5 7.9 2.4 7 3.5 7H15M8 4C8 5.1 7.1 6 6 6S4 5.1 4 4 4.9 2 6 2 8 2.9 8 4M17 6H19V14H17V6M14 10H16V14H14V10M11 10H13V14H11V10Z" />
                                            </svg>
                                        </template>
                                    </div>

                                </div>
                                <div class="w-full font-medium dark:text-white">
                                    <div x-text="moment(record.date).format('MMM D, YYYY')"></div>
                                    <div class="text-xs text-gray-500"
                                        x-text="moment(record.date, 'YYYY-MM-DD').calendar(null, {
                                        sameDay: '[Today]',
                                        lastDay: '[Yesterday]',
                                        lastWeek: '[Last] dddd',
                                        sameElse: ''
                                    })">
                                    </div>
                                    <div class="text-xs text-gray-500" x-text="`Created at: `+ record.date">
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                            </div>
                        </a>

                    </div>

                </div>
            </template>
        </div>
        <template x-if="filteredRecords.length == 0">
            <div class="bg-gray-700/35 mt-2.5 rounded-md p-2.5 text-center text-sm text-gray-300">No Record
            </div>
        </template>

        {{-- Create Modal --}}
        <div x-cloak x-show="openModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div @click.away="openModal = false" class="relative max-h-full w-full max-w-2xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white"
                                x-text="selectedDate ? 'Edit Attendance Record' : 'Create New Attendance Record'">
                            </h3>
                            <div class="text-xs">Date: <span class="text-gray-300"
                                    x-text="selectedDate ? moment(selectedDate).format('MMM D, YYYY') : moment().format('MMM D, YYYY')"></span>
                            </div>
                        </div>
                        <button type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                            @click="triggerModal()">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <div class="mx-2 ">
                        <div class="flex p-2 text-sm">
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div
                                    class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input autocomplete="off" type="text" @input="searchStudent($event)"
                                    id="table-search"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Search">
                            </div>
                            <button @click="clearSearch()"
                                class="ml-2 rounded-md bg-blue-500 px-3 py-1.5 text-white hover:bg-blue-600">
                                Clear
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-2 items-center p-2">
                            <div class="flex col-span-2 md:col-span-1 items-center text-sm">
                                <div class="me-1.5 whitespace-nowrap">Sort by:</div>
                                <select x-model="sortColumn" @change="sortColumnChanged" id="sort_by"
                                    class="w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                                    <option value="last_name">
                                        Surname
                                    </option>
                                    <option value="first_name">First name
                                    </option>
                                </select>

                            </div>
                            <div class="flex col-span-2 md:col-span-1 w-full items-center text-sm">
                                <div class="me-1.5">Action:</div>
                                <select x-model="selectedAction" id="action_dropdown"
                                    class="w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                                    <option value="">Select Action</option>
                                    <option value="absent">Mark Absent</option>
                                    <option value="late">Mark Late</option>
                                    <option value="present">Mark Present</option>
                                </select>
                                <button @click="updateCheckedStudents()"
                                    class="ml-2 rounded-md bg-blue-500 px-3 py-1.5 text-white hover:bg-blue-600">
                                    Apply
                                </button>
                            </div>

                        </div>
                        <div class="p-2 ">
                            <div class="rounded-md">
                                <table
                                    class="w-full rounded-md text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                                    <thead class="bg-gray-900 text-xs  uppercase text-white">
                                        <tr>
                                            <th scope="col" class="p-4">
                                                <div class="flex items-center">
                                                    <input id="checkbox-all-search" type="checkbox"
                                                        @change="toggleAllCheckboxes($event)"
                                                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                                </div>
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Student
                                            </th>
                                            <th scope="col" class="hidden md:table-cell px-6 py-3">
                                                Status
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody x-cloak>
                                        <template x-if="students.length === 0">
                                            <tr class="text-gray-400">
                                                <td colspan="3" class="p-4 text-center">No data</td>
                                            </tr>
                                        </template>
                                        <template x-for="(student, index) in students" :key="student.id">
                                            <tr class="border-gray-700 bg-gray-800 hover:bg-gray-800/50">
                                                <td @click="student.isChecked = !student.isChecked" class="w-4 p-4">
                                                    <div class="flex items-center">
                                                        <input x-model="student.isChecked"
                                                            id="checkbox-table-search-1" type="checkbox"
                                                            class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                                        <label for="checkbox-table-search-1"
                                                            class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <th scope="row"
                                                    class=" px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                    <div @click="student.isChecked = !student.isChecked"
                                                        x-text="student.last_name + ', ' + student.first_name">

                                                    </div>
                                                    <select x-model="student.status"
                                                        @change="updateStudentStatus(student.id, $event.target.value)"
                                                        id="sort_by"
                                                        :class="{
                                                            'bg-red-800 text-white': student.status === 'absent',
                                                            'bg-yellow-700 text-white': student.status === 'late',
                                                            'bg-sky-800 text-white': student.status === 'present',
                                                        }"
                                                        class="w-full mt-1.5 md:hidden rounded-md bg-gray-700 px-2.5 py-1 text-xs md:text-sm text-white">
                                                        <option value="absent">Absent</option>
                                                        <option value="late">Late</option>
                                                        <option value="present">Present</option>
                                                    </select>
                                                </th>
                                                <td class="px-6 py-4 hidden md:table-cell">
                                                    <select x-model="student.status"
                                                        @change="updateStudentStatus(student.id, $event.target.value)"
                                                        id="sort_by"
                                                        :class="{
                                                            'bg-red-800 text-white': student.status === 'absent',
                                                            'bg-yellow-700 text-white': student.status === 'late',
                                                            'bg-sky-800 text-white': student.status === 'present',
                                                        }"
                                                        class="w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                                                        <option value="absent">Absent</option>
                                                        <option value="late">Late</option>
                                                        <option value="present">Present</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </template>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="p-2 pb-4 pt-0">
                            <button @click="submitStudentData"
                                class="w-full rounded-lg border border-blue-600 bg-blue-500 px-4 py-2 text-sm text-white hover:bg-blue-600">
                                Save Record
                            </button>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- Edit Modal --}}
        <div x-cloak x-show="editRecordModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div @click.away="editRecordModal = false" class="relative max-h-full w-full max-w-2xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white"
                                x-text="selectedDate ? 'Edit Attendance Record' : 'Create New Attendance Record'">
                            </h3>
                            <div class="text-xs">Date: <span class="text-gray-300"
                                    x-text="selectedDate ? moment(selectedDate).format('MMM D, YYYY') : moment().format('MMM D, YYYY')"></span>
                            </div>
                        </div>
                        <button type="button"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                            @click="editRecordModal = false; editInitialStudents = []">
                            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <div class="mx-2">
                        <div class="flex p-2 text-sm">
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div
                                    class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input autocomplete="off" type="text" @input="searchStudent($event)"
                                    id="table-search"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Search">
                            </div>
                            <button @click="clearSearch()"
                                class="ml-2 rounded-md bg-blue-500 px-3 py-1.5 text-white hover:bg-blue-600">
                                Clear
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-2 items-center p-2">
                            <div class="flex col-span-2 md:col-span-1 items-center text-sm">
                                <div class="me-1.5 whitespace-nowrap">Sort by:</div>
                                <select x-model="sortColumn" @change="sortColumnChanged" id="sort_by"
                                    class="w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                                    <option value="last_name">
                                        Surname
                                    </option>
                                    <option value="first_name">First name
                                    </option>
                                </select>

                            </div>
                            <div class="flex col-span-2 md:col-span-1 w-full items-center text-sm">
                                <div class="me-1.5">Action:</div>
                                <select x-model="selectedAction" id="action_dropdown"
                                    class="w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                                    <option value="">Select Action</option>
                                    <option value="absent">Mark Absent</option>
                                    <option value="late">Mark Late</option>
                                    <option value="present">Mark Present</option>
                                </select>
                                <button @click="updateCheckedStudents()"
                                    class="ml-2 rounded-md bg-blue-500 px-3 py-1.5 text-white hover:bg-blue-600">
                                    Apply
                                </button>
                            </div>

                        </div>
                        <div class="p-2">
                            <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                                <thead class="bg-gray-900 text-xs uppercase text-white">
                                    <tr>
                                        <th scope="col" class="p-4">
                                            <div class="flex items-center">
                                                <input id="checkbox-all-search" type="checkbox"
                                                    @change="toggleAllCheckboxes($event)"
                                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Student
                                        </th>
                                        <th scope="col" class="hidden md:table-cell px-6 py-3">
                                            Status
                                        </th>

                                    </tr>
                                </thead>
                                <tbody x-cloak>
                                    <template x-if="students.length === 0">
                                        <tr class="text-gray-400">
                                            <td colspan="3" class="p-4 text-center">No data</td>
                                        </tr>
                                    </template>
                                    <template x-for="(student, index) in students" :key="student.id">
                                        <tr class="border-gray-700 bg-gray-800 hover:bg-gray-800/50">
                                            <td @click="student.isChecked = !student.isChecked" class="w-4 p-4">
                                                <div class="flex items-center">
                                                    <input x-model="student.isChecked" id="checkbox-table-search-1"
                                                        type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                                    <label for="checkbox-table-search-1"
                                                        class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            <th scope="row"
                                                class=" px-6 py-4 font-medium text-gray-900 dark:text-white">
                                                <div @click="student.isChecked = !student.isChecked"
                                                    x-text="student.last_name + ', ' + student.first_name">

                                                </div>
                                                <select x-model="student.status"
                                                    @change="updateStudentStatus(student.id, $event.target.value)"
                                                    id="sort_by"
                                                    :class="{
                                                        'bg-red-800 text-white': student.status === 'absent',
                                                        'bg-yellow-700 text-white': student.status === 'late',
                                                        'bg-sky-800 text-white': student.status === 'present',
                                                    }"
                                                    class="w-full mt-1.5 md:hidden rounded-md bg-gray-700 px-2.5 py-1 text-xs md:text-sm text-white">
                                                    <option value="absent">Absent</option>
                                                    <option value="late">Late</option>
                                                    <option value="present">Present</option>
                                                </select>
                                            </th>
                                            <td class="hidden md:table-cell px-6 py-4">
                                                <select x-model="student.status"
                                                    @change="updateStudentStatus(student.id, $event.target.value)"
                                                    id="sort_by"
                                                    :class="{
                                                        'bg-red-800 text-white': student.status === 'absent',
                                                        'bg-yellow-700 text-white': student.status === 'late',
                                                        'bg-sky-800 text-white': student.status === 'present',
                                                    }"
                                                    class="w-full rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
                                                    <option value="absent">Absent</option>
                                                    <option value="late">Late</option>
                                                    <option value="present">Present</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </template>

                                </tbody>
                            </table>
                        </div>
                        <div class="p-2 pb-4 pt-0">
                            <button @click="submitStudentData"
                                class="w-full rounded-lg border border-blue-600 bg-blue-500 px-4 py-2 text-sm text-white hover:bg-blue-600">
                                Save Record
                            </button>
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
                    <button type="button" @click="createNew()"
                        class="h-[56px] w-[56px] rounded-lg border border-gray-200 bg-white text-gray-500 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-400">
                        <svg class="mx-auto mb-1 h-4 w-4" fill="currentColor"xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24">
                            <title>note-edit-outline</title>
                            <path
                                d="M18.13 12L19.39 10.74C19.83 10.3 20.39 10.06 21 10V9L15 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.89 21 5 21H11V19.13L11.13 19H5V5H12V12H18.13M14 4.5L19.5 10H14V4.5M19.13 13.83L21.17 15.87L15.04 22H13V19.96L19.13 13.83M22.85 14.19L21.87 15.17L19.83 13.13L20.81 12.15C21 11.95 21.33 11.95 21.53 12.15L22.85 13.47C23.05 13.67 23.05 14 22.85 14.19Z" />
                        </svg>
                        <span class="mb-px block text-xs font-medium">New Record</span>
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
    @section('script')
        <script>
            function date() {
                return {
                    data: '',
                    init() {
                        flatpickr(this.$refs.datePicker, {
                            altInput: true,
                            altFormat: "F j, Y",
                            dateFormat: "Y-m-d",
                        })
                    }
                }
            }
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

            function studentData() {
                return {
                    openModal: false,
                    initialStudents: [
                        @foreach ($students as $student)
                            {
                                id: {{ $student->id }},
                                first_name: '{{ $student->user->fname }}',
                                last_name: '{{ $student->user->lname }}',
                                status: 'absent',
                                isChecked: false,
                            },
                        @endforeach
                    ],
                    editInitialStudents: [],
                    students: [],
                    batch: @json($batch ?? ''),
                    sortColumn: 'last_name',
                    sortDirection: 'desc',
                    selectedAction: null,
                    sortColumnChanged() {
                        // Toggle the sort direction
                        // this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                        // Perform the sort
                        console.log();

                        if (this.editInitialStudents.length == 0) {
                            var initStudents = this.initialStudents
                        } else {
                            var initStudents = this.editInitialStudents
                        }

                        this.sortStudents();
                        this.students = initStudents;
                    },
                    sortStudents() {
                        if (this.editInitialStudents.length == 0) {
                            var initStudents = this.initialStudents
                        } else {
                            var initStudents = this.editInitialStudents
                        }

                        initStudents.sort((a, b) => {
                            let modifier = this.sortDirection === 'desc' ? 1 : -1;
                            if (a[this.sortColumn] < b[this.sortColumn]) return -1 * modifier;
                            if (a[this.sortColumn] > b[this.sortColumn]) return 1 * modifier;
                            return 0;
                        });
                    },
                    init() {
                        // this.originalStudents = this.students;
                        this.sortStudents();

                        // this.filteredRecords = this.attendanceData;
                        console.log(this.filteredRecords)
                        this.filterRecords();
                    },
                    updateStudentStatus(studentId, status) {
                        // let student = this.students.find(student => student.id == studentId);
                        // student.status = status;
                        if (this.editInitialStudents.length == 0) {
                            var initStudents = this.initialStudents
                        } else {
                            var initStudents = this.editInitialStudents
                        }

                        let student = initStudents.find(student => student.id == studentId);
                        student.status = status;
                        console.log(this.students);
                    },
                    updateCheckedStudents() {
                        if (this.selectedAction) {
                            this.students.forEach(student => {
                                if (student.isChecked) {
                                    student.status = this.selectedAction;
                                }
                            });
                        }
                    },
                    toggleAllCheckboxes(event) {
                        const checked = event.target.checked;
                        this.students.forEach(student => student.isChecked = checked);
                        // console.log(this.students);
                    },
                    searchStudent(event) {
                        const searchTerm = event.target.value.toLowerCase().trim();
                        if (this.editInitialStudents.length == 0) {
                            var initStudents = this.initialStudents
                        } else {
                            var initStudents = this.editInitialStudents
                        }

                        if (searchTerm) {
                            this.students = initStudents.filter(student => {
                                const fullName = `${student.first_name} ${student.last_name}`.toLowerCase();
                                return fullName.includes(searchTerm);
                            });
                        } else {
                            this.students = JSON.parse(JSON.stringify(initStudents));
                        }
                    },
                    clearSearch() {
                        if (this.editInitialStudents.length == 0) {
                            var initStudents = this.initialStudents
                        } else {
                            var initStudents = this.editInitialStudents
                        }

                        $('#table-search').val('')
                        $('#table-search-edit').val('')
                        this.students = JSON.parse(JSON.stringify(initStudents));
                    },
                    async submitStudentData() {
                        try {
                            const response = await fetch('/save_attendance', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure you have CSRF protection
                                },
                                body: JSON.stringify({
                                    students: this.students,
                                    batch_id: '{{ $batch->id }}',
                                    date: this.selectedDate,
                                    mode: 'online',
                                    selected_id: this.selectedID
                                })
                            });

                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }

                            const data = await response.json();
                            location.reload();
                        } catch (error) {
                            console.error('There was a problem with the fetch operation:', error);
                            alert('Failed to submit data.');
                        }
                    },
                    createNew() {
                        this.selectedDate = '';
                        this.selectedID = '';
                        this.students = []
                        this.initialStudents.map(student => student.status = 'absent')
                        var initial = JSON.parse(JSON.stringify(this.initialStudents));
                        this.students = initial;
                        this.triggerModal()
                        console.log(this.students);
                        console.log(this.initialStudents);

                    },

                    filterMode: '',
                    attendanceData: [
                        @if ($attendances)
                            @foreach ($attendances as $attendance)
                                {
                                    id: {{ $attendance->id }},
                                    batch_id: {{ $attendance->batch_id }},
                                    date: '{{ $attendance->date }}',
                                    mode: '{{ $attendance->mode }}',
                                },
                            @endforeach
                        @endif
                    ],
                    filteredRecords: [], // Store the filtered records
                    selectedDate: '',
                    selectedAttendanceID: '',
                    filterRecords() {
                        if (this.filterMode) {
                            this.filteredRecords = this.attendanceData.filter(record => record.mode === this.filterMode);
                        } else {
                            this.filteredRecords = this.attendanceData;
                        }
                        console.log(this.filteredRecords);
                    },

                    editRecordModal: false,
                    getRecordData(record) {
                        this.students = [];
                        fetch('{{ route('get_attendance_data') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    id: record.id
                                })
                            })
                            .then(response => response.json())
                            .then(data => {

                                let dataArray = Object.values(data);
                                this.selectedDate = record.date
                                this.selectedID = record.id

                                // Update the studentData().students with the updated students array
                                this.students = dataArray;
                                this.editInitialStudents = this.students;
                                // this.init();
                            })
                            .catch(error => {
                                console.error('Error fetching attendance data:', error);
                            });
                        this.editRecordModal = true;
                    },

                    triggerModal() {
                        this.openModal = !this.openModal;
                        // console.log(this.openModal);
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
