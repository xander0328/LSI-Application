<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }

        .no-scroll {
        overflow: hidden;
        }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Enrollees') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500">{{ $course->name }}</span>
            </div>
        </div>

    </x-slot>
    <div class="px-8 pt-36">
        {{-- <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div
                class="flex-column flex flex-wrap items-center justify-between space-y-4 bg-white py-4 dark:bg-gray-900 md:flex-row md:space-y-0">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search-users"
                        class="block w-80 rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Search">
                </div>
                <div>
                    <button id="add_to_batch_button" data-modal-toggle="batch-modal" data-modal-target="batch-modal"
                        disabled
                        class="block flex items-center rounded-lg bg-sky-600 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none enabled:hover:bg-blue-800 disabled:opacity-50">
                        <svg class="mr-2 h-5 w-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21a9 9 0 1 1 3-17.5m-8 6 4 4L19.3 5M17 14v6m-3-3h6" />
                        </svg>
                        Add to batch</button>
                </div>
            </div>
            <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="bg-gray-700 text-xs uppercase text-slate-100">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox"
                                    @if ($enrollees->count() == 0) disabled @endif
                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Contacts
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Employment
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Prefered Schedule
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($enrollees->count() > 0)
                        @foreach ($enrollees as $enrollee)
                            <tr data-user-id={{ $enrollee->user_id }}
                                class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox"
                                            class="row-checkbox h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row"
                                    class="flex items-center whitespace-nowrap px-6 py-4 text-gray-900 dark:text-white">
                                    @foreach ($enrollee->enrollee_files as $file)
                                        <img class="h-10 w-10 rounded-full"
                                            src="{{ asset('storage/' . $file->id_picture) }}" alt="profile">
                                    @endforeach
                                    <div class="ps-3">
                                        <div class="text-base font-semibold">{{ $enrollee->user->fname }}
                                            {{ $enrollee->user->lname }}</div>
                                        <div class="font-normal text-gray-500">{{ $enrollee->user->email }}</div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">{{ ucwords(strtolower($enrollee->barangay)) }},
                                    {{ ucwords(strtolower($enrollee->city)) }},
                                    {{ ucwords(strtolower($enrollee->province)) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($enrollee->telephone)
                                            {{ $enrollee->telephone }}
                                        @endif

                                        @if ($enrollee->cellular)
                                            {{ $enrollee->cellular }}
                                        @endif

                                        @if (!$enrollee->telephone && !$enrollee->cellular)
                                            ---
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        Type: {{ ucwords($enrollee->employment_type) }}
                                    </div>
                                    <div>
                                        Status:
                                        {{ $enrollee->employment_type != 'Employed' ? '---' : $enrollee->employment_status }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        {{ ucwords($enrollee->preferred_schedule) }}
                                    </div>
                                    <div>
                                        Start: {{ \Carbon\Carbon::parse($enrollee->preferred_start)->format('Y-m-d') }}
                                    </div>
                                    <div>
                                        Finish:
                                        {{ \Carbon\Carbon::parse($enrollee->preferred_finish)->format('Y-m-d') }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center text-white">
            @if ($enrollees->count() == 0)
                No enrollees
            @endif
        </div> --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" x-data="batchManager({{ $course['enrollees']->toJson() }})">
            <div
                class="flex flex-col items-center justify-between space-y-4 bg-white py-4 dark:bg-gray-900 md:flex-row md:space-y-0">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search-users"
                        class="block w-80 rounded-lg border border-gray-300 bg-gray-50 pl-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Search">
                </div>
                <div>
                    <button @click="triggerBatchesModal()" :disabled="selectedUserIds.length === 0"
                        class="flex items-center rounded-lg bg-sky-600 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none enabled:hover:bg-blue-800 disabled:opacity-50">
                        <svg class="mr-2 h-5 w-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21a9 9 0 1 1 3-17.5m-8 6 4 4L19.3 5M17 14v6m-3-3h6" />
                        </svg>
                        Add to batch
                    </button>
                </div>
            </div>
            <table class="w-full text-left text-sm text-white rtl:text-right">
                <thead class="bg-gray-700 text-xs uppercase text-slate-100">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" @change="toggleAllCheckboxes"
                                    :disabled="users.length === 0":checked="allChecked"
                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Address</th>
                        <th scope="col" class="px-6 py-3">Contacts</th>
                        <th scope="col" class="px-6 py-3">Employment</th>
                        <th scope="col" class="px-6 py-3">Preferred Schedule</th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    <template x-for="user in course.enrollees" :key="user.id">
                        <tr @click="toggleUser(user.id)" class="border-gray-700 bg-gray-800 hover:bg-gray-800/75">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" @click.stop @change="toggleUser(user.id)"
                                        :checked="isSelected(user.id)"
                                        class="row-checkbox h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                    <label class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4">
                                <div class="flex items-center whitespace-nowrap text-white">
                                    <template x-for="file in user.enrollee_files" :key="file.id">
                                        <template x-if="file.credential_type === 'id_picture'">
                                            <img :src="`{{ asset('storage/enrollee_files') }}/${user.course_id}/${user.id}/id_picture/${file.folder}/${file.filename}`"
                                                class="h-10 w-10 rounded-full" alt="profile">
                                        </template>
                                    </template>

                                    <template
                                        x-if="!user.enrollee_files.some(file => file.credential_type === 'id_picture')">
                                        <img src="sample.jpg" class="h-10 w-10 rounded-full" alt="profile">
                                    </template>
                                    <div class="pl-3">
                                        <div class="text-base font-semibold"
                                            x-text="user.user.fname + ' ' + user.user.lname"></div>
                                        <div class="font-normal text-gray-500" x-text="user.user.email"></div>
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-4"
                                x-text="user.barangayName + ', ' + user.cityName + ', ' + user.provinceName">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span x-text="user.telephone ?? ''"></span>
                                    <span x-text="user.cellular ?? ''"></span>
                                    <template x-if="!user.telephone && !user.cellular">
                                        <span>---</span>
                                    </template>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>Type: <span x-text="capitalize(user.employment_type)"></span></div>
                                <div>Status: <span
                                        x-text="user.employment_type !== 'employed' ? '---' : capitalize(user.employment_status)"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div x-text="capitalize(user.preferred_schedule)"></div>
                                <div>Start: <span x-text="moment(user.preferred_start).format('MMM D, YYYY')"></span>
                                </div>
                                <div>Finish: <span x-text="moment(user.preferred_finish).format('MMM D, YYYY')"></span>
                                </div>
                            </td>
                        </tr>
                    </template>
                    {{-- </template> --}}
                </tbody>
            </table>
            <div class="my-4 text-sm text-center text-white/75" x-show="users.length === 0">
                No enrollees
            </div>
            {{-- <div id="batch-modal" tabindex="-1" aria-hidden="true"
                class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
                <div class="relative max-h-full w-full max-w-md p-4">
                    <!-- Modal content -->
                    <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Select Batch
                            </h3>
                            <button type="button"
                                class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="batch-modal">
                                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-2">
                            <button @click="createBatch"
                                class="block flex w-full items-center justify-center rounded-lg bg-sky-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none">
                                <svg class="mr-2 h-5 w-5 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 12h14m-7 7V5" />
                                </svg><span>Create New</span></button>
                            <ul class="mt-2 rounded-md bg-gray-800 p-2">
                                <div class="py-3 text-center font-bold text-white">List of Batches</div>
                                <template x-for="batch in batches" :key="batch.id">
                                    <li class="cursor-pointer rounded-md px-2 py-1 text-white hover:bg-gray-900">
                                        <button @click="addToBatch(batch.id)" class="flex items-center">
                                            <svg class="mr-2 h-3 w-3 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M10.3 5.6A2 2 0 0 0 7 7v10a2 2 0 0 0 3.3 1.5l5.9-4.9a2 2 0 0 0 0-3l-6-5Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <div class="font-normal" x-text="batch.name"></div>
                                        </button>
                                    </li>
                                </template>
                            </ul>
                        </div>

                    </div>
                </div>
            </div> --}}

            {{-- List of Batches Modal --}}
            <div x-cloak x-show="showBatchesModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50 overflow-y-auto overflow-x-hidden">
                <div class="relative max-h-full w-full max-w-lg p-4">
                    <!-- Modal content -->
                    <div class="relative rounded-lg bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Batches | <span class="text-xs" x-text="course.name"></span>
                            </h3>
                            <button type="button" @click="showBatchesModal = !showBatchesModal"
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
                        <div class="p-4 md:p-5">
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div class="col-span-2">

                                    <div class="text-white">
                                        <div>
                                            <button @click="create_new_batch(course.id)"
                                                class=" w-full text-sm mb-1.5 rounded-md p-2 bg-sky-700 hover:bg-sky-800">Create
                                                New Batch</button>
                                        </div>
                                        <div id="list_uc">
                                            <template x-if="course.batches.length < 1">
                                                <div class="p-2 text-sm text-gray-400  text-center">No batches</div>
                                            </template>

                                            <template x-for="batch in course.batches" :key="batch.id">
                                                <div
                                                    class="flex items-center justify-between bg-gray-700 p-2 text-sm hover:bg-gray-800/75 rounded-md">
                                                    <span x-text="course.code +'-'+ batch.name"></span>
                                                    <div class="flex">
                                                        <form action="{{ route('delete_batch') }}"
                                                            class="h-7 w-7 rounded-md p-1 hover:bg-gray-600"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="batch_id"
                                                                :value="batch.id">

                                                            <button @click.prevent="confirmDelete()"
                                                                class="h-full w-full" type="button">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function batchManager(enrollees) {
                return {
                    course: @json($course),
                    users: [],
                    selectedUserIds: [],
                    allChecked: false,
                    batchId: null,
                    courseId: null,
                    showBatchesModal: false,
                    init() {
                        this.users = Object.values(enrollees);
                        this.fetchUserLocations(); // Call method to fetch user locations
                        console.log(this.users); // Debug statement to log the enrollees data
                    },
                    async fetchUserLocations() {
                        for (let i = 0; i < this.users.length; i++) {
                            const user = this.users[i];
                            await Promise.all([
                                this.fetchRegionName(user.region, i),
                                this.fetchProvinceName(user.province, i),
                                this.fetchCityName(user.city, i),
                                this.fetchBarangayName(user.city, user.barangay, i)
                            ]);
                        }
                    },
                    async fetchRegionName(regionCode, index) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/regions/${regionCode}`);
                            const data = await response.json();
                            this.users[index].regionName = this.capitalize(data.name);
                            console.log(data.name);
                        } catch (error) {
                            console.error('Error fetching region name:', error);
                        }
                    },
                    async fetchProvinceName(provinceCode, index) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}`);
                            const data = await response.json();
                            this.users[index].provinceName = this.capitalize(data.name);
                        } catch (error) {
                            console.error('Error fetching province name:', error);
                        }
                    },
                    async fetchCityName(cityCode, index) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}`);
                            const data = await response.json();
                            this.users[index].cityName = this.capitalize(data.name);
                        } catch (error) {
                            console.error('Error fetching city name:', error);
                        }
                    },
                    async fetchBarangayName(cityCode, barangayCode, index) {
                        try {
                            const response = await fetch(
                                `https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays`);
                            const data = await response.json();
                            const barangay = data.find(barangay => barangay.code === barangayCode);
                            this.users[index].barangayName = barangay ? this.capitalize(barangay.name) : '';
                        } catch (error) {
                            console.error('Error fetching barangay name:', error);
                        }
                    },
                    toggleUser(userId) {
                        if (this.selectedUserIds.includes(userId)) {
                            this.selectedUserIds = this.selectedUserIds.filter(id => id !== userId);
                        } else {
                            this.selectedUserIds.push(userId);
                        }
                        this.allChecked = this.selectedUserIds.length === this.users.length;
                        console.log(this.selectedUserIds);
                    },
                    toggleAllCheckboxes(event) {
                        this.allChecked = !this.allChecked;
                        this.selectedUserIds = this.allChecked ? this.users.map(user => user.id) : [];
                    },
                    isSelected(userId) {
                        return this.selectedUserIds.includes(userId);
                    },
                    capitalize(str) {
                        return str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
                    },
                    triggerBatchesModal() {
                        this.showBatchesModal = !this.showBatchesModal;
                    },



                    courseId: {{ $course->id }},
                    createBatch() {
                        // Implement create batch functionality here
                        console.log('Creating new batch for course ID: ' + this.courseId);
                    },
                    addToBatch(batchId) {
                        console.log(this.selectedUserIds);
                        if (this.selectedUserIds.length < 1) {
                            alert('Please select at least one user.');
                            return;
                        }
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: "{{ route('add_to_batch') }}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                user_ids: this.selectedUserIds,
                                batch_id: batchId,
                            },
                            success: function(response) {
                                $('#success-alert').removeClass('hidden').delay(3000)
                                    .fadeOut(); // Show for 3 seconds
                                location.reload();
                                console.log(this.selectedUserIds);
                                // alert('Selected users have been saved to the batch.');
                            },
                            error: function(xhr, status, error) {
                                console.error('Error saving to batch:', error);
                                alert('An error occurred while saving to the batch.');
                            }
                        });
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
{{-- <script type="text/javascript">
                //Add to batch button
    function add_to_batch(batch_id) {
        if (selectedUserIds.length === 0) {
            alert('Please select at least one user.');
            return;
        }

        // Send an AJAX request to save selected user IDs to the batches table
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ route('add_to_batch') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                user_ids: selectedUserIds,
                batch_id: batch_id,
            },
            success: function(response) {
                $('#success-alert').removeClass('hidden').delay(3000).fadeOut(); // Show for 3 seconds
                location.reload();
                console.log(selectedUserIds);
                // alert('Selected users have been saved to the batch.');
            },
            error: function(xhr, status, error) {
                console.error('Error saving to batch:', error);
                alert('An error occurred while saving to the batch.');
            }
        });
    }

    // Create batch
    function create_batch(course_id) {
        console.log(course_id);
        $.ajax({
            url: "{{ route('generate_batch_name') }}",
            method: "GET",
            data: {
                courseid: course_id,
            },
            success: function(newBatchName) {
                var batchData = {
                    batch_name: newBatchName,
                    courseid: course_id,
                };

                $.ajax({
                    url: "{{ route('create_batch') }}",
                    method: "POST",
                    data: batchData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload();

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Check All Checkbox
    $(document).ready(function() {
        $('#checkbox-all-search').change(function() {
            var isChecked = $(this).prop('checked');
            $('.row-checkbox').prop('checked', isChecked).change();
        });
    });


    window.onload = function() {
        var elements = document.querySelectorAll('[id^="address_"]');
        var barangay, city, province;
        elements.forEach(function(element) {
            $.ajax({
                url: 'https://psgc.gitlab.io/api/barangays/{{ $enrollee->barangay ?? '' }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    barangay = data.name;
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching barangays:', error);
                }
            });

            $.ajax({
                url: 'https://psgc.gitlab.io/api/cities-municipalities/{{ $enrollee->city ?? '' }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    city = data.name;
                    console.log(city);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching barangays:', error);
                }
            });

            $.ajax({
                url: 'https://psgc.gitlab.io/api/provinces/{{ $enrollee->province ?? '' }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    province = data.name;
                    $('#address_{{ $enrollee->user_id ?? '' }}').text(barangay + ', ' + city +
                        ', ' +
                        province)
                    console.log(province);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching barangays:', error);
                }
            });

        });
    };
</script> --}}
