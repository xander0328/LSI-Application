<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }

        .no-scroll {
        overflow: hidden;
        }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-sky-950 dark:text-gray-200">
                {{ __('Batch List') }}
            </div>
            <div class="hidden md:block">
                <button id="installButton"
                    class="hidden w-full rounded-lg bg-sky-700 p-2 px-4 text-center text-white hover:bg-sky-800">
                    <div class="flex items-center justify-center">
                        <span>
                            <svg class="h-6 w-6 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24">
                                <title>download-circle-outline</title>
                                <path
                                    d="M8 17V15H16V17H8M16 10L12 14L8 10H10.5V6H13.5V10H16M12 2C17.5 2 22 6.5 22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2M12 4C7.58 4 4 7.58 4 12C4 16.42 7.58 20 12 20C16.42 20 20 16.42 20 12C20 7.58 16.42 4 12 4Z" />
                            </svg>
                        </span>
                        <span class="ms-2">
                            Install App
                        </span>
                    </div>
                </button>
            </div>
        </div>

    </x-slot>
    <div x-data="batchList" id="course_list" class="mx-8 pb-8 pt-40">
        <div>
            <div
                class="flex flex-col items-center justify-between space-y-1 pb-4 md:flex-row md:space-x-4 md:space-y-0">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg aria-hidden="true" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search" x-model="searchQuery" @input="filterBatches"
                                class=" block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                placeholder="Search" required="">
                        </div>
                    </form>
                </div>
                <div
                    class="flex w-full flex-shrink-0 flex-col items-stretch justify-end space-y-2 md:w-auto md:flex-row md:items-center md:space-x-3 md:space-y-0">

                    <div class="flex w-full items-center space-x-3 md:w-auto">
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                            class="hover:text-primary-700 flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10  dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white  md:w-auto"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                class="mr-2 h-4 w-4 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Filter
                            <svg class="-mr-1 ml-1.5 h-5 w-5" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="filterDropdown"
                            class="z-10 hidden w-48 rounded-lg bg-white p-3 shadow-lg dark:bg-gray-700">
                            <h6 class="mb-1 text-sm font-medium text-gray-900 dark:text-white">Course/s</h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                <template x-for="course in courses" :key="course.id">
                                    <li class="flex items-center">
                                        <input :id.number="course.id" type="checkbox" :value="course.id"
                                            x-model="selectedCourses"
                                            class="text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 h-4 w-4 rounded border-gray-300 bg-gray-100 focus:ring-2 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700">
                                        <label :for="course.id"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                            x-text="course.code"></label>
                                    </li>
                                </template>
                            </ul>
                            <h6 class="mb-1 mt-3 text-sm font-medium text-gray-900 dark:text-white">Status</h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                <li class="flex items-center">
                                    <input id="ongoing" type="checkbox" value="ongoing" x-model="selectedStatus"
                                        class="text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 h-4 w-4 rounded border-gray-300 bg-gray-100 focus:ring-2 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700">
                                    <label for="ongoing"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Ongoing</label>
                                </li>
                                <li class="flex items-center">
                                    <input id="completed" type="checkbox" value="completed" x-model="selectedStatus"
                                        class="text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 h-4 w-4 rounded border-gray-300 bg-gray-100 focus:ring-2 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-700">
                                    <label for="completed"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Completed</label>
                                </li>
                            </ul>
                            <div class="mt-3">
                                <button @click="filterBatches"
                                    class="w-full rounded bg-sky-500 p-2 text-center text-sm text-white hover:bg-sky-700">Load</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <template x-for="(batch, index) in filteredBatches" :key="batch.id">
                    <div class="">
                        <div class="h-28 w-full overflow-hidden rounded-t-md bg-white dark:bg-gray-700 p-1 pb-0">
                            <img class="h-full w-full rounded-t-md object-cover object-center"
                                :src="'{{ asset('storage/website/course_image/:course_id/:folder_name/:filename') }}'
                                .replace(':course_id', batch.course.id)
                                    .replace(':folder_name', batch.course.folder)
                                    .replace(':filename', batch.course.filename);"
                                alt="" />
                        </div>
                        <div
                            class="batch-button flex w-full items-center rounded-md rounded-t-none bg-white dark:bg-gray-700 p-4 text-start text-black dark:text-white dark:hover:bg-gray-700/50">
                            <div class="grow items-center">
                                <a :href="'{{ route('batch_posts', ':id') }}'.replace(':id', batch.encrypted_id)"
                                    class="me-2 flex items-center">
                                    <span :class="getBgColor(batch.course.code, index)"
                                        class="me-2 rounded px-2.5 py-2 text-sm font-medium"
                                        x-text="batch.course.code"></span>
                                    <span x-text="batch.name"></span>

                                </a>
                            </div>
                            <div class="relative flex items-center">
                                <x-dropdown width="40" align="right">
                                    <x-slot name="trigger">
                                        <span
                                            class="inline-flex cursor-pointer items-center rounded-md border border-transparent p-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:bg-gray-500/50 hover:text-gray-700 focus:outline-none">
                                            <svg class="h-5 w-5 text-black dark:text-white" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <title>dots-horizontal</title>
                                                <path
                                                    d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z" />
                                            </svg>
                                        </span>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="m-1.5">

                                            <a @click="showBatchData(batch.id)"
                                                class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-sky-950 dark:text-gray-300 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                <svg class="h-5 w-5" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <title>information-outline</title>
                                                    <path
                                                        d="M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z" />
                                                </svg>
                                                <div>Information</div>
                                            </a>
                                            {{-- 
                                            <template x-if="batch.completed_at == null">
                                                <a @click="showSchedule(batch.id)"
                                                    class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                    <svg class="h-5 w-5" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>calendar</title>
                                                        <path
                                                            d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z" />
                                                    </svg>
                                                    <div>Schedule</div>
                                                </a>
                                            </template> --}}

                                            <template x-if="batch.completed_at == null">
                                                <a @click="closeBatch(batch.id)"
                                                    class="flex w-full cursor-pointer items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-sky-950 dark:text-gray-300 transition duration-150 ease-in-out hover:text-white hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                    <svg class="h-5 w-5" fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <title>account-school-outline</title>
                                                        <path
                                                            d="M18 10.5V6L15.89 7.06C15.96 7.36 16 7.67 16 8C16 10.21 14.21 12 12 12C9.79 12 8 10.21 8 8C8 7.67 8.04 7.36 8.11 7.06L5 5.5L12 2L19 5.5V10.5H18M12 9L10 8C10 9.1 10.9 10 12 10C13.1 10 14 9.1 14 8L12 9M14.75 5.42L12.16 4.1L9.47 5.47L12.07 6.79L14.75 5.42M12 13C14.67 13 20 14.33 20 17V20H4V17C4 14.33 9.33 13 12 13M12 14.9C9 14.9 5.9 16.36 5.9 17V18.1H18.1V17C18.1 16.36 14.97 14.9 12 14.9Z" />
                                                    </svg>
                                                    <div class="whitespace-nowrap">Close Batch</div>
                                                </a>
                                            </template>

                                        </div>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </template>
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
                                x-text="`${selectedBatch?.course.code}-${selectedBatch?.name}`"></span>
                        </h3>
                        <button type="button"
                            @click="showBatchDataModal = false; document.body.classList.remove('no-scroll');"
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
                                            <div class="">
                                                <span class="text-white/50">Course: </span><span
                                                    x-text="selectedBatch?.course.name"></span>
                                            </div>
                                            <div>
                                                <span class="text-white/50">Created: </span><span
                                                    x-text="moment(selectedBatch?.course.created_at).format('lll')"></span>
                                            </div>
                                        </div>

                                        <div class="mb-1.5">
                                            <form class="flex items-center">
                                                <label for="simple-search" class="sr-only">Search</label>
                                                <div class="relative w-full">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <svg aria-hidden="true"
                                                            class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                                            fill="currentColor" viewbox="0 0 20 20"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <input type="text" id="simple-search" x-model="traineeSearch"
                                                        @input="filterTrainees"
                                                        class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                                        placeholder="Search trainee" required="">
                                                </div>
                                            </form>
                                        </div>

                                        <div>
                                            <div class="rounded-t-lg bg-gray-800 p-2 text-sm text-white/50">
                                                Trainees</div>
                                            <template x-if="filteredTrainees.length > 0">
                                                <div class="text-white">
                                                    <template x-for="(enrollee, index) in filteredTrainees"
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
                                            </template>
                                            <template x-if="filteredTrainees.length == 0">
                                                <div class="text-white">
                                                    <div class="rounded-b-lg border-white/25 bg-gray-800/75 p-2">
                                                        <div class="text-center text-sm text-white/50">No Records</div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
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

        {{-- Schedule Modal --}}
        <div x-cloak x-show="showScheduleModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
            <div class="relative h-full w-full max-w-full p-4">
                <!-- Modal content -->
                <div class="relative h-full rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Batch Schedule | <span class="text-xs"
                                x-text="`${selectedBatch?.course.code}-${selectedBatch?.name}`"></span>
                        </h3>
                        <button type="button" @click="showScheduleModal = false"
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
                    <div class="h-full rounded-b-lg" id="calendar">
                        <div class="flex-row-reverse"></div>
                        <div class="h-full bg-white p-4" id="tui-calendar">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Schedule Form Modal --}}
        <div x-cloak x-show="showScheduleFormModal" x-transition:enter="transition ease-out duration-200"
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
                            Create Event | <span class="text-xs"
                                x-text="`${selectedBatch?.course.code}-${selectedBatch?.name}`"></span>
                        </h3>
                        <button type="button"
                            @click="showScheduleFormModal = false; document.body.classList.remove('no-scroll');"
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
                    <div class="relative p-4 text-white md:p-5">
                        <form @submit.prevent="addScheduleEvent()">
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div class="col-span-2">
                                    <label for="event_title" class="mb-2 block text-sm font-medium text-white">Event
                                        title</label>
                                    <input type="text"
                                        class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                        x-model="scheduleForm.eventTitle" name="event_title" id="event_title"
                                        required="required">
                                </div>
                                <div class="col-span-1">
                                    <label for="time_start"
                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Start</label>
                                    <input type="text" x-model="scheduleForm.eventTimeStart" name="time_start"
                                        x-ref="timePickerStart"
                                        class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                        id="time_start" required="required">
                                </div>
                                <div class="col-span-1">
                                    <label for="time_end"
                                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">End</label>
                                    <input type="text" x-model="scheduleForm.eventTimeEnd" name="time_end"
                                        x-ref="timePickerEnd"
                                        class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                        id="time_end" required="required">
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
        </div>
    </div>
    @section('script')
        @php
            $batches = $batch;
            $batches['batches'] = $batch['batches']->map(function ($batch) {
                $batch->encrypted_id = encrypt($batch->id);
                return $batch;
            });
        @endphp
        <script type="text/javascript">
            function batchList() {
                return {

                    instructor: @json($batches ?? ''),
                    courses: [],
                    filteredBatches: [],
                    filteredTrainees: [],

                    init() {
                        this.instructor.batches.sort((a, b) => a.course.code.localeCompare(b.course.code));

                        const courseMap = new Map()
                        this.instructor.batches.forEach(batch => {
                            const course = batch.course;
                            if (!courseMap.has(course.id)) {
                                courseMap.set(course.id, {
                                    id: course.id,
                                    code: course.code
                                });
                            }
                        });

                        this.courses = Array.from(courseMap.values())
                        this.selectedCourses = this.courses.map(course => course.id);
                        this.selectedStatus = ['ongoing']
                        this.filterBatches()
                        console.log(this.instructor);

                        // datepicker 
                        flatpickr(this.$refs.timePickerStart, {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                        })
                        flatpickr(this.$refs.timePickerEnd, {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "H:i",
                        })
                    },

                    // Filter
                    searchQuery: '',
                    selectedCourses: [],
                    selectedStatus: [],
                    filterBatches() {
                        const numericSelectedCourses = this.selectedCourses.map(course => Number(course));
                        this.filteredBatches = this.instructor.batches.filter(batch => {
                            const courseMatch = numericSelectedCourses.length === 0 || numericSelectedCourses.includes(
                                batch
                                .course_id);
                            const statusMatch = this.selectedStatus.length === 0 ||
                                (this.selectedStatus.includes('ongoing') && batch.completed_at === null) ||
                                (this.selectedStatus.includes('completed') && batch.completed_at !== null);
                            const searchMatch = !this.searchQuery || batch.name.toLowerCase().includes(this.searchQuery
                                .toLowerCase()) || batch.course.code.toLowerCase().includes(this.searchQuery
                                .toLowerCase()) || batch.course.name.toLowerCase().includes(this.searchQuery
                                .toLowerCase());
                            return courseMatch && statusMatch && searchMatch;
                        });

                    },
                    traineeSearch: '',
                    filterTrainees() {
                        this.filteredTrainees = this.selectedBatch.batch_info.enrollee.filter(enrollee => {
                            const fullName = `${enrollee.user.fname} ${enrollee.user.lname}`.toLowerCase();
                            const email = enrollee.user.email.toLowerCase();

                            const query = this.traineeSearch.trim().toLowerCase()
                            return query == '' || fullName.includes(query) || email.includes(query);
                        });

                        this.filteredTrainees = this.filteredTrainees.sort((a, b) => {
                            const lnameA = a.user.lname.toLowerCase();
                            const lnameB = b.user.lname.toLowerCase();

                            if (lnameA < lnameB) return -1;
                            if (lnameA > lnameB) return 1;
                            return 0;
                        });
                    },

                    // Changing Color
                    previousCourseCode: null,
                    currentColorIndex: 0, // Track the color index
                    colors: [
                        'bg-red-500 text-red-200',
                        'bg-blue-500 text-blue-200',
                        'bg-green-500 text-green-200',
                        'bg-yellow-500 text-yellow-200',
                        'bg-purple-500 text-purple-200',
                        'bg-pink-500 text-pink-200',
                        'bg-indigo-500 text-indigo-200',
                        'bg-teal-500 text-teal-200',
                        'bg-orange-500 text-orange-200',
                        'bg-gray-500 text-gray-200'
                    ],
                    getBgColor(courseCode, index) {
                        if (this.previousCourseCode !== courseCode) {
                            this.previousCourseCode = courseCode;

                            this.currentColorIndex = (this.currentColorIndex + 1) % this.colors.length;
                        }

                        return this.colors[this.currentColorIndex];
                    },

                    // Batch Data Modal
                    showBatchDataModal: false,
                    selectedBatch: null,
                    showBatchData(batchId) {
                        document.body.classList.add('no-scroll');
                        this.selectedBatch = this.instructor.batches.find(batch => batch.id === batchId)
                        this.abortFetch('ajax')
                        this.dataLoading = true
                        var t = this
                        this.xhr = $.ajax({
                            url: '{{ route('get_batch_info') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                batch_id: batchId
                            },
                            success: function(response) {
                                t.selectedBatch.batch_info = response.batch
                                console.log(t.selectedBatch);
                                // t.selectedCourse.batches = response.course.batches
                                t.filterTrainees();
                                t.dataLoading = false
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                                t.notification('error', 'Fetching batch data error. Please try again.', '')
                            }
                        });
                        this.showBatchDataModal = true;
                    },

                    // Schedule Modal
                    showScheduleModal: false,
                    events: [{
                            title: 'event1',
                            start: '2024-09-16'
                        },
                        {
                            title: 'event2',
                            start: '2024-09-16',
                            end: '2024-09-18'
                        },
                        {
                            title: 'event3',
                            start: '2024-09-16T12:30:00',
                            allDay: false // will make the time show
                        }
                    ],
                    calendar: null,
                    async showSchedule(batchId) {
                        const self = this
                        this.selectedBatch = this.instructor.batches.find(batch => batch.id === batchId)
                        let calendarEl = document.getElementById('tui-calendar');
                        this.calendar = new Calendar(calendarEl, {
                            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
                            initialView: 'dayGridMonth',
                            selectable: true,

                            dateClick: function(info) {
                                self.showScheduleForm(info.dateStr); // Alert with the clicked date
                            },


                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,listWeek'
                            },
                            events: self.events,
                        });
                        this.calendar.render();

                        setTimeout(function() {
                            this.calendar.updateSize();
                        }, 100);

                        this.showScheduleModal = true
                        console.log(this.events)
                    },

                    // Schedule Form Modal
                    showScheduleFormModal: false,
                    scheduleForm: {
                        eventDate: null,
                        eventTitle: null,
                        eventTimeStart: null,
                        eventTimeEnd: null,
                    },
                    showScheduleForm(date) {
                        this.events = [{
                            title: 'event2',
                            start: '2024-09-16',
                            end: '2024-09-18'
                        }, ]
                        this.showScheduleFormModal = true
                        console.log(this.events);

                    },
                    addScheduleEvent() {
                        if (this.scheduleForm.eventTitle && this.scheduleForm.eventTimeStart && this.scheduleForm
                            .eventTimeEnd) {
                            this.calendar.addEvent({
                                title: this.scheduleForm.eventTitle,
                                start: moment(this.scheduleForm.eventTimeStart).format(),
                                end: moment(this.scheduleForm.eventTimeEnd).format()
                            });

                            this.showModal = false;
                            this.scheduleForm.eventTitle = '';
                            this.scheduleForm.eventTimeStart = '';
                            this.scheduleForm.eventTimeEnd = '';
                        } else {
                            alert('Please fill out all fields.');
                        }
                        console.log(this.form);

                    },


                    // Close Batch
                    closeBatch(batchId) {
                        const self = this
                        Swal.fire({
                            title: "Confirm completion of this batch?",
                            text: "You and trainees of this batch can still review posts, works, and attendance.",
                            icon: "question",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Confirm"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                self.abortFetch('fetch');
                                self.controller = new AbortController();
                                const signal = self.controller.signal;
                                (async () => {
                                    try {
                                        const response = await axios.post('{{ route('close_batch') }}', {
                                            batch_id: batchId
                                        }, {
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector(
                                                    'meta[name="csrf-token"]').getAttribute(
                                                    'content')
                                            },
                                            signal: signal
                                        });

                                        if (response.data.status == 'success') {
                                            let batch = self.instructor.batches.find(batch => batch
                                                .id === batchId);
                                            batch.completed_at = response.data.date
                                            self.filterBatches()

                                        }
                                        self.notification(response.data.status, response.data.message, '');

                                    } catch (error) {
                                        if (axios.isCancel(error)) {
                                            console.log('Request canceled:', error.message);
                                        } else {
                                            console.error('Error:', error);
                                        }
                                    }
                                })()

                            }
                        });
                    },

                    // Utility
                    xhr: null,
                    controller: null,
                    dataLoading: false,
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
                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : status === 'error' ? toastr.error(
                            message, title ??
                            title) : toastr.info(message, title ?? title);
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "showDuration": "300",
                            "hideDuration": "800",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    },
                }
            }
        </script>
    @endsection
</x-app-layout>
