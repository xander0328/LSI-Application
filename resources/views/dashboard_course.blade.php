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
            <div class="mb-2">
                <div class="text-2xl font-bold" x-text="course.name"></div>
                <div>
                    <span>Category: </span>
                    <span x-text="course.course_category.name"></span>
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
                        <span class="flex items-center w-1/3 text-xs whitespace-nowrap">
                            <span class="me-1">Batch:</span>
                            <select name="enrollment_mode" id="enrollment_mode" x-model="sexSelectedBatch"
                                @change="showSexPerBatches"
                                class="focus:ring-primary-500 w-full text-xs focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block rounded-lg border border-gray-300 bg-gray-50 px-2.5  text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <template x-for="batch in Object.keys(sexPerBatch)" :key="batch">
                                    <option :value="batch" x-text="batch"></option>
                                </template>
                            </select>
                        </span>
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
                        <span class="flex items-center w-1/3 text-xs whitespace-nowrap">
                            <span class="me-1">Batch:</span>
                            <select name="enrollment_mode" id="enrollment_mode" x-model="employmentSelectedBatch"
                                @change="showSexPerBatches"
                                class="focus:ring-primary-500 text-xs w-full focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block rounded-lg border border-gray-300 bg-gray-50 px-2.5  text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <template x-for="batch in Object.keys(sexPerBatch)" :key="batch">
                                    <option :value="batch" x-text="batch"></option>
                                </template>
                            </select>
                        </span>
                    </div>
                    <canvas id="sex-per-batch"></canvas>
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

                    // Sex
                    sexPerBatch: [],
                    sexSelectedBatch: null,
                    sexChart: null,

                    // Employment
                    employmentPerBatch: [],
                    employmentSelectedBatch: null,
                    employmentChart: null,

                    init() {
                        this.showBatches()
                        this.groupBatches()
                        console.log(this.batches);

                        this.getSexCountBatch();
                        this.showSexPerBatches();

                        this.getEmploymentCountBatch();
                        this.showEmploymentPerBatches();
                        console.log(this.sexPerBatch);


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


                        this.sexSelectedBatch = Object.keys(this.sexPerBatch)[0] ?? ''
                        console.log(this.sexSelectedBatch);

                    },
                    showSexPerBatches() {
                        var ctx = document.getElementById('sex-per-batch').getContext('2d');

                        if (this.sexChart) {
                            this.sexChart.destroy()
                        }

                        const labels = [this.sexSelectedBatch]
                        const maleCount = this.sexPerBatch[this.sexSelectedBatch].male
                        const femaleCount = this.sexPerBatch[this.sexSelectedBatch].female

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
                                }, {
                                    label: 'Female',
                                    data: [femaleCount],
                                    borderColor: 'rgba(204,35,52,1)',
                                    backgroundColor: 'rgba(204,35,52, 0.2)',
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
                        Object.keys(this.batches).map(batchId => {

                            const enrollees = this.batches[batchId];

                            this.sexPerBatch[batchId] = enrollees.reduce((acc, enrollee) => {
                                enrollee.map(enrollee => {

                                    switch (enrollee.employment_type) {
                                        case "unemployed":
                                        case "trainee":
                                            acc.unemployed += 1
                                            break;
                                        case "employed":
                                            acc.employed += 1
                                            break;
                                        case "self-employed":
                                            acc.self - employed += 1
                                            break;

                                        default:
                                            break;
                                    }
                                })
                                return acc;
                            }, {
                                male: 0,
                                female: 0
                            });

                        });


                        this.sexSelectedBatch = Object.keys(this.sexPerBatch)[0] ?? ''
                        console.log(this.sexSelectedBatch);
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
