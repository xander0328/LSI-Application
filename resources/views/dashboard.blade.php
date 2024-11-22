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
                {{ __('Dashboard') }}
            </div>
        </div>

    </x-slot>
    <div x-data="dashboard" id="main-div" class="pt-40 pb-4 mx-4 text-black dark:text-white md:mx-8">
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="flex flex-col col-span-full md:col-span-1">
                <div class="flex items-center justify-center p-2 mb-3 text-white rounded-lg basis-2/3 bg-sky-600">
                    <div>
                        <div class="py-2 text-center">PLATFORM USERS</div>
                        <canvas id="web-users-chart"></canvas>
                    </div>
                </div>
                <div class="flex flex-col gap-3 basis-1/3 ">
                    <div class="flex flex-col h-full p-4 bg-white rounded-lg dark:bg-gray-700">
                        <div class="mb-2">
                            <span>
                                NEW USERS
                            </span>
                            <span>

                            </span>
                        </div>
                        <div class="grid h-full grid-cols-3 gap-2">
                            <div class="flex flex-col p-2 rounded bg-gray-800/25">
                                <div class="text-sm text-center text-slate-600 dark:text-white/50">Today</div>
                                <div class="flex items-center justify-center h-full text-xl font-bold lg:text-2xl">
                                    {{ $today_users }}</div>
                            </div>
                            <div class="flex flex-col p-2 rounded bg-gray-800/25">
                                <div class="text-sm text-center text-slate-600 dark:text-white/50">This Month</div>
                                <div class="flex items-center justify-center h-full text-xl font-bold lg:text-2xl">
                                    {{ $month_users }}</div>
                            </div>
                            <div class="flex flex-col p-2 rounded bg-gray-800/25">
                                <div class="text-sm text-center text-slate-600 dark:text-white/50">This Year</div>
                                <div class="flex items-center justify-center h-full text-xl font-bold lg:text-2xl">
                                    {{ $year_users }}</div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="flex flex-col p-4 bg-white rounded-lg basis-1/2 dark:bg-gray-700">
                        <div class="">
                            <span>
                                ENROLLEES
                            </span>
                        </div>
                        <div class="my-1">
                            <span class="mb-2">
                                <select name="enrollment_mode" id="enrollment_mode" x-model="enrollmentMode"
                                    @change="enrollmentModeChanged"
                                    class="block w-full px-2 py-1 text-xs text-gray-900 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 bg-gray-50 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </span>
                            <span>
                                <select name="enrollment_mode" id="enrollment_mode" x-model="enrollmentMode"
                                    @change="enrollmentModeChanged"
                                    class="block w-full px-2 py-1 text-xs text-gray-900 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 bg-gray-50 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </span>
                        </div>
                        <div class="grid h-full grid-cols-3 gap-2">
                            <div class="flex flex-col p-2 rounded bg-gray-800/25">
                                <div class="text-sm text-center text-slate-600 dark:text-white/50">Today</div>
                                <div class="flex items-center justify-center h-full text-xl font-bold lg:text-2xl">
                                    {{ $enrollees['today']->count() }}</div>
                            </div>
                            <div class="flex flex-col p-2 rounded bg-gray-800/25">
                                <div class="text-sm text-center text-slate-600 dark:text-white/50">This Month</div>
                                <div class="flex items-center justify-center h-full text-xl font-bold lg:text-2xl">
                                    {{ $enrollees['month']->count() }}</div>
                            </div>
                            <div class="flex flex-col p-2 rounded bg-gray-800/25">
                                <div class="text-sm text-center text-slate-600 dark:text-white/50">This Year</div>
                                <div class="flex items-center justify-center h-full text-xl font-bold lg:text-2xl">
                                    {{ $enrollees['year']->count() }}</div>
                            </div>
                        </div>

                    </div> --}}
                </div>
            </div>
            <div class="gap-3 col-span-full md:col-span-2">
                <div class="p-4 mb-3 bg-white rounded-lg dark:bg-gray-700">
                    <div class="flex items-center justify-between mb-2">
                        <span>
                            COURSES / PROGRAMS
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div
                            class="flex items-center justify-between rounded-md border border-gray-800/25 bg-gray-800/25 px-1.5 py-2 hover:border-sky-500">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="p-2 text-white rounded-full bg-sky-700">
                                    <svg class="h-7 w-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
                                        <title>archive-clock</title>
                                        <path
                                            d="M20 6H2V2H20V6M16.5 12H15V17L18.61 19.16L19.36 17.94L16.5 16.25V12M23 16C23 19.87 19.87 23 16 23C13.62 23 11.53 21.81 10.26 20H3V7H19V9.68C21.36 10.81 23 13.21 23 16M8 12H10.26C10.83 11.19 11.56 10.5 12.41 10H8.5C8.22 10 8 10.22 8 10.5V12M21 16C21 13.24 18.76 11 16 11S11 13.24 11 16 13.24 21 16 21 21 18.76 21 16Z" />
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-white/50">
                                        Ongoing Enrollment
                                    </div>
                                    <div class="text-lg font-bold">
                                        {{ $ongoing_courses }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between rounded-md border border-gray-800/25 bg-gray-800/25 px-1.5 py-2 hover:border-sky-500">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="p-2 text-white rounded-full bg-sky-700">
                                    <svg class="h-7 w-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
                                        <title>bookshelf</title>
                                        <path
                                            d="M9 3V18H12V3H9M12 5L16 18L19 17L15 4L12 5M5 5V18H8V5H5M3 19V21H21V19H3Z" />
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-white/50">
                                        All Courses
                                    </div>
                                    <div class="text-lg font-bold">
                                        {{ $all_courses }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between rounded-md border border-gray-800/25 bg-gray-800/25 px-1.5 py-2 hover:border-sky-500">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="p-2 text-white rounded-full bg-sky-700">
                                    <svg class="h-7 w-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
                                        <title>bookshelf</title>
                                        <path
                                            d="M9 3V18H12V3H9M12 5L16 18L19 17L15 4L12 5M5 5V18H8V5H5M3 19V21H21V19H3Z" />
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-white/50">
                                        Active Batches
                                    </div>
                                    <div class="text-lg font-bold">
                                        {{ $active_batches }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-center justify-between rounded-md border border-gray-800/25 bg-gray-800/25 px-1.5 py-2 hover:border-sky-500">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="p-2 text-white rounded-full bg-sky-700">
                                    <svg class="h-7 w-7" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
                                        <title>crowd</title>
                                        <path
                                            d="M3.69 9.12C3.5 8.93 3.29 8.84 3.04 8.84C2.63 8.84 2.32 9.03 2.12 9.42S1.97 10.18 2.29 10.53C3.47 11.59 4.22 12.34 4.54 12.78C4.95 13.34 5.15 14.16 5.15 15.22C5.15 16.53 5.65 17.5 6.65 18.17C7.21 18.61 7.82 18.94 8.5 19.16L8.5 15.27C8.5 14.33 8.17 13.55 7.54 12.92M16.46 12.97C15.84 13.59 15.5 14.36 15.5 15.27L15.5 19.2C16.46 18.86 17.26 18.33 17.92 17.63C18.57 16.93 18.9 16.16 18.9 15.22C18.9 14.09 19.09 13.28 19.47 12.78C19.56 12.62 19.73 12.42 20 12.17C20.23 11.92 20.47 11.68 20.71 11.46C20.94 11.25 21.17 11.03 21.39 10.81L21.72 10.53C21.91 10.34 22 10.12 22 9.87C22 9.59 21.91 9.34 21.72 9.14C21.53 8.94 21.3 8.84 21 8.84S20.5 8.93 20.31 9.12M12 20C12.69 20 13.36 19.91 14 19.72L14 16.15C14 15.56 13.82 15.1 13.41 14.66C13 14.22 12.53 14 12 14C11.47 14 11 14.2 10.62 14.61C10.22 15 10 15.46 10 16.06L10 19.72C10.64 19.91 11.31 20 12 20M9 8.5C9 9.33 8.33 10 7.5 10S6 9.33 6 8.5 6.67 7 7.5 7 9 7.67 9 8.5M18 8.5C18 9.33 17.33 10 16.5 10C15.67 10 15 9.33 15 8.5S15.67 7 16.5 7C17.33 7 18 7.67 18 8.5M13.5 5.5C13.5 6.33 12.83 7 12 7S10.5 6.33 10.5 5.5 11.17 4 12 4 13.5 4.67 13.5 5.5M13.5 11C13.5 11.83 12.83 12.5 12 12.5S10.5 11.83 10.5 11 11.17 9.5 12 9.5 13.5 10.17 13.5 11Z" />
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-sm text-slate-600 dark:text-white/50">
                                        All Batches
                                    </div>
                                    <div class="text-lg font-bold">
                                        {{ $all_batches }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-span-2 row-span-1 p-4 bg-white rounded-lg dark:bg-gray-700">
                    <div class="flex items-center justify-between col-span-2">
                        <span>
                            ENROLLMENT
                        </span>
                        <div :class="enrollmentMode === 'monthly' ? 'flex' : ''" class="w-1/3 ">
                            <span class="w-1/2">
                                <select name="enrollment_mode" id="enrollment_mode" x-model="enrollmentMode"
                                    @change="enrollmentModeChanged"
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option value="yearly">Yearly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </span>
                            <span class="w-1/2 ms-1" x-cloak x-show="enrollmentMode === 'monthly'">
                                <select name="enrollment_mode" id="enrollment_mode" x-model="selectedYear"
                                    @change="showEnrollments"
                                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <template x-for="year in Object.keys(monthlyEnrolleesGrouped)">
                                        <option :value="year" x-text="year"></option>
                                    </template>
                                </select>
                            </span>
                        </div>
                    </div>
                    <canvas id="enrollment-tracking"></canvas>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-3 col-span-full ">
            <div class="col-span-3 p-4 bg-white rounded-lg md:col-span-2 dark:bg-gray-700">
                <div class="col-span-2">
                    <span class="">
                        TRAINEES LOCATIONS
                    </span>
                    <div class="flex w-full my-2">
                        <span class="w-full ms-1">
                            <select name="enrollment_mode" id="enrollment_mode" x-model="selectedCourseLocation"
                                @change="showTraineesLocation"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <template x-for="course in Object.keys(groupTraineesLocation)" :key="course">
                                    <option :value="course" x-text="course"></option>
                                </template>
                            </select>
                        </span>
                        <span class="w-full ms-1">
                            <select name="enrollment_mode" id="enrollment_mode" x-model="selectedBatchLocation"
                                @change="showTraineesLocation"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <template x-for="batch in Object.keys(groupTraineesLocation[selectedCourseLocation])"
                                    :key="batch">
                                    <option :value="batch" x-text="batch"></option>
                                </template>
                            </select>
                        </span>
                        <span class="w-full ms-1">
                            <select name="enrollment_mode" id="enrollment_mode" x-model="selectedLocationMode"
                                @change="showTraineesLocation"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <option value="city">By City</option>
                                <option value="barangay">By Barangay</option>
                            </select>
                        </span>
                        <span x-cloak x-show="selectedLocationMode === 'barangay'" class="w-full ms-1">
                            <select name="enrollment_mode" id="enrollment_mode" x-model="selectedCityLocation"
                                @change="showTraineesLocation"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <template
                                    x-for="(city, cityId) in groupTraineesLocation[selectedCourseLocation][selectedBatchLocation]"
                                    :key="cityId">
                                    <option :value="cityId" x-text="city.cityName">
                                    </option>
                                </template>
                            </select>
                        </span>
                    </div>
                </div>
                <canvas id="locations-count"></canvas>
            </div>

            <div class="col-span-3 p-4 bg-white rounded-lg md:col-span-1 dark:bg-gray-700">
                <div class="flex items-center justify-center col-span-1 mb-2">
                    <div>
                        <div class="py-2 text-center">
                            CURRENT TRAINEES
                        </div>
                        <canvas id="enrollees-count"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-4 my-2">
            CURRENT TRAINEES PER COURSE
        </div>
        <div class="grid grid-cols-4 gap-3">

            <template x-for="course in courses" :key="course.id">
                <a :href="`{{ route('dashboard_course', ':id') }}`.replace(':id', course.id)"
                    class="flex col-span-4 md:col-span-1">
                    <div
                        class="flex items-center justify-between w-full p-4 space-x-4 bg-white rounded-lg dark:bg-gray-600 ">
                        <div class="flex items-center space-x-2">
                            <span><svg class="w-8 h-8 text-sky-500" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <title>book-outline</title>
                                    <path
                                        d="M18,2A2,2 0 0,1 20,4V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2H18M18,4H13V12L10.5,9.75L8,12V4H6V20H18V4Z" />
                                </svg></span>
                            <div>
                                <div class="font-bold uppercase" x-text="course.code"></div>
                                <div class="text-xs" x-text="course.name"></div>
                            </div>
                        </div>
                        <div class="p-2 text-white rounded bg-sky-600" x-text="course.enrollees_count">
                        </div>
                    </div>
                </a>

            </template>
        </div>
    </div>

    @section('script')
        <script type="text/javascript">
            function dashboard() {
                return {
                    webUsers: @json($web_users ?? ''),
                    trainees: @json($trainees ?? ''),

                    yearlyEnrollees: @json($yearly_enrollees ?? ''),
                    monthlyEnrollees: @json($monthly_enrollees ?? ''),

                    enrollmentMode: 'yearly',
                    selectedYear: null,
                    monthlyEnrolleesGrouped: null,
                    enrollmentChart: null,

                    groupTraineesLocation: {},
                    selectedLocationMode: 'city',
                    selectedCourseLocation: null,
                    selectedBatchLocation: null,
                    selectedCityLocation: null,
                    locationsChart: null,

                    courses: @json($courses ?? ''),
                    init() {
                        this.groupMonthlyEnrollees();

                        this.showWebUsers()
                        this.showEnrollments();
                        this.showAllTraineesCount();

                        this.getGroupTraineesLocation();
                        // this.showTraineesLocation();



                        // this.groupTraineesByBarangay();
                        // this.groupTraineesByCity();
                        // this.selectedCourseLocation = Object.keys(this.groupTraineesLocation[this.selectedLocationMode])[0];



                    },
                    convertMonthToWord(monthNumber) {
                        const months = [
                            "January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ];
                        return months[monthNumber - 1]; // Subtract 1 to align with 0-indexed array
                    },

                    showWebUsers() {
                        var ctx = document.getElementById('web-users-chart').getContext('2d');

                        const config = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: this.webUsers.map(user => user.role.toUpperCase()),
                                datasets: [{
                                    label: 'Count',
                                    data: this.webUsers.map(user => user.count),
                                    backgroundColor: [
                                        'rgba(255, 99, 132)',
                                        'rgba(54, 162, 235)',
                                        'rgba(255, 206, 86)',
                                        'rgba(75, 192, 192)',
                                        'rgba(153, 102, 255)',
                                        'rgba(255, 159, 64)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: 'white',
                                        }
                                    },
                                }
                            },
                        });

                    },
                    showEnrollments() {
                        console.log(this.monthlyEnrollees);

                        var ctx = document.getElementById('enrollment-tracking').getContext('2d');

                        if (this.enrollmentChart) {
                            this.enrollmentChart.destroy();
                        }

                        let labels, allCounts, acceptedCounts;

                        if (this.enrollmentMode === 'yearly') {
                            // Set yearly data
                            labels = this.yearlyEnrollees.all.map(item => item.year);
                            allCounts = this.yearlyEnrollees.all.map(item => item.count);
                            acceptedCounts = this.yearlyEnrollees.accepted.map(item => item.count);
                        } else if (this.enrollmentMode === 'monthly' && this.selectedYear) {
                            // Set monthly data for the selected year
                            const monthlyData = this.monthlyEnrolleesGrouped[this.selectedYear] || [];
                            labels = monthlyData.map(item => this.convertMonthToWord(item.month));
                            allCounts = monthlyData.map(item => item.count);
                            acceptedCounts = monthlyData.map(item => item
                                .accepted); // Placeholder if you need another dataset for monthly

                            console.log(labels);

                        }



                        function isDarkMode() {
                            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        }

                        // Set colors based on theme
                        const textColor = isDarkMode() ? 'white' : 'black';
                        const gridColor = isDarkMode() ? 'rgba(255, 255, 255, 0.36)' : 'rgba(0, 0, 0, 0.1)';

                        this.enrollmentChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels, // X-axis (years)
                                datasets: [{
                                        label: 'All',
                                        data: allCounts, // Y-axis (counts)
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        fill: true
                                    },
                                    {
                                        label: 'Accepted',
                                        data: acceptedCounts, // Y-axis (counts)
                                        borderColor: 'rgba(183, 28, 240, 1)',
                                        backgroundColor: 'rgba(183, 28, 240, 0.2)',
                                        fill: true
                                    },
                                ]
                            },
                            options: {
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: this.enrollmentMode === 'yearly' ? 'Year' : 'Month',
                                            color: textColor
                                        },
                                        ticks: {
                                            color: textColor
                                        },
                                        grid: {
                                            color: gridColor
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Enrollees',
                                            color: textColor
                                        },
                                        ticks: {
                                            color: textColor
                                        },
                                        grid: {
                                            color: gridColor
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: textColor
                                        }
                                    },
                                    tooltip: {
                                        titleColor: 'white',
                                        bodyColor: 'white'
                                    }
                                }
                            }
                        });
                    },
                    showAllTraineesCount() {
                        var ctx = document.getElementById('enrollees-count').getContext('2d');

                        function isDarkMode() {
                            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        }

                        // Set colors based on theme
                        const textColor = isDarkMode() ? 'white' : 'black';

                        const config = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: this.courses.map(course => course.code.toUpperCase()),
                                datasets: [{
                                    label: 'Count',
                                    data: this.courses.map(course => course.enrollees_count),
                                    backgroundColor: [
                                        'rgba(255, 99, 132)',
                                        'rgba(54, 162, 235)',
                                        'rgba(255, 206, 86)',
                                        'rgba(75, 192, 192)',
                                        'rgba(153, 102, 255)',
                                        'rgba(255, 159, 64)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: textColor,
                                        }
                                    },
                                }
                            },
                        });
                    },
                    groupMonthlyEnrollees() {
                        this.monthlyEnrolleesGrouped = this.monthlyEnrollees.reduce((acc, entry) => {
                            const {
                                year,
                                month,
                                count,
                                accepted
                            } = entry;

                            // Initialize array for the year if it doesn't exist
                            if (!acc[year]) {
                                acc[year] = [];
                            }

                            // Add the month and count for that year
                            acc[year].push({
                                month,
                                count,
                                accepted
                            });

                            return acc;
                        }, {});

                        // console.log(this.monthlyEnrollees);
                    },
                    enrollmentModeChanged() {
                        const years = Object.keys(this.monthlyEnrolleesGrouped);
                        this.selectedYear = years.length ? years[0] : null;
                        this.showEnrollments()
                    },

                    async getGroupTraineesLocation() {
                        this.groupTraineesLocation = {}
                        for (const trainee of this.trainees) {
                            const {
                                batch,
                                course,
                                barangay,
                                city
                            } = trainee;

                            if (!this.groupTraineesLocation[course['code']]) {
                                this.groupTraineesLocation[course['code']] = {};
                            }

                            // Ensure batch exists under the course
                            if (!this.groupTraineesLocation[course['code']][batch['name']]) {
                                this.groupTraineesLocation[course['code']][batch['name']] = {};
                            }

                            // Handle city
                            // var cityName;
                            if (!this.groupTraineesLocation[course['code']][batch['name']][city]) {
                                const cityName = await this.getCityName(city); // Await async call
                                this.groupTraineesLocation[course['code']][batch['name']][city] = {
                                    cityName: cityName || city, // Fallback to city code if API fails
                                    barangay: {},
                                    count: 0
                                };
                            }

                            // Handle barangay
                            if (!this.groupTraineesLocation[course['code']][batch['name']][city]['barangay'][barangay]) {
                                const barangayName = await this.getBarangayName(barangay); // Await async call
                                this.groupTraineesLocation[course['code']][batch['name']][city]['barangay'][barangay] = {
                                    barangayName: barangayName || barangay, // Fallback to barangay code if API fails
                                    count: 0
                                };
                            }

                            // Increment counts
                            this.groupTraineesLocation[course['code']][batch['name']][city]['barangay'][barangay][
                                'count'
                            ] += 1;
                            this.groupTraineesLocation[course['code']][batch['name']][city]['count'] += 1;
                        }

                        // this.groupTraineesLocation = this.groupTraineesLocation;

                        // Set the default selected course and batch locations
                        // console.log(this.groupTraineesLocation);

                        this.selectedCourseLocation = Object.keys(this.groupTraineesLocation)[0] || null;
                        this.selectedBatchLocation = this.selectedCourseLocation ?
                            Object.keys(this.groupTraineesLocation[this.selectedCourseLocation])[0] || null : null;
                        this.selectedCityLocation = this.selectedBatchLocation ?
                            Object.keys(this.groupTraineesLocation[this.selectedCourseLocation][this
                                .selectedBatchLocation
                            ])[0] || null : null;
                        console.log(this.groupTraineesLocation[this.selectedCourseLocation][this
                            .selectedBatchLocation
                        ]);


                        // console.log(Object.values(this.groupTraineesLocation[this.selectedCourseLocation][this
                        //     .selectedBatchLocation
                        // ]).map(item => item.cityName));

                        this.showTraineesLocation();


                    },
                    showTraineesLocation() {
                        var courseData = this.groupTraineesLocation[this.selectedCourseLocation][this
                            .selectedBatchLocation
                        ]

                        const labels = [];

                        if (this.selectedLocationMode === "city") {
                            // Collect all city names
                            Object.values(courseData).forEach(location => {
                                if (location.cityName) {
                                    labels.push(location.cityName);
                                }
                            });
                        } else if (this.selectedLocationMode === "barangay" && this.selectedCityLocation) {
                            // Collect barangay names for the selected city
                            const cityData = Object.values(courseData[this.selectedCityLocation])
                            console.log(cityData);


                            if (cityData && cityData[1]) {
                                Object.values(cityData[1]).forEach(barangay => {
                                    if (barangay.barangayName) {
                                        labels.push(barangay.barangayName);
                                    }
                                });
                            }
                        }

                        if (this.locationsChart) {
                            this.locationsChart.destroy();
                        }


                        const dataPoints = this.selectedLocationMode === "city" ? Object.values(courseData).map(entry => entry
                            .count) : Object.values(courseData[this.selectedCityLocation]['barangay']).map(entry => entry
                            .count);

                        // Destroy previous chart instance if it exists


                        const datasets = labels.map((label, index) => ({
                            label: label, // Each label becomes the label of its dataset
                            data: [dataPoints[index]], // Each dataset has one data point
                            borderColor: this.getColors(1)[0], // Get one color per dataset
                            backgroundColor: this.getColors(1)[0], // Get one color per dataset
                            borderWidth: 3
                        }));

                        console.log(dataPoints);



                        const ctx = document.getElementById('locations-count').getContext('2d');
                        this.locationsChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [''],
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true // Show the legend for the bar labels
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return `${context.dataset.label}: ${context.raw}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Number of Trainees'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: this.selectedLocationMode === 'city' ? 'City' : 'Barangay'
                                        }
                                    }
                                }
                            }
                        });
                    },
                    getColors(count) {
                        const colors = {
                            bg: [],
                            border: []
                        };
                        for (let i = 0; i < count; i++) {
                            const randomColor =
                                `#${Math.floor(Math.random() * 167772).toString(16).padStart(6, '0')}`;
                            colors.bg.push(randomColor + '99');
                            colors.border.push(randomColor);
                        }
                        return colors;
                    },
                    async getCityName(code) {
                        const apiUrl = `https://psgc.gitlab.io/api/cities-municipalities/${code}`;

                        try {

                            if (localStorage.getItem(`city_${code}`)) {
                                return localStorage.getItem(`city_${code}`);
                            }

                            const response = await fetch(apiUrl);
                            if (!response.ok) {
                                throw new Error(`Error: ${response.status} - ${response.statusText}`);
                            }

                            const data = await response.json();

                            // Assuming you want the name of the city/municipality
                            localStorage.setItem(`city_${code}`, data.name);
                            const city = data.name

                            return city;
                        } catch (error) {
                            console.error("Failed to fetch location data:", error);
                            return null;
                        }

                    },
                    async getBarangayName(code) {
                        const apiUrl = `https://psgc.gitlab.io/api//barangays/${code}`;

                        try {
                            if (localStorage.getItem(`barangay_${code}`)) {
                                return localStorage.getItem(`barangay_${code}`);
                            }

                            const response = await fetch(apiUrl);
                            if (!response.ok) {
                                throw new Error(`Error: ${response.status} - ${response.statusText}`);
                            }

                            const data = await response.json();

                            // Assuming you want the name of the city/municipality
                            localStorage.setItem(`barangay_${code}`, data.name);
                            const barangay = data.name

                            return barangay;

                        } catch (error) {
                            console.error("Failed to fetch location data:", error);
                            return null;
                        }

                    }



                }
            }
        </script>
    @endsection
</x-app-layout>
