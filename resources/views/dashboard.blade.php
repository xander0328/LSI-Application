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
    <div x-data="dashboard" id="main-div" class="mx-4 pb-4 pt-40 text-black dark:text-white md:mx-8">
        <div class="mb-6 grid grid-cols-3 gap-3">
            <div class="col-span-full flex flex-col md:col-span-1">
                <div class="mb-3 flex basis-2/3 items-center justify-center rounded-lg bg-sky-600 p-2 text-white">
                    <div>
                        <div class="py-2 text-center">PLATFORM USERS</div>
                        <canvas id="web-users-chart"></canvas>
                    </div>
                </div>
                <div class="flex basis-1/3 flex-col rounded-lg bg-white p-4 dark:bg-gray-700">
                    <div class="mb-2">
                        <span>
                            NEW USERS
                        </span>
                    </div>
                    <div class="grid h-full grid-cols-3 gap-2">
                        <div class="flex flex-col rounded bg-gray-800/25 p-2">
                            <div class="text-center text-sm text-slate-600 dark:text-white/50">Today</div>
                            <div class="flex h-full items-center justify-center text-xl">{{ $today_enrollees }}</div>
                        </div>
                        <div class="flex flex-col rounded bg-gray-800/25 p-2">
                            <div class="text-center text-sm text-slate-600 dark:text-white/50">This Month</div>
                            <div class="flex h-full items-center justify-center text-xl">{{ $month_enrollees }}</div>
                        </div>
                        <div class="flex flex-col rounded bg-gray-800/25 p-2">
                            <div class="text-center text-sm text-slate-600 dark:text-white/50">This Year</div>
                            <div class="flex h-full items-center justify-center text-xl">{{ $year_enrollees }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full gap-3 md:col-span-2">
                <div class="mb-3 rounded-lg bg-white p-4 dark:bg-gray-700">
                    <div class="mb-2 flex items-center justify-between">
                        <span>
                            COURSES / PROGRAMS
                        </span>
                        <span class="cursor-pointer text-white/75 hover:text-sky-500">
                            View
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div
                            class="flex items-center justify-between rounded-md border border-gray-800/25 bg-gray-800/25 px-1.5 py-2 hover:border-sky-500">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="rounded-full bg-sky-700 p-2 text-white">
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
                                <span class="rounded-full bg-sky-700 p-2 text-white">
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
                                <span class="rounded-full bg-sky-700 p-2 text-white">
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
                                <span class="rounded-full bg-sky-700 p-2 text-white">
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
                <div class="col-span-2 row-span-1 rounded-lg bg-white p-4 dark:bg-gray-700">
                    <div class="col-span-2 flex items-center justify-between">
                        <span>
                            ENROLLMENT
                        </span>
                        <span class="w-1/3">
                            <select name="enrollment_mode" id="enrollment_mode"
                                class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <option selected="yearly" selected>Yearly</option>
                                <option selected="monthly">Monthly</option>
                            </select>
                        </span>
                    </div>
                    <canvas id="enrollment-tracking"></canvas>
                </div>

            </div>
        </div>
        <div class="col-span-4 mb-2">
            CURRENT TRAINEES PER COURSE
        </div>
        <div class="grid grid-cols-4 gap-3">

            <template x-for="course in courses" :key="course.id">
                <div
                    class="col-span-4 flex items-center justify-between space-x-4 rounded-lg bg-white p-4 dark:bg-gray-600 md:col-span-1">
                    <div class="flex items-center space-x-2">
                        <span><svg class="h-8 w-8 text-sky-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>book-outline</title>
                                <path
                                    d="M18,2A2,2 0 0,1 20,4V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2H18M18,4H13V12L10.5,9.75L8,12V4H6V20H18V4Z" />
                            </svg></span>
                        <div>
                            <div class="font-bold uppercase" x-text="course.code">BELL</div>
                            <div class="text-xs" x-text="course.name">Basic English Language Learning</div>
                        </div>
                    </div>
                    <div class="rounded bg-sky-600 p-2 text-white" x-text="course.enrollees_count">
                        48
                    </div>
                </div>
            </template>
        </div>
    </div>

    @section('script')
        <script type="text/javascript">
            function dashboard() {
                return {
                    webUsers: @json($web_users ?? ''),
                    yearlyEnrollees: @json($yearly_enrollees ?? ''),
                    monthlyEnrollees: @json($monthly_enrollees ?? ''),
                    courses: @json($courses ?? ''),
                    init() {
                        console.log(this.monthlyEnrollees);
                        console.log(this.yearlyEnrollees);

                        this.showWebUsers()
                        this.showYearlyEnrollments();
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
                    showYearlyEnrollments() {
                        var ctx = document.getElementById('enrollment-tracking').getContext('2d');

                        // Extract the years and counts from the data
                        var years = this.yearlyEnrollees.all.map(item => item.year);
                        var allCounts = this.yearlyEnrollees.all.map(item => item.count);
                        var acceptedCounts = this.yearlyEnrollees.accepted.map(item => item.count);


                        function isDarkMode() {
                            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        }

                        // Set colors based on theme
                        const textColor = isDarkMode() ? 'white' : 'black';
                        const gridColor = isDarkMode() ? 'rgba(255, 255, 255, 0.36)' : 'rgba(0, 0, 0, 0.1)';

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: years, // X-axis (years)
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
                                            text: 'Year',
                                            color: textColor,
                                        },
                                        ticks: {
                                            color: textColor // X-axis label color
                                        },
                                        grid: {
                                            color: gridColor // X-axis grid line color
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Enrollees',
                                            color: textColor,
                                        },
                                        ticks: {
                                            color: textColor // Y-axis label color
                                        },
                                        grid: {
                                            color: gridColor // Y-axis grid line color
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            color: textColor,
                                        }
                                    },
                                    tooltip: {
                                        titleColor: 'white', // Tooltip title color
                                        bodyColor: 'white' // Tooltip body text color
                                    }
                                }
                            }
                        });
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
