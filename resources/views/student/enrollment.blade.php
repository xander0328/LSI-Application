<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }

        .no-scroll {
        overflow: hidden;
        }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="flex-row items-center text-2xl font-semibold text-black dark:text-white md:flex md:space-x-1">
                <div>{{ __('Enrollment') }}</div>
            </div>
        </div>
    </x-slot>
    <div x-data="enrollmentList()" id="course_list" class="mx-4 mt-2 pb-4 pt-36 text-black dark:text-white">
        <div class="mb-4 text-sm">
            <template x-for="enrollment in enrollment" :key="enrollment.id">
                <div class="my-2 rounded-md bg-white p-4 dark:bg-gray-800">
                    <div class="flex justify-between">
                        <div>
                            <span class="text-lg font-bold" x-text="enrollment.course.name"></span>
                            <div class="flex">
                                <span class="me-2 font-bold">Submitted at:</span>
                                <span class="" x-text="moment(enrollment.created_at).format('lll')"></span>
                            </div>
                            <template x-if="enrollment.batch_id !== null">
                                <div class="flex">
                                    <span class="me-2 font-bold">Batch:</span>
                                    <span class=""
                                        x-text="`${enrollment.course.code}-${enrollment.batch.name}`"></span>
                                </div>
                            </template>
                            <div class="mt-2 flex">
                                <a @click="showProfile(enrollment)"
                                    class="flex cursor-pointer items-center justify-center rounded bg-gray-300 px-3 py-1 text-black hover:bg-gray-200">
                                    <span>
                                        <svg class="h-4 w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title x-text="enrollment.id"></title>
                                            <path
                                                d="M14 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H18C19.11 22 20 21.11 20 20V8L14 2M18 20H6V4H13V9H18V20M13 13C13 14.1 12.1 15 11 15S9 14.1 9 13 9.9 11 11 11 13 11.9 13 13M15 18V19H7V18C7 16.67 9.67 16 11 16S15 16.67 15 18Z" />
                                        </svg>
                                    </span>
                                    <span>
                                        Submitted Profile
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="items-center">
                            <span
                                :class="{
                                    'bg-sky-500': enrollment.batch_id !== null,
                                    'bg-red-500': enrollment.deleted_at !== null,
                                    'bg-orange-500': enrollment.batch_id == null
                                }"
                                class="rounded bg-sky-500 px-3 py-1 font-medium uppercase text-white"
                                x-text="enrollment.batch_id !== null ? enrollment.deleted_at !== null ? 'Removed' : 'Accepted'  : 
                                enrollment.deleted_at !== null ? 'Cancelled' : 'Pending'"></span>
                        </div>
                    </div>
                    <template x-if="enrollment.batch_id === null && enrollment.deleted_at === null">
                        <div class="mt-2">
                            <form action="{{ route('cancel_enrollment') }}"
                                @submit.prevent="confirmDelete('Cancel Enrollment', 'Are you sure you want to cancel your enrollment? This action cannot be undone.', 'Confirm', false)"
                                method="post">
                                @csrf
                                <input type="hidden" name="enrollee_id" :value="enrollment.id">
                                <button
                                    class="w-full rounded bg-red-500 py-1.5 text-sm font-medium uppercase text-white hover:bg-red-600"
                                    type="submit">Cancel</button>
                            </form>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <div x-cloak x-show="profileModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50 pb-4">
            <div class="relative max-h-full w-full max-w-xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <div class="relative flex items-center whitespace-nowrap text-white">
                            <div class="pl-3">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"
                                    x-text="`${profileData?.user.fname ?? ''} ${profileData?.user.lname ?? ''}`">
                                </h3>
                                <div class="font-normal text-gray-400" x-text="profileData?.user.email">
                                </div>
                            </div>
                        </div>
                        <button type="button" @click="profileModal = false"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
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

                                <div class="relative mt-4 rounded-md bg-gray-300 text-white dark:bg-gray-800/75">
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
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm text-black dark:bg-gray-800 dark:text-white">
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
                                                        <span class="basis-1/2">First
                                                            Name:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.user.fname"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Middle
                                                            Name:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.user.mname ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Last Name:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.user.lname">
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Address:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="`${profileData?.barangayName}, ${profileData?.cityName}, ${profileData?.provinceName}, ${profileData?.regionName}, ${profileData?.zip}`"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Sex:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.sex ? profileData?.sex : '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Civil
                                                            Status:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.civil_status != null ? profileData?.civil_status : '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Employment
                                                            Type:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.employment_type ? profileData?.employment_type : '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Employment
                                                            Status:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.employment_status ? profileData?.employment_status : '---'"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm text-black dark:bg-gray-800 dark:text-white">
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
                                                        <span class="basis-1/2">Birth
                                                            Date:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="moment(profileData?.birth_data).format('ll');"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Birth
                                                            Place:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.birth_place"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Citizenship:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.citizenship"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Religion:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.religion"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Height:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.height + ' cm'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Weight:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.weight + ' kg'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Blood
                                                            Type:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.blood_type ? formatBloodType(profileData?.blood_type) : ''"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">SSS
                                                            Number:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.sss ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">GSIS
                                                            Number:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.gsis ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">TIN
                                                            Number:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.tin ?? '---'"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Distinguishing
                                                            Marks:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="profileData?.disting_marks ?? '---'"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm text-black dark:bg-gray-800 dark:text-white">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-blue-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <title>school-outline</title>
                                                        <path fill="currentColor"
                                                            d="M12 3L1 9L5 11.18V17.18L12 21L19 17.18V11.18L21 10.09V17H23V9L12 3M18.82 9L12 12.72L5.18 9L12 5.28L18.82 9M17 16L12 18.72L7 16V12.27L12 15L17 12.27V16Z" />
                                                    </svg></span>
                                                <div class="mb-2 dark:text-gray-300">EDUCATIONAL BACKGROUND</div>
                                                <template x-for="education in profileData?.enrollee_education"
                                                    :key="education.id">
                                                    <div class="mb-1.5 rounded-md bg-gray-300 p-4 dark:bg-gray-700/50">
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                            <span class="basis-1/2">School:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="education?.school_name"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                            <span class="basis-1/2">Educational
                                                                Level:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="education?.educational_level"></span>
                                                        </div>
                                                        <div
                                                            class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                            <span class="basis-1/2">School
                                                                Year:</span>
                                                            <span class="basis-1/2 font-medium"
                                                                x-text="education?.school_year"></span>
                                                        </div>
                                                        <template x-if="education?.educational_level == 'Tertiary'">
                                                            <div>
                                                                <div
                                                                    class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                    <span class="basis-1/2">Degree:</span>
                                                                    <span class="basis-1/2 font-medium"
                                                                        x-text="education?.degree ?? '---'"></span>
                                                                </div>
                                                                <div
                                                                    class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                    <span class="basis-1/2">Minor:</span>
                                                                    <span class="basis-1/2 font-medium"
                                                                        x-text="education?.minor ?? '---'"></span>
                                                                </div>
                                                                <div
                                                                    class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                    <span class="basis-1/2">Major:</span>
                                                                    <span class="basis-1/2 font-medium"
                                                                        x-text="education?.major ?? '---'"></span>
                                                                </div>
                                                                <div
                                                                    class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                    <span class="basis-1/2">Units
                                                                        Earned:</span>
                                                                    <span class="basis-1/2 font-medium"
                                                                        x-text="education?.units_earned ?? '---' "></span>
                                                                </div>
                                                                <div
                                                                    class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                                    <span class="basis-1/2">Honors
                                                                        Received:</span>
                                                                    <span class="basis-1/2 font-medium"
                                                                        x-text="education?.honors_received ?? '---'"></span>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm text-black dark:bg-gray-800 dark:text-white">
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
                                                        <span class="basis-1/2">Preffered
                                                            Schedule:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="moment(profileData?.preferred_start).format('ll')"></span>
                                                    </div>
                                                    <div
                                                        class="flex space-x-1 rounded-md px-1 hover:bg-gray-300 dark:hover:bg-gray-700/75">
                                                        <span class="basis-1/2">Preffered
                                                            Date:</span>
                                                        <span class="basis-1/2 font-medium"
                                                            x-text="moment(profileData?.preferred_finish).format('ll')"></span>
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

                                <div
                                    class="relative mt-4 rounded-md bg-gray-300 text-black dark:bg-gray-800/75 dark:text-white">
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
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-yellow-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <title>image-outline</title>
                                                        <path fill="currentColor"
                                                            d="M19,19H5V5H19M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M13.96,12.29L11.21,15.83L9.25,13.47L6.5,17H17.5L13.96,12.29Z" />
                                                    </svg>
                                                </span>
                                                <div class="mb-2 dark:text-gray-300">ID PICTURE</div>
                                                <div class="flex justify-center">
                                                    <template
                                                        x-if="profileData.enrollee_files_submitted && profileData.enrollee_files_submitted.length > 0">
                                                        <template x-for="file in profileData.enrollee_files_submitted"
                                                            :key="file.id">
                                                            <template x-if="file.credential_type == 'id_picture'">
                                                                <img class="rounded-md"
                                                                    :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                    profileData?.course_id + '/' +
                                                                        profileData?.id + '/id_picture/' + file
                                                                        .folder + '/' + file.filename"
                                                                    alt="" srcset="">
                                                            </template>
                                                        </template>
                                                    </template>

                                                    <template
                                                        x-if="!profileData.enrollee_files_submitted || profileData.enrollee_files_submitted.length === 0 || !profileData.enrollee_files_submitted.some(file => file.credential_type === 'id_picture')">
                                                        <div
                                                            class="flex w-full flex-shrink-0 items-center text-black dark:text-white/50">
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
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-green-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <title>card-account-details-outline</title>
                                                        <path fill="currentColor"
                                                            d="M22,3H2C0.91,3.04 0.04,3.91 0,5V19C0.04,20.09 0.91,20.96 2,21H22C23.09,20.96 23.96,20.09 24,19V5C23.96,3.91 23.09,3.04 22,3M22,19H2V5H22V19M14,17V15.75C14,14.09 10.66,13.25 9,13.25C7.34,13.25 4,14.09 4,15.75V17H14M9,7A2.5,2.5 0 0,0 6.5,9.5A2.5,2.5 0 0,0 9,12A2.5,2.5 0 0,0 11.5,9.5A2.5,2.5 0 0,0 9,7M14,7V8H20V7H14M14,9V10H20V9H14M14,11V12H18V11H14" />
                                                    </svg>
                                                </span>
                                                <div class="mb-2 dark:text-gray-300">VALID ID</div>

                                                <!-- Check if enrollee_files is defined and not empty -->
                                                <template
                                                    x-if="profileData.enrollee_files_submitted && profileData.enrollee_files_submitted.length > 0">
                                                    <template x-for="file in profileData.enrollee_files_submitted"
                                                        :key="file.id">
                                                        <div class="flex justify-center space-y-2">
                                                            <div class="w-full flex-shrink-0">
                                                                <!-- Display valid_id_front image if available -->
                                                                <template
                                                                    x-if="file.credential_type === 'valid_id_front'">
                                                                    <img class="rounded-md"
                                                                        :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                        profileData?.course_id + '/' +
                                                                            profileData?.id +
                                                                            '/valid_id_front/' +
                                                                            file.folder + '/' + file.filename"
                                                                        alt="" srcset="">
                                                                </template>

                                                                <!-- Display valid_id_back image if available -->
                                                                <template
                                                                    x-if="file.credential_type === 'valid_id_back'">
                                                                    <img class="rounded-md"
                                                                        :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                        profileData?.course_id + '/' +
                                                                            profileData?.id +
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
                                                        x-if="!profileData.enrollee_files_submitted || !profileData.enrollee_files_submitted.some(file => file.credential_type === 'valid_id_front')">
                                                        <div
                                                            class="mb-2 flex w-full flex-shrink-0 items-center text-black dark:text-white/50">
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
                                                        x-if="!profileData.enrollee_files_submitted || !profileData.enrollee_files_submitted.some(file => file.credential_type === 'valid_id_back')">
                                                        <div
                                                            class="flex w-full flex-shrink-0 items-center text-black dark:text-white/50">
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

                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-blue-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <title>town-hall</title>
                                                        <path fill="currentColor"
                                                            d="M21 10H17V8L12.5 6.2V4H15V2H11.5V6.2L7 8V10H3C2.45 10 2 10.45 2 11V22H10V17H14V22H22V11C22 10.45 21.55 10 21 10M8 20H4V17H8V20M8 15H4V12H8V15M12 8C12.55 8 13 8.45 13 9S12.55 10 12 10 11 9.55 11 9 11.45 8 12 8M14 15H10V12H14V15M20 20H16V17H20V20M20 15H16V12H20V15Z" />
                                                    </svg>
                                                </span>
                                                <div class="mb-2">DIPLOMA/TRANSCRIPT OF RECORDS</div>
                                                <div class="flex">
                                                    <!-- Check if enrollee_files is defined and not empty -->
                                                    <template
                                                        x-if="profileData.enrollee_files_submitted && profileData.enrollee_files_submitted.length > 0">
                                                        <template x-for="file in profileData.enrollee_files_submitted"
                                                            :key="file.id">
                                                            <template x-if="file.credential_type === 'diploma_tor'">
                                                                <div>
                                                                    <template
                                                                        x-if="file.file_type === 'application/pdf'">
                                                                        <a class="rounded bg-sky-600 px-3 py-1.5"
                                                                            target="_blank"
                                                                            :href="`{{ route('show_enrollee_file', ['id' => ':id']) }}`
                                                                            .replace(':id', file.id)">View
                                                                            PDF</a>
                                                                    </template>
                                                                    <template
                                                                        x-if="file.file_type !== 'application/pdf'">
                                                                        <img class="rounded-md"
                                                                            :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                            profileData?.course_id + '/' +
                                                                                profileData?.id +
                                                                                '/diploma_tor/' + file.folder +
                                                                                '/' + file
                                                                                .filename"
                                                                            alt="" srcset="">
                                                                    </template>
                                                                </div>
                                                            </template>
                                                        </template>
                                                    </template>

                                                    <!-- Check if enrollee_files is undefined, empty, or missing 'diploma_tor' -->
                                                    <template
                                                        x-if="!profileData.enrollee_files_submitted || !profileData.enrollee_files_submitted.some(file => file.credential_type === 'diploma_tor')">
                                                        <div
                                                            class="flex w-full flex-shrink-0 items-center text-black dark:text-white/50">
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
                                            <div
                                                class="relative mb-2 rounded-md bg-gray-200 p-4 ps-10 text-sm dark:bg-gray-800">
                                                <span
                                                    class="absolute -left-4 top-4 rounded-md bg-sky-700 p-2 shadow-md">
                                                    <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <title>account-file-outline</title>
                                                        <path fill="currentColor"
                                                            d="M7.5 5C9.43 5 11 6.57 11 8.5C11 10.43 9.43 12 7.5 12C5.57 12 4 10.43 4 8.5C4 6.57 5.57 5 7.5 5M1 19V16.5C1 14.57 4.46 13 7.5 13C8.68 13 9.92 13.24 11 13.64V15.56C10.18 15.22 8.91 15 7.5 15C5 15 3 15.67 3 16.5V17H11V19H1M22 19H14C13.45 19 13 18.55 13 18V6C13 5.45 13.45 5 14 5H19L23 9V18C23 18.55 22.55 19 22 19M15 7V17H21V10H18V7H15M7.5 7C6.67 7 6 7.67 6 8.5C6 9.33 6.67 10 7.5 10C8.33 10 9 9.33 9 8.5C9 7.67 8.33 7 7.5 7Z" />
                                                    </svg>
                                                </span>
                                                <div class="mb-2">BIRTH CERTIFICATE</div>
                                                <div class="flex">
                                                    <!-- Check if enrollee_files is defined and not empty -->
                                                    <template
                                                        x-if="profileData.enrollee_files_submitted && profileData.enrollee_files_submitted.length > 0">
                                                        <template x-for="file in profileData.enrollee_files_submitted"
                                                            :key="file.id">
                                                            <template
                                                                x-if="file.credential_type === 'birth_certificate'">
                                                                <div>
                                                                    <template
                                                                        x-if="file.file_type === 'application/pdf'">
                                                                        <a class="rounded bg-sky-600 px-3 py-1.5"
                                                                            target="_blank"
                                                                            :href="`{{ route('show_enrollee_file', ['id' => ':id']) }}`
                                                                            .replace(':id', file.id)">View
                                                                            PDF</a>
                                                                    </template>
                                                                    <template
                                                                        x-if="file.file_type !== 'application/pdf'">
                                                                        <img class="rounded-md"
                                                                            :src="'{{ asset('storage/enrollee_files/') }}/' +
                                                                            profileData?.course_id + '/' +
                                                                                profileData?.id +
                                                                                '/birth_certificate/' + file
                                                                                .folder + '/' +
                                                                                file.filename"
                                                                            alt="" srcset="">
                                                                    </template>
                                                                </div>
                                                            </template>
                                                        </template>
                                                    </template>

                                                    <!-- Check if enrollee_files is undefined, empty, or missing 'birth_certificate' -->
                                                    <template
                                                        x-if="!profileData.enrollee_files_submitted || !profileData.enrollee_files_submitted.some(file => file.credential_type === 'birth_certificate')">
                                                        <div
                                                            class="flex w-full flex-shrink-0 items-center text-black dark:text-white/50">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function enrollmentList() {
                return {
                    @section('enrollee')
                        @json($enrollee ?? '')
                    @endsection

                    enrollment: @json($enrollments ?? ''),

                    profileModal: false,
                    profileData: [],
                    init() {
                        console.log(this.enrollment);

                        @if (session('status'))
                            this.notification('{{ session('status') }}', '{{ session('message') }}', 'Enrollment Cancelation')
                        @endif

                    },
                    showProfile(id) {
                        this.profileData = this.enrollment;
                        this.fetchUserLocations();
                        this.profileModal = true;
                    },
                    async fetchUserLocations() {

                        const enrollee = this.profileData;

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
                            this.profileData.regionName = data.name;
                            console.log(data.name);
                        } catch (error) {
                            console.error('Error fetching region name:', error);
                        }
                    },
                    async fetchProvinceName(provinceCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}`);
                            const data = await response.json();
                            this.profileData.provinceName = data.name;
                        } catch (error) {
                            console.error('Error fetching province name:', error);
                        }
                    },
                    async fetchCityName(cityCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}`);
                            const data = await response.json();
                            this.profileData.cityName = data.name;
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
                            this.profileData.barangayName = barangay ? barangay.name : '';
                        } catch (error) {
                            console.error('Error fetching barangay name:', error);
                        }
                    },
                    formatBloodType(bloodType) {
                        if (!bloodType) return '';

                        let formatted = bloodType.replace('_plus', '+').replace('_minus', '-');
                        return formatted.charAt(0).toUpperCase() + formatted.slice(1);
                    },
                    confirmDelete(title, text, confirmButtonText, ajax) {
                        var form = event.target.closest('form');
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
                                if (ajax) {
                                    $.ajax(ajax)
                                } else {
                                    form.submit();
                                }
                            }
                        });
                    },
                    notification(status, message, title) {
                        status === 'success' ? toastr.success(message, title ?? title) : toastr.error(message,
                            title ?? title);
                    },
                }
            }
        </script>
    @endsection
</x-app-layout>
