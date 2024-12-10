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
        <div class="p-4 bg-white rounded-lg shadow-md">
            <div class="mb-2 flex items-center justify-between">
                <div class="">
                    <div class="text-2xl font-bold" x-text="course.name"></div>
                    <div>
                        <span>Category: </span>
                        <span x-text="course.course_category.name"></span>
                    </div>
                </div>
                <div class="w-1/2 flex justify-end">
                    <span class="flex items-center w-1/2 whitespace-nowrap">
                        <span class="me-1">Batch:</span>
                        <select name="enrollment_mode" id="enrollment_mode" x-model="selectedBatch"
                            @change="recomputeGraphs()"
                            class="focus:ring-primary-500 w-full focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block rounded-lg border border-gray-300 bg-gray-50 px-2.5  text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                            <template x-for="batch in Object.keys(sexPerBatch)" :key="batch">
                                <option :value="batch" x-text="batch"></option>
                            </template>
                        </select>
                    </span>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-1 p-2 bg-gray-100 rounded-md">
                    <div class="mb-2">
                        <span>BATCHES</span>
                    </div>
                    <canvas id="batches"></canvas>
                </div>
                <div class="col-span-1 p-2 bg-gray-100 rounded-md">
                    <div class="flex items-center justify-between mb-2">
                        <span>SEX</span>
                    </div>
                    <canvas id="sex-per-batch"></canvas>
                </div>
                <div class="col-span-1 p-2 bg-gray-100 rounded-md">
                    <div class="flex items-center justify-between mb-2">
                        <span>
                            <div>
                                EMPLOYMENT STATUS
                            </div>
                            <div class="text-xs text-gray-600">
                                FROM ENROLLMENT
                            </div>
                        </span>

                    </div>
                    <canvas id="employment-per-batch"></canvas>
                </div>
                <div class="col-span-1 p-2 bg-gray-100 rounded-md">
                    <div class="flex items-center justify-center mb-2">
                        <div>
                            <div class="py-2 text-center">
                                REGISTRATION FEE
                            </div>
                            <canvas id="registration-per-batch"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function dashboard() {
                return {
                    course: @json($course ?? ''),
                    batches: null,
                    selectedBatch: null,

                    // Sex
                    sexPerBatch: [],
                    sexChart: null,

                    // Employment
                    employmentPerBatch: [],
                    employmentChart: null,

                    // Registration
                    registrationPerBatch: [],
                    registrationChart: null,

                    init() {
                        this.showBatches()
                        this.groupBatches()
                        console.log(this.batches);

                        this.getSexCountBatch();
                        this.showSexPerBatches();

                        this.getEmploymentCountBatch();

                        this.getRegistrationCountBatch()

                    },

                    // Batch
                    showBatches() {
                        var ctx = document.getElementById('batches').getContext('2d');

                        const labels = this.course.batches.map(batch => batch.name)
                        const count = this.course.batches.map(batch => batch.enrollee_count)

                        console.log(count);

                        function isDarkMode() {
                            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        }

                        // Set colors based on theme
                        const textColor = isDarkMode() ? 'white' : 'black';
                        const gridColor = isDarkMode() ? 'rgba(255, 255, 255, 0.36)' : 'rgba(0, 0, 0, 0.1)';

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels, // X-axis (years)
                                datasets: [{
                                    label: 'Trainees',
                                    data: count, // Y-axis (counts)
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Batch',
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
                                        title: {
                                            display: true,
                                            text: 'Trainees',
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

                    groupBatches() {
                        this.batches = this.course.batches.reduce((batch, entry) => {
                            const {
                                name,
                                enrollee,
                            } = entry;

                            // Initialize array for the year if it doesn't exist
                            if (!batch[name]) {
                                batch[name] = [];
                            }

                            // Add the month and count for that year
                            batch[name].push(
                                enrollee
                            );

                            return batch;
                        }, {});

                    },

                    recomputeGraphs() {
                        this.showSexPerBatches();
                        this.showEmploymentPerBatch();
                        this.showRegistrationPerBatch()

                    },

                    // Sex
                    getSexCountBatch() {
                        Object.keys(this.batches).map(batchId => {

                            const enrollees = this.batches[batchId];

                            this.sexPerBatch[batchId] = enrollees.reduce((acc, enrollee) => {
                                enrollee.map(enrollee => {
                                    if (enrollee.sex === 'male') {
                                        acc.male += 1;
                                    } else if (enrollee.sex === 'female') {
                                        acc.female += 1;
                                    }
                                })
                                return acc;
                            }, {
                                male: 0,
                                female: 0
                            });

                        });


                        this.selectedBatch = Object.keys(this.sexPerBatch)[0] ?? ''
                        console.log(this.selectedBatch);

                    },
                    showSexPerBatches() {
                        var ctx = document.getElementById('sex-per-batch').getContext('2d');

                        if (this.sexChart) {
                            this.sexChart.destroy()
                        }

                        const labels = [this.selectedBatch]
                        const maleCount = this.sexPerBatch[this.selectedBatch].male
                        const femaleCount = this.sexPerBatch[this.selectedBatch].female

                        console.log(labels);
                        console.log(maleCount);

                        function isDarkMode() {
                            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        }

                        // Set colors based on theme
                        const textColor = isDarkMode() ? 'white' : 'black';
                        const gridColor = isDarkMode() ? 'rgba(255, 255, 255, 0.36)' : 'rgba(0, 0, 0, 0.1)';

                        this.sexChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Male',
                                    data: [maleCount],
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderWidth: 3

                                }, {
                                    label: 'Female',
                                    data: [femaleCount],
                                    borderColor: 'rgba(204,35,52,1)',
                                    backgroundColor: 'rgba(204,35,52, 0.2)',
                                    borderWidth: 3
                                }, ]
                            },
                            options: {
                                indexAxis: 'y',
                                scales: {
                                    x: {
                                        ticks: {
                                            color: textColor
                                        },
                                        grid: {
                                            color: gridColor
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Batch',
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
                                        position: 'right',
                                        labels: {
                                            color: textColor
                                        }
                                    },
                                    tooltip: {
                                        titleColor: 'white',
                                        bodyColor: 'white'
                                    }
                                }
                            },
                        });
                    },

                    // Employment
                    getEmploymentCountBatch() {
                        Object.keys(this.batches).forEach(batchId => {
                            const enrollees = this.batches[batchId];

                            // Reduce to calculate employment type counts for each batch
                            this.employmentPerBatch[batchId] = enrollees.reduce((acc, enrollee) => {
                                // Initialize employment types in the accumulator
                                if (!acc['unemployed']) {
                                    acc['unemployed'] = 0;
                                }
                                if (!acc['employed']) {
                                    acc['employed'] = 0;
                                }
                                if (!acc['student']) {
                                    acc['student'] = 0;
                                }
                                if (!acc['self-employed']) {
                                    acc['self-employed'] = 0;
                                }

                                enrollee.map(enrollee => {
                                    switch (enrollee.employment_type) {
                                        case "unemployed":
                                            acc['unemployed'] += 1;
                                            break;
                                        case "trainee": // Assuming 'trainee' is equivalent to 'unemployed'
                                            acc['student'] += 1;
                                            break;
                                        case "employed":
                                            acc['employed'] += 1;
                                            break;
                                        case "self-employed":
                                            acc['self-employed'] += 1;
                                            break;
                                        default:
                                            break;
                                    }

                                })
                                return acc;
                            }, {
                                'unemployed': 0,
                                'employed': 0,
                                'self-employed': 0,
                                'student': 0
                            });
                        });

                        this.showEmploymentPerBatch()

                    },
                    showEmploymentPerBatch() {
                        var ctx = document.getElementById('employment-per-batch').getContext('2d');

                        if (this.employmentChart) {
                            this.employmentChart.destroy()
                        }

                        const data = this.employmentPerBatch[this.selectedBatch];

                        function isDarkMode() {
                            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        }

                        // Set colors based on theme
                        const textColor = isDarkMode() ? 'white' : 'black';
                        const gridColor = isDarkMode() ? 'rgba(255, 255, 255, 0.36)' : 'rgba(0, 0, 0, 0.1)';

                        this.employmentChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Unemployed', 'Employed', 'Self-Employed', 'Student'],
                                datasets: [{
                                    label: 'Batch Data',
                                    data: [data.unemployed, data.employed, data['self-employed'], data.student],
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 3
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        ticks: {
                                            color: textColor
                                        },
                                        grid: {
                                            color: gridColor
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Batch',
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
                                        position: 'right',
                                        labels: {
                                            color: textColor
                                        }
                                    },
                                    tooltip: {
                                        titleColor: 'white',
                                        bodyColor: 'white'
                                    }
                                }
                            },
                        });
                    },


                    // Registration
                    getRegistrationCountBatch() {
                        Object.keys(this.batches).forEach(batchId => {
                            const enrollees = this.batches[batchId];

                            // Reduce to calculate employment type counts for each batch
                            this.registrationPerBatch[batchId] = enrollees.reduce((acc, enrollee) => {
                                // Initialize employment types in the accumulator
                                if (!acc['paid']) {
                                    acc['paid'] = 0;
                                }
                                if (!acc['unpaid']) {
                                    acc['unpaid'] = 0;
                                }


                                enrollee.map(enrollee => {
                                    if (enrollee['is_paid']) {
                                        acc['paid'] += 1
                                    }
                                    if (!enrollee['is_paid']) {
                                        acc['unpaid'] += 1
                                    }

                                })
                                return acc;
                            }, {
                                'paid': 0,
                                'unpaid': 0,
                            });
                        });
                        console.log(this.registrationPerBatch);

                        this.showRegistrationPerBatch()
                    },
                    showRegistrationPerBatch() {
                        var ctx = document.getElementById('registration-per-batch').getContext('2d');

                        if (this.registrationChart) {
                            this.registrationChart.destroy()
                        }

                        function isDarkMode() {
                            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        }

                        // Set colors based on theme
                        const textColor = isDarkMode() ? 'white' : 'black';

                        this.registrationChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Paid', 'Unpaid'],
                                datasets: [{
                                    label: 'Count',
                                    data: [this.registrationPerBatch[this.selectedBatch].paid, this
                                        .registrationPerBatch[this.selectedBatch].unpaid
                                    ],
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
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
