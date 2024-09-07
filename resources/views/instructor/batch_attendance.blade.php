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
        <x-course-nav :selected="'attendance'" :batch="$batch->id"></x-course-nav>

    </x-slot>
    <div x-data="studentData()" id="course_list" class="mx-8 mt-2 pb-4 pt-44 text-white">
        <div class="mb-2 flex">
            <a @click="createNew()"
                class="block cursor-pointer rounded-md bg-sky-700 px-4 py-2 text-sm hover:bg-sky-800 hover:text-white">Create
                New</a>
        </div>
        <div class="mb-2">
            <div class="mr-3 flex w-full items-center text-sm">
                <div class="me-1.5 whitespace-nowrap">Mode:</div>
                <select x-model="filterMode" @change="filterRecords"
                    class="w-1/3 rounded-md bg-gray-700 px-2.5 py-1 text-sm text-white">
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
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                            </div>
                        </a>

                    </div>

                </div>
            </template>
        </div>

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

                    <div class="">
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
                        <div class="ms-2 flex items-center p-2">
                            <div class="mr-3 flex w-full items-center text-sm">
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
                            <div class="flex w-full items-center text-sm">
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
                                        <th scope="col" class="px-6 py-3">
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
                                    <template x-for="students in sortedStudents" :key="students.id">
                                        <tr class="border-gray-700 bg-gray-800 hover:bg-gray-800/50">
                                            <td @click="students.isChecked = !students.isChecked" class="w-4 p-4">
                                                <div class="flex items-center">
                                                    <input x-model="students.isChecked" id="checkbox-table-search-1"
                                                        type="checkbox"
                                                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                                    <label for="checkbox-table-search-1"
                                                        class="sr-only">checkbox</label>
                                                </div>
                                            </td>
                                            <th @click="students.isChecked = !students.isChecked" scope="row"
                                                x-text="students.last_name + ', ' + students.first_name"
                                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            </th>
                                            <td class="px-6 py-4">
                                                <select x-model="students.status"
                                                    @change="updateStudentStatus(students, $event.target.value)"
                                                    id="sort_by"
                                                    :class="{
                                                        'bg-red-800 text-white': students.status === 'absent',
                                                        'bg-yellow-700 text-white': students.status === 'late',
                                                        'bg-sky-800 text-white': students.status === 'present',
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
                    students: [
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
                    sortColumn: 'last_name',
                    sortDirection: 'desc',
                    selectedAction: null,
                    originalStudents: [],
                    sortColumnChanged() {
                        // Toggle the sort direction
                        // this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                        // Perform the sort
                        this.sortStudents();
                    },
                    sortStudents() {
                        this.students.sort((a, b) => {
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
                        this.filterRecords();
                    },
                    get sortedStudents() {
                        return this.students;
                    },
                    updateStudentStatus(student, status) {
                        student.status = status;
                        // console.log(this.students);
                    },
                    updateCheckedStudents() {
                        if (this.selectedAction) {
                            this.students.forEach(student => {
                                if (student.isChecked) {
                                    student.status = this.selectedAction;
                                }
                            });
                        }
                        // console.log(this.students);
                    },
                    toggleAllCheckboxes(event) {
                        const checked = event.target.checked;
                        this.students.forEach(student => student.isChecked = checked);
                        // console.log(this.students);
                    },
                    searchStudent(event) {
                        const searchTerm = event.target.value.toLowerCase().trim();
                        if (searchTerm) {
                            this.students = this.originalStudents.filter(student => {
                                const fullName = `${student.first_name} ${student.last_name}`.toLowerCase();
                                return fullName.includes(searchTerm);
                            });
                        } else {
                            this.students = this.originalStudents;
                        }
                    },
                    clearSearch() {
                        $('#table-search').val('')
                        this.students = this.originalStudents;
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
                        this.students = this.initialStudents
                        this.triggerModal()
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
                                this.originalStudents = this.students;
                                // this.init();
                            })
                            .catch(error => {
                                console.error('Error fetching attendance data:', error);
                            });
                        this.triggerModal();
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
