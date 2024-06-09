<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('All users') }} <span class="text-slate-600">|</span>
            </div>
        </div>

    </x-slot>
    <div class="px-8 pt-36">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" x-data="batchManager({{ $enrollees->toJson() }})">
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
                    <button id="add_to_batch_button" data-modal-toggle="batch-modal" data-modal-target="batch-modal"
                        :disabled="selectedUserIds.length === 0"
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
                    {{-- <template x-if="users.length > 0"> --}}
                    <template x-for="user in users" :key="user.id">
                        <tr @click="toggleUser(user.id)" class="border-gray-700 bg-gray-800 hover:bg-sky-800">
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
                                        x-text="user.employment_type !== 'Employed' ? '---' : user.employment_status"></span>
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
            <div class="mt-4 text-center text-white" x-show="users.length === 0">
                No enrollees
            </div>
            <div id="batch-modal" tabindex="-1" aria-hidden="true"
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
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function usersData() {
                return{
                    users:[],
                    
                }
            }
        </script>
    @endsection
</x-app-layout>
