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

        <div class="overflow-x-auto shadow-md sm:rounded-lg" x-data="batchManager()">
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
                                    :disabled="course.enrollees.length === 0":checked="allChecked"
                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Contact</th>
                        <th scope="col" class="px-6 py-3">Employment</th>
                        <th scope="col" class="px-6 py-3">Preferred Schedule</th>
                        <th scope="col" class="px-6 py-3">Requirements</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="text-xs">
                    <template x-for="user in course.enrollees" :key="user.id">
                        <tr class="border-gray-700 bg-gray-800 hover:bg-gray-800/75">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input type="checkbox" @click.stop @change="toggleUser(user.id)"
                                        :checked="isSelected(user.id)"
                                        class="row-checkbox h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                    <label class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th @click="toggleUser(user.id)" scope="row" class="px-6 py-4">
                                <div class="flex items-center whitespace-nowrap text-white">
                                    <template x-if="user.enrollee_files && user.enrollee_files.length > 0">
                                        <!-- Loop through enrollee_files if they exist -->
                                        <template x-for="file in user.enrollee_files" :key="file.id">
                                            <template x-if="file.credential_type === 'id_picture'">
                                                <img :src="`{{ asset('storage/enrollee_files') }}/${user.course_id}/${user.id}/id_picture/${file.folder}/${file.filename}`"
                                                    class="h-10 w-10 rounded-full" alt="profile">
                                            </template>
                                        </template>

                                        <!-- Show temporary profile picture if no id_picture is found -->
                                        <template
                                            x-if="!user.enrollee_files.some(file => file.credential_type === 'id_picture')">
                                            <img src="{{ asset('images/temporary/profile.png') }}"
                                                class="h-10 w-10 rounded-full" alt="profile">
                                        </template>
                                    </template>
                                    <!-- Show temporary profile picture if enrollee_files is null or empty -->
                                    <template x-if="!user.enrollee_files || user.enrollee_files.length === 0">
                                        <img src="{{ asset('images/temporary/profile.png') }}"
                                            class="h-10 w-10 rounded-full" alt="profile">
                                    </template>
                                    <div class="pl-3">
                                        <div class="text-base font-semibold"
                                            x-text="`${user.user.lname}, ${user.user.fname} ${user.user.mname || ''}`">
                                        </div>
                                        <div class="font-normal text-gray-500" x-text="user.user.email"></div>
                                    </div>
                                </div>
                            </th>
                            <td @click="toggleUser(user.id)" class="px-6 py-4">
                                <div class="flex items-center">
                                    <span x-text="user.user.contact_number ?? '---'"></span>
                                </div>
                            </td>
                            <td @click="toggleUser(user.id)" class="px-6 py-4">
                                <div> <span class="text-white/50">Type: </span> <span
                                        x-text="capitalize(user.employment_type)"></span></div>
                                <div> <span class="text-white/50">Status: </span> <span
                                        x-text="user.employment_type !== 'employed' ? '---' : capitalize(user.employment_status)"></span>
                                </div>
                            </td>
                            <td @click="toggleUser(user.id)" class="px-6 py-4">
                                <div class="capitalize"
                                    x-text="user.preferred_schedule == 'both' ? 'All days' : user.preferred_schedule">
                                </div>
                                <div> <span class="text-white/50">Start: </span> <span
                                        x-text="moment(user.preferred_start).format('MMM D, YYYY')"></span>
                                </div>
                                <div> <span class="text-white/50">Finish: </span> <span
                                        x-text="moment(user.preferred_finish).format('MMM D, YYYY')"></span>
                                </div>
                            </td>
                            <td x-data="{ requiredTypes: ['id_picture', 'valid_id_front', 'valid_id_back', 'diploma_tor', 'birth_certificate'] }" @click="toggleUser(user.id)" class="px-6 py-4">
                                <span class="rounded px-1 py-0.5 text-sm"
                                    :class="{
                                        'bg-red-900 text-red-300': !user.enrollee_files || !requiredTypes.every(type =>
                                            user.enrollee_files.some(file => file.credential_type === type)),
                                        'bg-sky-900 text-sky-300': user.enrollee_files && requiredTypes.every(type =>
                                            user.enrollee_files.some(file => file.credential_type === type))
                                    }"
                                    x-text="user.enrollee_files && requiredTypes.every(type => user.enrollee_files.some(file => file.credential_type === type)) ? 'Complete' : 'Incomplete'">
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="cursor-pointer">
                                    <x-dropdown width="40" align="right">
                                        <x-slot name="trigger">
                                            <button
                                                class="inline-flex items-center rounded-md border border-transparent bg-white text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                                <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="m-1.5">

                                                <a @click="getUserRecord(user.id)"
                                                    class="flex w-full items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M10,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V8C22,6.89 21.1,6 20,6H12L10,4Z" />
                                                    </svg>
                                                    <div>Records</div>
                                                </a>

                                                <x-dropdown-link hover_bg="hover:bg-red-900"
                                                    class="flex items-center space-x-1.5 rounded-md px-1.5"
                                                    @click.prevent="removeEnrollee(user.id)">
                                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M17,13H7V11H17M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                                    </svg>
                                                    <div>
                                                        Remove
                                                    </div>
                                                </x-dropdown-link>

                                            </div>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </td>
                        </tr>
                    </template>
                    {{-- </template> --}}
                </tbody>
            </table>
            <div class="my-4 text-center text-sm text-white/75" x-show="course.enrollees.length === 0">
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
                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
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
                        <div class="relative p-4 md:p-5">
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div class="col-span-2">

                                    <div class="text-white">
                                        <div>
                                            <button @click="create_new_batch(course.id)"
                                                class="mb-1.5 w-full rounded-md bg-sky-700 p-2 text-sm hover:bg-sky-800">Create
                                                New Batch</button>
                                        </div>
                                        <div id="list_uc">
                                            <template x-if="course.batches.length < 1">
                                                <div class="p-2 text-center text-sm text-gray-400">No batches</div>
                                            </template>

                                            <template x-for="batch in course.batches" :key="batch.id">
                                                <div
                                                    class="flex items-center justify-between rounded-md bg-gray-700 p-2 text-sm hover:bg-gray-800/75">
                                                    <span x-text="course.code +'-'+ batch.name"></span>
                                                    <div class="flex">
                                                        <button :disabled="recordsLoading"
                                                            class="h-7 w-7 cursor-pointer rounded-md p-1 hover:bg-gray-600 disabled:cursor-not-allowed"
                                                            @click="addToBatch(batch.id); document.body.classList.add('no-scroll');">
                                                            <svg x-cloak x-show="!recordsLoading"
                                                                class="h-full w-full" fill="currentColor"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <title>plus</title>
                                                                <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
                                                            </svg>
                                                            <svg x-cloak x-show="recordsLoading" aria-hidden="true"
                                                                role="status"
                                                                class="me-3 inline h-4 w-4 animate-spin text-white"
                                                                viewBox="0 0 100 101" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                    fill="#E5E7EB" />
                                                                <path
                                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </button>
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

            {{-- Enrollee Records --}}
            <div x-cloak x-show="recordsModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50 pb-4">
                <div class="relative max-h-full w-full max-w-xl p-4">
                    <!-- Modal content -->
                    <div class="relative rounded-lg bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                            <div class="relative flex items-center whitespace-nowrap text-white">
                                <template x-if="enrolleeProfile?.enrollee_files?.length < 1">
                                    <img src="{{ asset('images/temporary/profile.png') }}"
                                        class="h-12 w-12 rounded-full" alt="profile">
                                </template>
                                <template x-for="file in enrolleeProfile.enrollee_files" :key="file.id">
                                    <template x-if="file.credential_type === 'id_picture'">
                                        <img :src="'{{ asset('storage/enrollee_files/') }}/' +
                                        enrolleeProfile?.course_id + '/' + enrolleeProfile?.id + '/id_picture' +
                                            '/' + file.folder + '/' + file.filename"
                                            class="h-12 w-12 rounded-full" alt="profile">
                                    </template>
                                </template>
                                <div class="pl-3">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white"
                                        x-text="`${enrolleeProfile.user?.fname ?? ''} ${enrolleeProfile.user?.lname ?? ''}`">
                                    </h3>
                                    <div class="font-normal text-gray-400" x-text="enrolleeProfile.user?.email">
                                    </div>
                                </div>
                                <div x-cloak x-show="recordsLoading" role="status"
                                    class="absolute left-1/2 top-2/4 -translate-x-1/2 -translate-y-1/2">
                                    <svg aria-hidden="true"
                                        class="h-8 w-8 animate-spin fill-white text-gray-200 dark:text-gray-600"
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
                            <button type="button" @click="recordsModal = false; showEnrolleeData = false;"
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

                                    <div class="relative mt-4 rounded-md bg-gray-800/75 text-white">
                                        <div
                                            class="absolute -top-4 left-2 mb-2 flex w-1/3 items-center justify-center rounded-md bg-sky-700 py-2 text-white shadow-md">
                                            <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <title>clipboard-outline</title>
                                                <path fill="currentColor"
                                                    d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7Z" />
                                            </svg>
                                            <div>
                                                Trainee's Profile
                                            </div>
                                        </div>

                                        <div class="px-2 pb-4 pt-10">
                                            <div class="ps-4">
                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-yellow-700 p-2 shadow-md"><svg
                                                            class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M20,6C20.58,6 21.05,6.2 21.42,6.59C21.8,7 22,7.45 22,8V19C22,19.55 21.8,20 21.42,20.41C21.05,20.8 20.58,21 20,21H4C3.42,21 2.95,20.8 2.58,20.41C2.2,20 2,19.55 2,19V8C2,7.45 2.2,7 2.58,6.59C2.95,6.2 3.42,6 4,6H8V4C8,3.42 8.2,2.95 8.58,2.58C8.95,2.2 9.42,2 10,2H14C14.58,2 15.05,2.2 15.42,2.58C15.8,2.95 16,3.42 16,4V6H20M4,8V19H20V8H4M14,6V4H10V6H14Z" />
                                                        </svg></span>
                                                    <div class="mb-2 text-gray-300">MANPOWER PROFILE</div>
                                                    <div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">First
                                                                Name:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile.user?.fname"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Middle
                                                                Name:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile.user?.mname ?? '---'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Last Name:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile.user?.lname">
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Address:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="`${enrolleeProfile?.barangayName}, ${enrolleeProfile?.cityName}, ${enrolleeProfile?.provinceName}, ${enrolleeProfile?.regionName}, ${enrolleeProfile?.zip}`"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Sex:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.sex ? capitalize(enrolleeProfile?.sex) : '---'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Civil
                                                                Status:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.civil_status != null ? capitalize(enrolleeProfile?.civil_status) : '---'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Employment
                                                                Type:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.employment_type ? capitalize(enrolleeProfile?.employment_type) : '---'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Employment
                                                                Status:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.employment_status ? capitalize(enrolleeProfile?.employment_status) : '---'"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-green-700 p-2 shadow-md">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                                                        </svg></span>
                                                    <div class="mb-2 text-gray-300">PERSONAL INFORMATION</div>
                                                    <div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Birth
                                                                Date:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="moment(enrolleeProfile?.birth_data).format('ll');"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Birth
                                                                Place:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.birth_place"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Citizenship:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.citizenship"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Religion:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.religion"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Height:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.height + ' cm'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Weight:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.weight + ' kg'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Blood
                                                                Type:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.blood_type ? formatBloodType(enrolleeProfile?.blood_type) : ''"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">SSS
                                                                Number:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.sss ?? '---'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">GSIS
                                                                Number:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.gsis ?? '---'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">TIN
                                                                Number:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.tin ?? '---'"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Distinguishing
                                                                Marks:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="enrolleeProfile?.disting_marks ?? '---'"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-blue-700 p-2 shadow-md">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>school-outline</title>
                                                            <path fill="currentColor"
                                                                d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3M18.82 9L12 12.72L5.18 9L12 5.28L18.82 9M17 16L12 18.72L7 16V12.27L12 15L17 12.27V16Z" />
                                                        </svg></span>
                                                    <div class="mb-2 text-gray-300">EDUCATIONAL BACKGROUND</div>
                                                    <template x-for="education in enrolleeProfile?.enrollee_education"
                                                        :key="education.id">
                                                        <div class="mb-1.5 rounded-md bg-gray-700/50 p-4">
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                <span class="basis-1/2 text-gray-300">School:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.school_name"></span>
                                                            </div>
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                <span class="basis-1/2 text-gray-300">Educational
                                                                    Level:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.educational_level"></span>
                                                            </div>
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                <span class="basis-1/2 text-gray-300">School
                                                                    Year:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.school_year"></span>
                                                            </div>
                                                            <template
                                                                x-if="education?.educational_level == 'Tertiary'">
                                                                <div>
                                                                    <div
                                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                        <span
                                                                            class="basis-1/2 text-gray-300">Degree:</span>
                                                                        <span class="basis-1/2 font-medium"
                                                                            x-text="education?.degree ?? '---'"></span>
                                                                    </div>
                                                                    <div
                                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                        <span
                                                                            class="basis-1/2 text-gray-300">Minor:</span>
                                                                        <span class="basis-1/2 font-medium"
                                                                            x-text="education?.minor ?? '---'"></span>
                                                                    </div>
                                                                    <div
                                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                        <span
                                                                            class="basis-1/2 text-gray-300">Major:</span>
                                                                        <span class="basis-1/2 font-medium"
                                                                            x-text="education?.major ?? '---'"></span>
                                                                    </div>
                                                                    <div
                                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                        <span class="basis-1/2 text-gray-300">Units
                                                                            Earned:</span>
                                                                        <span class="basis-1/2 font-medium"
                                                                            x-text="education?.units_earned ?? '---' "></span>
                                                                    </div>
                                                                    <div
                                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                                        <span class="basis-1/2 text-gray-300">Honors
                                                                            Received:</span>
                                                                        <span class="basis-1/2 font-medium"
                                                                            x-text="education?.honors_received ?? '---'"></span>
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-sky-700 p-2 shadow-md">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M6 20H13V22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.54L18.5 11.72L18 12V4H13V12L10.5 9.75L8 12V4H6V20M24 17L18.5 14L13 17L18.5 20L24 17M15 19.09V21.09L18.5 23L22 21.09V19.09L18.5 21L15 19.09Z" />
                                                        </svg></span>
                                                    <div class="mb-2 text-gray-300">COURSE / TRAINING PROGRAM</div>
                                                    <div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Preffered
                                                                Schedule:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="moment(enrolleeProfile?.preferred_start).format('ll')"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                            <span class="basis-1/2 text-gray-300">Preffered
                                                                Date:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="moment(enrolleeProfile?.preferred_finish).format('ll')"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div class="col-span-2">

                                    <div class="relative mt-4 rounded-md bg-gray-800/75 text-white">
                                        <div
                                            class="absolute -top-4 left-2 mb-2 flex w-1/3 items-center justify-center rounded-md bg-sky-700 py-2 text-white shadow-md">
                                            <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M6,2A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2H6M6,4H13V9H18V20H6V4M8,12V14H16V12H8M8,16V18H13V16H8Z" />
                                            </svg>
                                            <div>
                                                Requirements
                                            </div>
                                        </div>

                                        <div class="px-2 pb-4 pt-10">
                                            <div class="ps-4">
                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-yellow-700 p-2 shadow-md">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>image-outline</title>
                                                            <path fill="currentColor"
                                                                d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M13.96,12.29L11.21,15.83L9.25,13.47L6.5,17H17.5L13.96,12.29Z" />
                                                        </svg>
                                                    </span>
                                                    <div class="mb-2 text-gray-300">ID PICTURE</div>
                                                    <div class="flex justify-center">
                                                        <template
                                                            x-if="enrolleeProfile.enrollee_files && enrolleeProfile.enrollee_files.length > 0">
                                                            <template x-for="file in enrolleeProfile.enrollee_files"
                                                                :key="file.id">
                                                                <template x-if="file.credential_type == 'id_picture'">
                                                                    <img class="rounded-md"
                                                                        :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                        enrolleeProfile?.course_id + '/' +
                                                                            enrolleeProfile?.id + '/id_picture/' + file
                                                                            .folder + '/' + file.filename"
                                                                        alt="" srcset="">
                                                                </template>
                                                            </template>
                                                        </template>

                                                        <template
                                                            x-if="!enrolleeProfile.enrollee_files || enrolleeProfile.enrollee_files.length === 0 || !enrolleeProfile.enrollee_files.some(file => file.credential_type === 'id_picture')">
                                                            <div
                                                                class="flex w-full flex-shrink-0 items-center text-white/50">
                                                                <span class="me-1.5 flex items-center">
                                                                    <svg class="h-5 w-5 text-red-500"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <title>alert-box-outline</title>
                                                                        <path fill="currentColor"
                                                                            d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M11,15H13V17H11V15M11,7H13V13H11V7" />
                                                                    </svg>
                                                                </span>
                                                                <span>
                                                                    ID picture not uploaded
                                                                </span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                </div>
                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-green-700 p-2 shadow-md">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>card-account-details-outline</title>
                                                            <path fill="currentColor"
                                                                d="M22,3H2C0.91,3.04 0.04,3.91 0,5V19C0.04,20.09 0.91,20.96 2,21H22C23.09,20.96 23.96,20.09 24,19V5C23.96,3.91 23.09,3.04 22,3M22,19H2V5H22V19M14,17V15.75C14,14.09 10.66,13.25 9,13.25C7.34,13.25 4,14.09 4,15.75V17H14M9,7A2.5,2.5 0 0,0 6.5,9.5A2.5,2.5 0 0,0 9,12A2.5,2.5 0 0,0 11.5,9.5A2.5,2.5 0 0,0 9,7M14,7V8H20V7H14M14,9V10H20V9H14M14,11V12H18V11H14" />
                                                        </svg>
                                                    </span>
                                                    <div class="mb-2 text-gray-300">VALID ID</div>

                                                    <!-- Check if enrollee_files is defined and not empty -->
                                                    <template
                                                        x-if="enrolleeProfile.enrollee_files && enrolleeProfile.enrollee_files.length > 0">
                                                        <template x-for="file in enrolleeProfile.enrollee_files"
                                                            :key="file.id">
                                                            <div class="flex justify-center">
                                                                <div class="w-full flex-shrink-0">
                                                                    <!-- Display valid_id_front image if available -->
                                                                    <template
                                                                        x-if="file.credential_type === 'valid_id_front'">
                                                                        <img class="m-2 rounded-md"
                                                                            :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                            enrolleeProfile?.course_id + '/' +
                                                                                enrolleeProfile?.id +
                                                                                '/valid_id_front/' +
                                                                                file.folder + '/' + file.filename"
                                                                            alt="" srcset="">
                                                                    </template>

                                                                    <!-- Display valid_id_back image if available -->
                                                                    <template
                                                                        x-if="file.credential_type === 'valid_id_back'">
                                                                        <img class="rounded-md"
                                                                            :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                            enrolleeProfile?.course_id + '/' +
                                                                                enrolleeProfile?.id +
                                                                                '/valid_id_back/' +
                                                                                file.folder + '/' + file.filename"
                                                                            alt="" srcset="">
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </template>

                                                    <!-- Check if enrollee_files is undefined, empty, or missing specific files -->
                                                    <div class="w-full flex-shrink-0">
                                                        <!-- Display missing front ID message -->
                                                        <template
                                                            x-if="!enrolleeProfile.enrollee_files || !enrolleeProfile.enrollee_files.some(file => file.credential_type === 'valid_id_front')">
                                                            <div
                                                                class="mb-2 flex w-full flex-shrink-0 items-center text-white/50">
                                                                <span class="me-1.5 flex items-center">
                                                                    <svg class="h-5 w-5 text-red-500"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <title>alert-box-outline</title>
                                                                        <path fill="currentColor"
                                                                            d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M11,15H13V17H11V15M11,7H13V13H11V7" />
                                                                    </svg>
                                                                </span>
                                                                <span>Valid ID (Front) not uploaded</span>
                                                            </div>
                                                        </template>

                                                        <!-- Display missing back ID message -->
                                                        <template
                                                            x-if="!enrolleeProfile.enrollee_files || !enrolleeProfile.enrollee_files.some(file => file.credential_type === 'valid_id_back')">
                                                            <div
                                                                class="flex w-full flex-shrink-0 items-center text-white/50">
                                                                <span class="me-1.5 flex items-center">
                                                                    <svg class="h-5 w-5 text-red-500"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <title>alert-box-outline</title>
                                                                        <path fill="currentColor"
                                                                            d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M11,15H13V17H11V15M11,7H13V13H11V7" />
                                                                    </svg>
                                                                </span>
                                                                <span>Valid ID (Back) not uploaded</span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                </div>

                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-blue-700 p-2 shadow-md">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>town-hall</title>
                                                            <path fill="currentColor"
                                                                d="M21 10H17V8L12.5 6.2V4H15V2H11.5V6.2L7 8V10H3C2.45 10 2 10.45 2 11V22H10V17H14V22H22V11C22 10.45 21.55 10 21 10M8 20H4V17H8V20M8 15H4V12H8V15M12 8C12.55 8 13 8.45 13 9S12.55 10 12 10 11 9.55 11 9 11.45 8 12 8M14 15H10V12H14V15M20 20H16V17H20V20M20 15H16V12H20V15Z" />
                                                        </svg>
                                                    </span>
                                                    <div class="mb-2 text-gray-300">DIPLOMA/TRANSCRIPT OF RECORDS</div>
                                                    <div class="flex justify-center">
                                                        <!-- Check if enrollee_files is defined and not empty -->
                                                        <template
                                                            x-if="enrolleeProfile.enrollee_files && enrolleeProfile.enrollee_files.length > 0">
                                                            <template x-for="file in enrolleeProfile.enrollee_files"
                                                                :key="file.id">
                                                                <template
                                                                    x-if="file.credential_type === 'diploma_tor'">
                                                                    <img class="rounded-md"
                                                                        :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                        enrolleeProfile?.course_id + '/' +
                                                                            enrolleeProfile?.id +
                                                                            '/diploma_tor/' + file.folder + '/' + file
                                                                            .filename"
                                                                        alt="" srcset="">
                                                                </template>
                                                            </template>
                                                        </template>

                                                        <!-- Check if enrollee_files is undefined, empty, or missing 'diploma_tor' -->
                                                        <template
                                                            x-if="!enrolleeProfile.enrollee_files || !enrolleeProfile.enrollee_files.some(file => file.credential_type === 'diploma_tor')">
                                                            <div
                                                                class="flex w-full flex-shrink-0 items-center text-white/50">
                                                                <span class="me-1.5 flex items-center">
                                                                    <svg class="h-5 w-5 text-red-500"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <title>alert-box-outline</title>
                                                                        <path fill="currentColor"
                                                                            d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M11,15H13V17H11V15M11,7H13V13H11V7" />
                                                                    </svg>
                                                                </span>
                                                                <span>
                                                                    Diploma/TOR not uploaded
                                                                </span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                </div>
                                                <div class="relative mb-2 rounded-md bg-gray-800 p-4 ps-10 text-sm">
                                                    <span
                                                        class="absolute -left-4 top-4 rounded-md bg-sky-700 p-2 shadow-md">
                                                        <svg class="h-7 w-7 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>account-file-outline</title>
                                                            <path fill="currentColor"
                                                                d="M7.5 5C9.43 5 11 6.57 11 8.5C11 10.43 9.43 12 7.5 12C5.57 12 4 10.43 4 8.5C4 6.57 5.57 5 7.5 5M1 19V16.5C1 14.57 4.46 13 7.5 13C8.68 13 9.92 13.24 11 13.64V15.56C10.18 15.22 8.91 15 7.5 15C5 15 3 15.67 3 16.5V17H11V19H1M22 19H14C13.45 19 13 18.55 13 18V6C13 5.45 13.45 5 14 5H19L23 9V18C23 18.55 22.55 19 22 19M15 7V17H21V10H18V7H15M7.5 7C6.67 7 6 7.67 6 8.5C6 9.33 6.67 10 7.5 10C8.33 10 9 9.33 9 8.5C9 7.67 8.33 7 7.5 7Z" />
                                                        </svg>
                                                    </span>
                                                    <div class="mb-2 text-gray-300">BIRTH CERTIFICATE</div>
                                                    <div class="flex justify-center">
                                                        <!-- Check if enrollee_files is defined and not empty -->
                                                        <template
                                                            x-if="enrolleeProfile.enrollee_files && enrolleeProfile.enrollee_files.length > 0">
                                                            <template x-for="file in enrolleeProfile.enrollee_files"
                                                                :key="file.id">
                                                                <template
                                                                    x-if="file.credential_type === 'birth_certificate'">
                                                                    <img class="rounded-md"
                                                                        :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                        enrolleeProfile?.course_id + '/' +
                                                                            enrolleeProfile?.id +
                                                                            '/birth_certificate/' + file.folder + '/' +
                                                                            file.filename"
                                                                        alt="" srcset="">
                                                                </template>
                                                            </template>
                                                        </template>

                                                        <!-- Check if enrollee_files is undefined, empty, or missing 'birth_certificate' -->
                                                        <template
                                                            x-if="!enrolleeProfile.enrollee_files || !enrolleeProfile.enrollee_files.some(file => file.credential_type === 'birth_certificate')">
                                                            <div
                                                                class="flex w-full flex-shrink-0 items-center text-white/50">
                                                                <span class="me-1.5 flex items-center">
                                                                    <svg class="h-5 w-5 text-red-500"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <title>alert-box-outline</title>
                                                                        <path fill="currentColor"
                                                                            d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M11,15H13V17H11V15M11,7H13V13H11V7" />
                                                                    </svg>
                                                                </span>
                                                                <span>
                                                                    Birth Certificate not uploaded
                                                                </span>
                                                            </div>
                                                        </template>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Loading --}}
                            <div role="status" x-show="recordsLoading"
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
                        <div x-cloak x-show="recordsLoading" role="status"
                            class="absolute left-1/2 top-2/4 -translate-x-1/2 -translate-y-1/2">
                            <svg aria-hidden="true"
                                class="h-8 w-8 animate-spin fill-white text-gray-200 dark:text-gray-600"
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
    </div>
    </div>
    @section('script')
        <script>
            function batchManager() {
                return {
                    course: @json($course),
                    selectedUserIds: [],
                    allChecked: false,
                    batchId: null,
                    courseId: null,
                    showBatchesModal: false,


                    recordsLoading: false,

                    init() {
                        // Call method to fetch user locations
                        console.log(this.course); // Debug statement to log the enrollees data
                    },
                    async fetchUserLocations() {

                        const enrollee = this.enrolleeProfile;

                        await Promise.all([
                            this.fetchRegionName(enrollee.region),
                            this.fetchProvinceName(enrollee.province),
                            this.fetchCityName(enrollee.city),
                            this.fetchBarangayName(enrollee.city, enrollee.barangay)
                        ]);
                    },
                    async fetchRegionName(regionCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/regions/${regionCode}`);
                            const data = await response.json();
                            this.enrolleeProfile.regionName = this.capitalize(data.name);
                            console.log(data.name);
                        } catch (error) {
                            console.error('Error fetching region name:', error);
                        }
                    },
                    async fetchProvinceName(provinceCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}`);
                            const data = await response.json();
                            this.enrolleeProfile.provinceName = this.capitalize(data.name);
                        } catch (error) {
                            console.error('Error fetching province name:', error);
                        }
                    },
                    async fetchCityName(cityCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}`);
                            const data = await response.json();
                            this.enrolleeProfile.cityName = this.capitalize(data.name);
                        } catch (error) {
                            console.error('Error fetching city name:', error);
                        }
                    },
                    async fetchBarangayName(cityCode, barangayCode) {
                        try {
                            const response = await fetch(
                                `https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays`);
                            const data = await response.json();
                            const barangay = data.find(barangay => barangay.code === barangayCode);
                            this.enrolleeProfile.barangayName = barangay ? this.capitalize(barangay.name) : '';
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
                        this.allChecked = this.selectedUserIds.length === this.course.enrollees.length;
                        console.log(this.selectedUserIds);
                    },
                    toggleAllCheckboxes(event) {
                        this.allChecked = !this.allChecked;
                        this.selectedUserIds = this.allChecked ? this.course.enrollees.map(user => user.id) : [];
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


                    // Batch List Modal
                    courseId: {{ $course->id }},
                    create_new_batch(courseId) {
                        // console.log(this.courses.find(course => course.id === courseId));
                        var course = this.course
                        var i = this
                        $.ajax({
                            url: "{{ route('create_new_batch') }}",
                            type: "POST",
                            data: {
                                course_id: courseId, // Make sure this matches the request parameter in your Laravel method
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    if (course) {
                                        course.batches.push(response.new_batch)
                                    }

                                    i.notification(response.status, response.message, response.title)
                                } else {
                                    alert(response.message || 'Failed to create batch.');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle different error scenarios
                                let errorMessage = 'Error: ' + error;
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                alert(errorMessage);
                            }
                        });
                    },
                    addToBatch(batchId) {
                        this.recordsLoading = true
                        console.log(this.selectedUserIds);
                        if (this.selectedUserIds.length < 1) {
                            this.notification('error', 'Please select at least one enrollee.');
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
                    },
                    removeEnrollee(enrolleeId) {
                        // console.log(this.courses.find(course => course.id === courseId));
                        var course = this.course
                        var i = this
                        var ajax = {
                            url: "{{ route('remove_enrollee') }}",
                            type: "POST",
                            data: {
                                enrollee_id: enrolleeId,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    let enrolleeIndex = course.enrollees.findIndex(enrollee => enrollee.id ===
                                        enrolleeId);
                                    if (enrolleeIndex !== -1) {
                                        course.enrollees.splice(enrolleeIndex, 1);
                                    }

                                    i.notification(response.status, response.message, response.title)
                                } else {
                                    i.notification(response.status, response.message, response.title);
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle different error scenarios
                                let errorMessage = 'Error: ' + error;
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                alert(errorMessage);
                            }
                        };

                        this.confirmDelete('Are you sure?', 'The enrollee will be removed from the list', 'Continue', ajax);

                    },
                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message, title ??
                            title);
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
                    confirmDelete(title, text, confirmButtonText, ajax) {
                        Swal.fire({
                            title: title,
                            text: text,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: confirmButtonText
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax(ajax)
                            }
                        });
                    },

                    // Records Modal
                    enrolleeProfile: [],
                    recordsModal: false,
                    recordsLoading: false,
                    getUserRecord(enrolleeId) {
                        this.recordsLoading = true
                        // this.abortFetch('ajax')
                        var thisFunction = this;
                        this.enrolleeProfile = [];
                        this.xhr = $.ajax({
                            url: '{{ route('get_enrollee_records') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                enrollee_id: enrolleeId
                            },
                            success: function(response) {
                                thisFunction.enrolleeProfile = response.enrollee_profile;;
                                thisFunction.recordsLoading = false;
                                console.log(thisFunction.enrolleeProfile);
                                thisFunction.fetchUserLocations();
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                        this.recordsModal = true
                    },
                    formatBloodType(bloodType) {
                        if (!bloodType) return '';

                        let formatted = bloodType.replace('_plus', '+').replace('_minus', '-');
                        return formatted.charAt(0).toUpperCase() + formatted.slice(1);
                    },


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
