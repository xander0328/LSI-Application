<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Users') }}
            </div>
            <div class="flex w-1/2 items-center justify-end md:w-1/3">
                <span class="me-1 pr-2 text-sm text-gray-600 dark:text-gray-400 md:me-1.5">
                    Role
                </span>
                <div class="w-full">
                    <select id="role_select"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                        <option {{ $role == 'all' ? 'selected' : '' }} value="all">All</option>
                        <option {{ $role == 'guest' ? 'selected' : '' }} value="guest">Guest</option>
                        <option {{ $role == 'student' ? 'selected' : '' }} value="student">Student</option>
                        <option {{ $role == 'instructor' ? 'selected' : '' }} value="instructor">Instructor</option>
                    </select>
                </div>
            </div>
        </div>

    </x-slot>
    <div x-data="manageUsers" class="p-2 px-4 pb-16 pt-40 md:px-8">
        <div class="overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
            <div
                class="flex flex-col space-y-3 bg-gray-400 px-4 py-3 dark:bg-gray-700/50 lg:flex-row lg:items-center lg:justify-between lg:space-x-4 lg:space-y-0">
                <div
                    class="flex flex-shrink-0 flex-col space-y-1.5 text-sm md:flex-row md:items-center md:justify-end md:space-x-3 md:space-y-0">

                    <button type="button"
                        class="hover:text-primary-700 flex flex-shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Export as PDF
                    </button>
                    <button type="button"
                        class="hover:text-primary-700 flex flex-shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Export as Excel
                    </button>
                </div>
            </div>
            <div
                class="items-center justify-between space-y-4 bg-white px-4 py-4 dark:bg-gray-800 md:flex-row md:space-y-0">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M10 4C12.2 4 14 5.8 14 8S12.2 12 10 12 6 10.2 6 8 7.8 4 10 4M17 21L18.8 22.77C19.3 23.27 20 22.87 20 22.28V18L22.8 14.6C23.3 13.9 22.8 13 22 13H15C14.2 13 13.7 14 14.2 14.6L17 18V21M15 18.7L12.7 15.9C12.3 15.4 12.1 14.8 12.1 14.2C11.4 14 10.7 14 10 14C5.6 14 2 15.8 2 18V20H15V18.7Z" />
                        </svg>
                    </div>
                    <input autocomplete="off" type="text" id="table-search-users" x-model="searchQuery"
                        @keyup.enter="searchUsers" @input="$el.value ==  '' ? searchUsers() : ''"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 pl-10 pt-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                        placeholder="Name or Email">
                </div>
            </div>
            <div class="overflow-x-auto rounded-b-lg shadow-md">
                <table class="text-smtext-white w-full text-left rtl:text-right">
                    <thead class="bg-gray-400 text-xs uppercase text-black dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            {{-- <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox" @change="toggleAllCheckboxes"
                                        :disabled="users.length === 0":checked="allChecked"
                                        class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th> --}}
                            <th scope="col" class="px-6 py-3">
                                <span class="hidden md:block">
                                    Name
                                </span>
                                <span class="md:hidden">
                                    User
                                </span>
                            </th>
                            <th scope="col" class="hidden px-6 py-3 md:table-cell">Contact</th>
                            <th scope="col" class="hidden px-6 py-3 md:table-cell">Role</th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        {{-- <template x-if="users.length > 0"> --}}
                        <template x-for="user in users" :key="user.id">
                            <tr
                                class="border-b border-gray-700 bg-white hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-800/50">
                                {{-- <td class="w-4 p-4" @click="toggleUser(user.id)">
                                    <div class="flex items-center">
                                        <input type="checkbox" @click.stop @change="toggleUser(user.id)"
                                            :checked="isSelected(user.id)"
                                            class="row-checkbox h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800">
                                        <label class="sr-only">checkbox</label>
                                    </div>
                                </td> --}}
                                <th scope="row" class="px-6 py-4">
                                    <div class="flex items-center whitespace-nowrap text-black dark:text-white">
                                        <div class="">
                                            <div class="text-sm font-semibold md:text-base"
                                                x-text="`${user.lname}, ${user.fname} ${user.mname || ''}`"></div>
                                            <div class="font-normal text-gray-500" x-text="user.email"></div>
                                            <div class="font-normal text-gray-500 md:hidden"
                                                x-text="user.contact_number"></div>
                                            <div class="flex items-center md:hidden">
                                                <span
                                                    :class="{
                                                        'bg-sky-900 text-sky-300': user.role == 'student',
                                                        'bg-yellow-900 text-yellow-300': user.role == 'guest',
                                                        'bg-green-900 text-green-300': user.role == 'instructor',
                                                    }"
                                                    class="rounded px-2 py-0.5 text-xs font-medium"
                                                    x-text="capitalize(user.role) ?? ''"></span>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <td class="hidden px-6 py-4 md:table-cell">
                                    <div class="flex items-center">
                                        <span x-text="user.contact_number ?? '---'"></span>
                                    </div>
                                </td>
                                <td class="hidden px-6 py-4 md:table-cell">
                                    <div class="flex items-center">
                                        <span
                                            :class="{
                                                'bg-sky-900 text-sky-300': user.role == 'student',
                                                'bg-yellow-900 text-yellow-300': user.role == 'guest',
                                                'bg-green-900 text-green-300': user.role == 'instructor',
                                            }"
                                            class="rounded px-2 py-0.5 text-xs font-medium"
                                            x-text="capitalize(user.role) ?? ''"></span>
                                    </div>
                                </td>
                                <td class="flex items-center justify-end px-4 py-6">
                                    <div class="cursor-pointer">
                                        <x-dropdown width="40" align="right">
                                            <x-slot name="trigger">
                                                <button
                                                    class="inline-flex items-center rounded-md border border-transparent bg-gray-200 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                                                    <svg class="hidden h-7 w-7 text-black dark:text-white md:block"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M16,12A2,2 0 0,1 18,10A2,2 0 0,1 20,12A2,2 0 0,1 18,14A2,2 0 0,1 16,12M10,12A2,2 0 0,1 12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12M4,12A2,2 0 0,1 6,10A2,2 0 0,1 8,12A2,2 0 0,1 6,14A2,2 0 0,1 4,12Z" />
                                                    </svg>
                                                    <svg class="h-7 w-7 text-black dark:text-white md:hidden"
                                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <title>dots-vertical</title>
                                                        <path
                                                            d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z" />
                                                    </svg>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <div class="m-1.5">

                                                    <template x-if="user.role === 'guest'">
                                                        <form method="POST" action="{{ route('promote_user') }}">
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                :value="user.id">

                                                            <x-dropdown-link hover_bg="hover:bg-gray-800"
                                                                class="flex items-center space-x-1.5 rounded-md px-1.5"
                                                                @click.prevent="promoteUser">
                                                                <svg class="h-4 w-4"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill="currentColor"
                                                                        d="M12,3L1,9L12,15L21,10.09V17H23V9M5,13.18V17.18L12,21L19,17.18V13.18L12,17L5,13.18Z" />
                                                                </svg>
                                                                <div>
                                                                    Promote
                                                                </div>
                                                            </x-dropdown-link>
                                                        </form>
                                                    </template>

                                                    <template x-if="user.role === 'instructor'">
                                                        <div>
                                                            <form method="POST" action="{{ route('disable_user') }}">
                                                                @csrf
                                                                <input type="hidden" name="user_id"
                                                                    :value="user.id">

                                                                <x-dropdown-link hover_bg="hover:bg-gray-800"
                                                                    class="flex items-center space-x-1.5 rounded-md px-1.5"
                                                                    :href="route('delete_post')" @click.prevent="disableUser">
                                                                    <svg class="h-4 w-4"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24">
                                                                        <path fill="currentColor"
                                                                            d="M12 0L11.34 .03L15.15 3.84L16.5 2.5C19.75 4.07 22.09 7.24 22.45 11H23.95C23.44 4.84 18.29 0 12 0M12 4C10.07 4 8.5 5.57 8.5 7.5C8.5 9.43 10.07 11 12 11C13.93 11 15.5 9.43 15.5 7.5C15.5 5.57 13.93 4 12 4M.05 13C.56 19.16 5.71 24 12 24L12.66 23.97L8.85 20.16L7.5 21.5C4.25 19.94 1.91 16.76 1.55 13H.05M12 13C8.13 13 5 14.57 5 16.5V18H19V16.5C19 14.57 15.87 13 12 13Z" />
                                                                    </svg>
                                                                    <div>
                                                                        Demote
                                                                    </div>
                                                                </x-dropdown-link>
                                                            </form>
                                                        </div>
                                                    </template>

                                                    <template x-if="user.role === 'student'">
                                                        <a @click="getUserRecord(user.id)"
                                                            class="flex w-full items-center space-x-1.5 rounded-md px-4 py-2 text-start text-sm leading-5 transition duration-150 ease-in-out hover:bg-gray-800 hover:text-white focus:outline-none">
                                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M10,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V8C22,6.89 21.1,6 20,6H12L10,4Z" />
                                                            </svg>
                                                            <div>Records</div>
                                                        </a>
                                                    </template>

                                                    <form method="POST" action="{{ route('disable_user') }}">
                                                        @csrf
                                                        <input type="hidden" name="user_id" :value="user.id">

                                                        <x-dropdown-link hover_bg="hover:bg-red-900"
                                                            class="flex items-center space-x-1.5 rounded-md px-1.5"
                                                            :href="route('delete_post')" @click.prevent="disableUser">
                                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24">
                                                                <path fill="currentColor"
                                                                    d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                            </svg>
                                                            <div>
                                                                Disable
                                                            </div>
                                                        </x-dropdown-link>
                                                    </form>

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

                <div class="border-b border-gray-400 py-4 text-center text-sm text-white/75 dark:border-gray-700"
                    x-show="users.length === 0"
                    x-text="'No '+ (
                        '{{ $role }}' === 'all' ? 'Users' :
                        '{{ $role }}' === 'student' ? 'Students' :
                        '{{ $role }}' === 'guest' ? 'Guests' :
                        '{{ $role }}' === 'instructor' ? 'Instructors' : '' )">
                    No Users
                </div>

            </div>
            <div class="rounded-b-lg">
                <nav class="flex flex-col items-start justify-between space-y-3 p-4 md:flex-row md:items-center md:space-y-0"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                        Showing
                        <span class="font-semibold text-gray-900 dark:text-white" x-text="users.length"></span>
                        of
                        <span class="font-semibold text-gray-900 dark:text-white" x-text="usersRoleCount"></span>
                    </span>
                </nav>

            </div>

            {{-- Records Modal --}}
            <div x-cloak x-show="recordsModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50">
                <div class="relative max-h-full w-full max-w-xl p-4">
                    <!-- Modal content -->
                    <div class="relative rounded-lg bg-white dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                            <div class="flex items-center whitespace-nowrap text-white">
                                <template x-if="latestEnrollment?.enrollee_files?.length < 1">
                                    <img src="{{ asset('images/temporary/profile.png') }}"
                                        class="h-12 w-12 rounded-full" alt="profile">
                                </template>
                                <template x-if="latestEnrollment">
                                    <template x-for="file in latestEnrollment.enrollee_files" :key="file.id">
                                        <template x-if="file.credential_type === 'id_picture'">
                                            <img :src="'{{ asset('storage/enrollee_files/') }}/' +
                                            latestEnrollment?.course_id + '/' + latestEnrollment?.id + '/id_picture' +
                                                '/' + file.folder + '/' + file.filename"
                                                class="h-12 w-12 rounded-full" alt="profile">
                                        </template>
                                    </template>
                                </template>
                                <div class="pl-3">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white"
                                        x-text="`${userRecords.fname ?? ''} ${userRecords.lname ?? ''}`">
                                    </h3>
                                    <div class="font-normal text-gray-400" x-text="userRecords.email"></div>
                                </div>
                            </div>
                            <button type="button" @click="triggerModal('records'); showEnrolleeData = false;"
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

                                    <div
                                        class="relative mt-4 rounded-md bg-gray-300 text-black dark:bg-gray-800/75 dark:text-white">
                                        {{-- <div>
                                        <button @click="create_new_batch(course.id)"
                                            class="mb-1.5 w-full rounded-md bg-sky-700 p-2 text-sm hover:bg-sky-800">Create
                                            New Batch</button>
                                        </div> --}}
                                        <div
                                            class="absolute -top-4 left-2 mb-2 flex w-1/3 items-center justify-center rounded-md bg-sky-700 py-2 text-white shadow-md">
                                            <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <title>clipboard-outline</title>
                                                <path fill="currentColor"
                                                    d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7Z" />
                                            </svg>
                                            <div>
                                                Enrollment
                                            </div>
                                        </div>
                                        <div class="px-2 pb-4 pt-10">
                                            <template
                                                x-if="userRecords?.enrollee?.every(record => record.batch === null && record.batch_id != null);">
                                                <div class="p-2 text-center text-sm text-gray-600 dark:text-gray-400">
                                                    No Records</div>
                                            </template>

                                            <template
                                                x-if="userRecords?.enrollee?.some(record => record.batch !== null || record.batch_id == null)">
                                                <ol
                                                    class="relative ms-5 border-s border-gray-700 p-2 text-sm text-black dark:text-gray-300">
                                                    <template x-for="enrollee in userRecords.enrollee"
                                                        :key="enrollee.id">
                                                        <template
                                                            x-if="enrollee.batch != null || enrollee.batch_id == null">
                                                            <li @click="showData(enrollee.id)"
                                                                class="mb-2 ms-4 flex cursor-pointer items-center justify-between rounded-md bg-white p-2 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-800/75">
                                                                <span
                                                                    :class="enrollee.completed_at != null && enrollee
                                                                        .batch_id !=
                                                                        null ? 'bg-sky-300' : 'bg-sky-700'"
                                                                    class="absolute -start-2 flex h-4 w-4 items-center justify-center rounded-full">

                                                                </span>
                                                                <span
                                                                    x-text="enrollee.batch_id == null ? enrollee.course.code : `${enrollee.course.code}-${enrollee.batch.name}`"></span>

                                                                <div class="flex items-center">
                                                                    <div class="flex items-center">
                                                                        <div :class="{
                                                                            'bg-red-900 text-red-300': enrollee
                                                                                .batch_id ==
                                                                                null,
                                                                            'bg-yellow-900 text-yellow-300': enrollee
                                                                                .completed_at ==
                                                                                null && enrollee.batch_id != null,
                                                                            'bg-sky-900 text-sky-300': enrollee
                                                                                .completed_at !=
                                                                                null && enrollee.batch_id != null,
                                                                        }"
                                                                            class="rounded px-2 py-0.5 text-sm"
                                                                            x-text="enrollee.batch_id == null ? 'Not Enrolled' : enrollee.completed_at != null ? 'Completed' : 'Ongoing'">
                                                                        </div>
                                                                    </div>
                                                            </li>

                                                        </template>
                                                    </template>
                                                </ol>
                                            </template>

                                        </div>
                                    </div>

                                    <div x-cloak x-show="showEnrolleeData"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="relative mt-4 rounded-md bg-gray-300 p-4 text-black dark:bg-gray-800/75 dark:text-white">
                                        <div class="mb-2 flex items-center justify-between">
                                            <div class="text-xl">Enrollee Data</div>
                                            <button type="button" @click="showEnrolleeData = false"
                                                class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="ps-4">
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-yellow-700 p-2 shadow-md"><svg
                                                        class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M20,6C20.58,6 21.05,6.2 21.42,6.59C21.8,7 22,7.45 22,8V19C22,19.55 21.8,20 21.42,20.41C21.05,20.8 20.58,21 20,21H4C3.42,21 2.95,20.8 2.58,20.41C2.2,20 2,19.55 2,19V8C2,7.45 2.2,7 2.58,6.59C2.95,6.2 3.42,6 4,6H8V4C8,3.42 8.2,2.95 8.58,2.58C8.95,2.2 9.42,2 10,2H14C14.58,2 15.05,2.2 15.42,2.58C15.8,2.95 16,3.42 16,4V6H20M4,8V19H20V8H4M14,6V4H10V6H14Z" />
                                                    </svg></span>
                                                <div class="mb-2 dark:text-gray-300">MANPOWER PROFILE</div>
                                                <div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">First Name:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="userRecords.fname"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Middle Name:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="userRecords.mname ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Last Name:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="userRecords.lname">
                                                            Salvador</span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Address:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="`${enrolleeData?.barangayName}, ${enrolleeData?.cityName}, ${enrolleeData?.provinceName}, ${enrolleeData?.regionName}, ${enrolleeData?.zip}`"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Sex:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.sex ? capitalize(enrolleeData?.sex) : '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Civil Status:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.civil_status != null ? capitalize(enrolleeData?.civil_status) : '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Employment
                                                            Type:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.employment_type ? capitalize(enrolleeData?.employment_type) : '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Employment
                                                            Status:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.employment_status ? capitalize(enrolleeData?.employment_status) : '---'"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-green-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                                                    </svg></span>
                                                <div class="mb-2 dark:text-gray-300">PERSONAL INFORMATION</div>
                                                <div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Birth Date:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="moment(enrolleeData?.birth_data).format('ll');"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Birth Place:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.birth_place"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Citizenship:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.citizenship"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Religion:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.religion"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Height:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.height + ' cm'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Weight:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.weight + ' kg'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Blood Type:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.blood_type ? formatBloodType(enrolleeData?.blood_type) : ''"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">SSS Number:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.sss ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">GSIS Number:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.gsis ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">TIN Number:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.tin ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Distinguishing
                                                            Marks:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.disting_marks ?? '---'"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-blue-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <title>school-outline</title>
                                                        <path fill="currentColor"
                                                            d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3M18.82 9L12 12.72L5.18 9L12 5.28L18.82 9M17 16L12 18.72L7 16V12.27L12 15L17 12.27V16Z" />
                                                    </svg></span>
                                                <div class="mb-2 dark:text-gray-300">EDUCATIONAL BACKGROUND</div>
                                                <template x-for="education in enrolleeData?.enrollee_education"
                                                    :key="education.id">
                                                    <div class="mb-1.5 rounded-md bg-gray-100 p-4 dark:bg-gray-700/50">
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                            <span class="basis-1/2 dark:text-gray-300">School:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="education?.school_name"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                            <span class="basis-1/2 dark:text-gray-300">Educational
                                                                Level:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="education?.educational_level"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                            <span class="basis-1/2 dark:text-gray-300">School
                                                                Year:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="education?.school_year"></span>
                                                        </div>
                                                        <template x-if="education?.educational_level == 'Tertiary'">
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                <span
                                                                    class="basis-1/2 dark:text-gray-300">Degree:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.degree ?? '---'"></span>
                                                            </div>
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                <span
                                                                    class="basis-1/2 dark:text-gray-300">Minor:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.minor ?? '---'"></span>
                                                            </div>
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                <span
                                                                    class="basis-1/2 dark:text-gray-300">Major:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.major ?? '---'"></span>
                                                            </div>
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                <span class="basis-1/2 dark:text-gray-300">Units
                                                                    Earned:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.units_earned ?? '---' "></span>
                                                            </div>
                                                            <div
                                                                class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                <span class="basis-1/2 dark:text-gray-300">Honors
                                                                    Received:</span>
                                                                <span class="basis-1/2 font-medium"
                                                                    x-text="education?.honors_received ?? '---'"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-sky-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M6 20H13V22H6C4.89 22 4 21.11 4 20V4C4 2.9 4.89 2 6 2H18C19.11 2 20 2.9 20 4V12.54L18.5 11.72L18 12V4H13V12L10.5 9.75L8 12V4H6V20M24 17L18.5 14L13 17L18.5 20L24 17M15 19.09V21.09L18.5 23L22 21.09V19.09L18.5 21L15 19.09Z" />
                                                    </svg></span>
                                                <div class="mb-2 dark:text-gray-300">COURSE / TRAINING PROGRAM</div>
                                                <div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Title:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="enrolleeData?.course.name"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Preffered
                                                            Schedule:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="moment(enrolleeData?.preferred_start).format('ll')"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2 dark:text-gray-300">Preffered
                                                            Date:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="moment(enrolleeData?.preferred_finish).format('ll')"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div x-cloak x-show="recordsLoading" role="status"
                                class="absolute left-1/2 top-2/4 -translate-x-1/2 -translate-y-1/2">
                                <svg aria-hidden="true"
                                    class="h-8 w-8 animate-spin fill-white text-gray-200 dark:fill-gray-600 dark:text-gray-600"
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
        <template x-if="users.length < usersRoleCount">
            <div class="flex items-center justify-end pt-2">
                <div x-cloak x-show="loadingFetch" class="p-2" role="status">
                    <svg aria-hidden="true"
                        class="inline h-6 w-6 animate-spin fill-gray-600 text-gray-200 dark:fill-gray-300 dark:text-gray-600"
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
                <button type="button" id="load_more_button" @click="loadMoreUsers" :disabled="loadingFetch"
                    class="hover:text-primary-700 flex flex-shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M2 12C2 16.97 6.03 21 11 21C13.39 21 15.68 20.06 17.4 18.4L15.9 16.9C14.63 18.25 12.86 19 11 19C4.76 19 1.64 11.46 6.05 7.05C10.46 2.64 18 5.77 18 12H15L19 16H19.1L23 12H20C20 7.03 15.97 3 11 3C6.03 3 2 7.03 2 12Z" />
                    </svg>
                    Load More
                </button>
            </div>
        </template>
    </div>
    @section('script')
        <script>
            function manageUsers() {
                return {
                    // Data Containers
                    users: @json($users),
                    originalUsers: @json($users),
                    originalData: {
                        users: @json($users),
                        usersRoleCount: {{ $users_role_count }},
                        offset: 20,
                    },
                    usersRoleCount: {{ $users_role_count }},
                    selectedUserIds: [],
                    userRecords: [],
                    latestEnrollment: null,
                    allChecked: false,
                    searchQuery: '',
                    enrolleeData: null,

                    // Loading 
                    loadingFetch: false,
                    recordsLoading: false,
                    removeSessionLoading: false,

                    // Modal Triggers
                    recordsModal: false,
                    showEnrolleeData: false,

                    // Data Chunking
                    offset: 0,
                    chunkSize: 20,

                    // Preventing Multiple Requests
                    controller: null,
                    xhr: null,

                    init() {
                        this.offset = this.users ? this.users.length : 0
                        console.log(this.offset);

                        const role_select = $('#role_select');
                        role_select.on('change', () => {
                            this.roleChanged(role_select.val());
                        });

                    },
                    // Checkbox
                    toggleUser(userId) {
                        if (this.selectedUserIds.includes(userId)) {
                            this.selectedUserIds = this.selectedUserIds.filter(id => id !== userId);
                        } else {
                            this.selectedUserIds.push(userId);
                        }
                        this.allChecked = this.selectedUserIds.length === this.originalUsers.length;
                        console.log(this.selectedUserIds);
                    },
                    toggleAllCheckboxes(event) {
                        this.allChecked = !this.allChecked;
                        this.selectedUserIds = this.allChecked ? this.originalUsers.map(user => user.id) : [];
                    },
                    isSelected(userId) {
                        return this.selectedUserIds.includes(userId);
                    },

                    // Utility
                    capitalize(str) {
                        return str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
                    },
                    roleChanged(role) {
                        window.location.href = '/users?role=' + role;
                    },
                    triggerModal(modal) {
                        if (modal == 'records') {
                            this.recordsModal = !this.recordsModal;
                        }
                    },
                    formatBloodType(bloodType) {
                        if (!bloodType) return '';

                        let formatted = bloodType.replace('_plus', '+').replace('_minus', '-');
                        return formatted.charAt(0).toUpperCase() + formatted.slice(1);
                    },


                    // Searching
                    searchStudent(event) {
                        const searchTerm = event.target.value.toLowerCase().trim();
                        if (searchTerm) {
                            this.users = this.originalUsers.filter(user => {
                                const fullName = `${user.fname} ${user.lname}`.toLowerCase();
                                return fullName.includes(searchTerm);
                            });
                        } else {
                            this.users = this.originalUsers;
                        }
                    },

                    // Table Actions
                    promoteUser() {
                        var form = event.target.closest('form');

                        Swal.fire({
                            title: "Are you sure?",
                            text: "Promote user's role to Instructor Role",
                            icon: "question",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Continue"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    },
                    disableUser() {
                        var form = event.target.closest('form');

                        Swal.fire({
                            title: "Are you sure?",
                            text: "The user will not be able to access their account until it is re-enabled.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Continue"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    },
                    loadMoreUsers() {
                        this.loadingFetch = true
                        this.abortFetch('fetch')
                        this.controller = new AbortController();
                        const signal = this.controller.signal
                        var role = "{{ $role }}";
                        fetch(`/users/load_more_users?role=${role}&chunkSize=${this.chunkSize}&offset=${this.offset}&searchTerm=${this.searchQuery}`, {
                                signal
                            })
                            .then(response => response.json())
                            .then(data => {

                                const newUsers = data.users.filter(newUser =>
                                    !this.users.some(existingUser => existingUser.id === newUser.id)
                                );

                                this.users = this.users.concat(newUsers);
                                this.originalData.users = this.users;

                                this.usersRoleCount = data.count
                                this.originalData.usersRoleCount = this.usersRoleCount

                                this.offset += this.chunkSize;
                                this.originalData.offset = this.offset;

                                this.loadingFetch = false
                            })
                            .catch(error => {
                                if (error.name === 'AbortError') {
                                    console.log('Please do not make multiple request');
                                    this.loadingFetch = false

                                } else {
                                    // handle other errors
                                }
                            });
                        console.log(this.users);
                    },

                    // Records Modal
                    getUserRecord(userId) {
                        this.recordsLoading = true
                        this.latestEnrollment = null
                        this.abortFetch('ajax')
                        var thisFunction = this;
                        this.userRecords = [];
                        this.xhr = $.ajax({
                            url: '{{ route('get_user_records') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                user_id: userId
                            },
                            success: function(response) {
                                thisFunction.userRecords = response.user_records;

                                if (thisFunction.userRecords.user_session && Array.isArray(thisFunction.userRecords
                                        .user_session)) {
                                    thisFunction.userRecords.user_session.forEach(session => {
                                        session.parsedUa = thisFunction.ua_parser(session.user_agent);
                                    });
                                }

                                console.log(thisFunction.userRecords.user_session);

                                if (thisFunction.userRecords.enrollee || thisFunction.userRecords.enrollee.length >
                                    0) {
                                    thisFunction.latestEnrollment = thisFunction.userRecords.enrollee.reduce((
                                        latest, enrollee) => {
                                        return new Date(enrollee.created_at) > new Date(latest.created_at) ?
                                            enrollee : latest;
                                    }, thisFunction.userRecords.enrollee[0])
                                }

                                console.log(thisFunction.userRecords);
                                thisFunction.recordsLoading = false;
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                        this.triggerModal('records');
                        // console.log(this.userRecords.enrollee.length);
                    },
                    ua_parser(userAgent) {
                        const parser = new UAParser(userAgent);
                        // const parser = new UAParser(
                        //     `Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11`
                        // );
                        const result = parser.getResult();
                        console.log(result);

                        return {
                            device: {
                                type: result.device.type || 'Unknown',
                                model: result.device.model || 'Unknown',
                                vendor: result.device.vendor || 'Unknown'
                                // type: 'mobile',
                                // model: result.device.model || 'iPhone',
                                // vendor: result.device.vendor || 'Unknown'
                            },
                            os: result.os.name || 'Unknown',
                            browser: result.browser.name || 'Unknown'
                        };
                    },
                    removeSession(sessionId) {
                        this.removeSessionLoading = true
                        this.abortFetch('ajax')
                        var thisFunction = this;

                        this.xhr = $.ajax({
                            url: '{{ route('remove_session') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                session_id: sessionId
                            },
                            success: function(response) {
                                var index = thisFunction.userRecords.user_session.findIndex(session => session
                                    .id === sessionId)
                                thisFunction.userRecords.user_session.splice(index, 1);
                                thisFunction.removeSessionLoading = false;

                                alert(`${response.status}: ${response.message}`)
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    },

                    // Records Modal - Address
                    async fetchUserLocations() {

                        const enrollee = this.enrolleeData;

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
                            this.enrolleeData.regionName = this.capitalize(data.name);
                            console.log(data.name);
                        } catch (error) {
                            console.error('Error fetching region name:', error);
                        }
                    },
                    async fetchProvinceName(provinceCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}`);
                            const data = await response.json();
                            this.enrolleeData.provinceName = this.capitalize(data.name);
                        } catch (error) {
                            console.error('Error fetching province name:', error);
                        }
                    },
                    async fetchCityName(cityCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}`);
                            const data = await response.json();
                            this.enrolleeData.cityName = this.capitalize(data.name);
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
                            this.enrolleeData.barangayName = barangay ? this.capitalize(barangay.name) : '';
                        } catch (error) {
                            console.error('Error fetching barangay name:', error);
                        }
                    },

                    searchUsers() {
                        this.abortFetch('fetch')
                        this.controller = new AbortController();
                        const signal = this.controller.signal
                        var role = "{{ $role }}";

                        if (this.searchQuery.trim() == '') {
                            this.users = this.originalData.users;
                            this.usersRoleCount = this.originalData.usersRoleCount
                            this.offset = this.originalData.offset
                        } else {
                            fetch(`/users/search_user?role=${role}&searchTerm=${this.searchQuery}`, {
                                    signal
                                })
                                .then(response => response.json())
                                .then(data => {
                                    this.users = data.users;
                                    this.usersRoleCount = data.count
                                    // Reset the offset since we’re showing search results
                                    this.offset = 4;
                                });
                        }
                    },
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

                    showData(enrolleeId) {
                        this.recordsLoading = true
                        this.enrolleeData = null
                        this.abortFetch('ajax')
                        var thisFunction = this;
                        this.xhr = $.ajax({
                            url: '{{ route('get_enrollee_data') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                enrollee_id: enrolleeId
                            },
                            success: function(response) {
                                thisFunction.enrolleeData = response.enrollee_data;

                                console.log(thisFunction.enrolleeData);
                                thisFunction.fetchUserLocations();
                                thisFunction.recordsLoading = false;
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                        this.showEnrolleeData = true
                    }



                }
            }
        </script>
    @endsection
</x-app-layout>
