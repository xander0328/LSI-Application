<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="flex-row items-center text-2xl font-semibold text-sky-950 dark:text-white md:flex md:space-x-1">
                <div>{{ __('Attendance') }}</div>
                <div class="hidden text-slate-600 md:block">|</div>
                <div class="text-sm font-normal leading-none text-sky-500 md:text-lg">{{ $enrollee->course->name }}</div>
            </div>
            <div class="hidden items-center md:flex">
                <div class="mr-4 flex space-x-1">
                    <div class="text-white/75"> Batch: </div>
                    <div>
                        {{ $enrollee->course->code }}-{{ $enrollee->batch->name }}
                    </div>
                </div>
            </div>
            <div class="flex items-center md:hidden">
                <x-dropdown width="40" align="right">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md p-1 hover:bg-gray-900/50">
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
                            <div class="my-2 flex justify-center space-x-1 text-xs">
                                <div class="text-white/75"> Batch: </div>
                                <div>
                                    {{ $enrollee->course->code }}-{{ $enrollee->batch->name }}
                                </div>
                            </div>
                            <x-course-nav :selected="'attendance'" :batch="$enrollee->batch->id"></x-course-nav>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div class="hidden md:block">

            <x-course-nav :selected="'attendance'" :batch="$enrollee->batch->id"></x-course-nav>
        </div>

    </x-slot>
    <div x-data="studentData()" id="course_list" class="mx-8 mt-2 pb-4 pt-44 text-black dark:text-white md:pt-48">
        <div x-cloak x-show="$store.sharedState.attendanceUpdate"
            class="p-4 mb-4 flex bg-white/80 rounded-lg items-center justify-between text-sm">
            <span>New Update</span>
            <span class="px-2 py-1 bg-sky-600 hover:bg-sky-700 rounded text-white">
                <a class="cursor-pointer" @click="location.reload()">REFRESH</a>
            </span>
        </div>
        <div class="mb-4 text-sm">
            <div class="mr-3 grid w-full grid-cols-1 items-center gap-2 text-xs md:grid-cols-3">
                <div class="flex w-full items-center">
                    <div class="whitespace-nowrap">Mode:</div>
                    <select x-model="filterMode" @change="filterRecords"
                        class="ms-1 w-full rounded-md bg-white px-2.5 py-1 text-xs dark:bg-gray-700">
                        <option value="">All</option>
                        <option value="online">Online</option>
                        <option value="f2f">Face-to-Face</option>
                    </select>
                </div>
                <div class="flex w-full items-center">
                    <div class="whitespace-nowrap">Sort by date:</div>
                    <select x-model="filterDate" @change="filterRecords"
                        class="ms-1 w-full rounded-md bg-white px-2.5 py-1 text-xs dark:bg-gray-700">
                        <option value="latest">Newest first</option>
                        <option value="oldest">Oldest first</option>
                    </select>
                </div>
                <div class="flex w-full items-center">
                    <div class="whitespace-nowrap">Status:</div>
                    <select x-model="filterStatus" @change="filterRecords"
                        class="ms-1 w-full rounded-md bg-white px-2.5 py-1 text-xs dark:bg-gray-700">
                        <option value="">All</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </div>

            </div>
        </div>
        <div x-show="filteredRecords.length > 0">
            <template x-for="record in filteredRecords" :key="record.id">
                <div
                    class="mb-2 rounded-md bg-white p-px hover:bg-slate-100 dark:bg-gray-800 dark:hover:bg-gray-800/75">

                    <div class="my-2 w-full rounded-md px-3 py-px">
                        <div class="flex w-full items-center justify-between">
                            <div class="flex w-full items-center justify-between">
                                <div class="flex gap-4">
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
                                        <div class="text-sm text-gray-500"
                                            x-text="moment(record.date, 'YYYY-MM-DD').calendar(null, {
                                            sameDay: '[Today]',
                                            lastDay: '[Yesterday]',
                                            lastWeek: '[Last] dddd',
                                            sameElse: ''
                                        })">
                                        </div>
                                        <div class="text-xs text-gray-500"
                                            x-text="'Created at: '+ moment(record.created_at).format('lll')">

                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div :class="{
                                        'bg-red-800': record.student_attendance?.status === 'absent',
                                        'bg-yellow-700': record.student_attendance.status === 'late',
                                        'bg-sky-800': record.student_attendance.status === 'present',
                                        'bg-gray-500': !record.student_attendance
                                    }"
                                        class="rounded-full px-3 py-1.5 text-xs text-white"
                                        x-text="record.student_attendance == null ? 'Not enrolled yet' : record.student_attendance?.status.charAt(0).toUpperCase() + record.student_attendance?.status.slice(1);">
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                            </div>
                        </div>

                    </div>

                </div>
            </template>
        </div>

    </div>
    @section('script')
        <script>
            function studentData() {
                return {
                    attendanceData: @json($attendance_records ?? ''),
                    filterMode: '',
                    filterStatus: '',
                    filterDate: 'latest',
                    filterRecords: '',
                    init() {

                        this.filterRecords();
                        console.log(this.attendanceData);
                    },
                    filterRecords() {
                        if (this.filterMode) {
                            this.filteredRecords = this.attendanceData.filter(record => record.mode === this.filterMode);
                        } else {
                            this.filteredRecords = [...this.attendanceData]; // Reset to original data if mode is empty
                        }

                        // Sort by date
                        if (this.filterDate === 'latest') {
                            this.filteredRecords.sort((a, b) => new Date(b.created_at) - new Date(a
                                .created_at)); // Newest first
                        } else if (this.filterDate === 'oldest') {
                            this.filteredRecords.sort((a, b) => new Date(a.created_at) - new Date(b
                                .created_at)); // Oldest first
                        }

                        // Filter by status
                        if (this.filterStatus) {
                            this.filteredRecords = this.filteredRecords.filter(record => record.student_attendance?.status ===
                                this.filterStatus);
                        }
                    },
                }

            }
        </script>
    @endsection
</x-app-layout>
