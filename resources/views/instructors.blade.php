<x-app-layout>
    @section('style')
        [x-cloak] { display: none !important; }
    @endsection
    <x-slot name="header">
        <div class="flex items-center justify-between pr-4 text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Instructors') }}
            </div>
        </div>

    </x-slot>

    <div x-data="manageInstructors" class="p-2 px-4 pb-16 pt-40 md:px-8">
        <div class="mb-4 flex items-center justify-end space-x-2">
            <div class="w-full md:w-1/2">
                <input autocomplete="off" type="text" id="table-search-users" x-model="searchQuery"
                    @keyup.enter="searchInstructor" @input="searchInstructor()"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 pl-10 pt-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                    placeholder="Name or Email">
            </div>
            <div>
                <a :href="'{{ route('users') }}' + '?role=guest'"
                    class="flex items-center space-x-1 rounded-lg bg-sky-600 px-3 py-1.5 text-white hover:bg-sky-700">
                    <span>
                        <svg class="h-4 w-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>account-plus-outline</title>
                            <path
                                d="M15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4M15,5.9C16.16,5.9 17.1,6.84 17.1,8C17.1,9.16 16.16,10.1 15,10.1A2.1,2.1 0 0,1 12.9,8A2.1,2.1 0 0,1 15,5.9M4,7V10H1V12H4V15H6V12H9V10H6V7H4M15,13C12.33,13 7,14.33 7,17V20H23V17C23,14.33 17.67,13 15,13M15,14.9C17.97,14.9 21.1,16.36 21.1,17V18.1H8.9V17C8.9,16.36 12,14.9 15,14.9Z" />
                        </svg>
                    </span>
                    <span>
                        Add
                    </span>
                </a>
            </div>
        </div>
        <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-3">
            <template x-for="instructor in filteredInstructors" :key="instructor.id">
                <a @click="getInstructorData(instructor.instructor_info && instructor.instructor_info.id ? instructor.instructor_info.id : null)"
                    class="w-full cursor-pointer rounded-lg border border-gray-700 bg-gray-800 p-2 shadow hover:bg-gray-800/50">
                    <div class="m-1.5 flex items-center space-x-2">
                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-full md:h-20 md:w-20">
                            <template x-if="!instructor.instructor_info">
                                <img class="h-full w-full object-cover object-center"
                                    src="{{ asset('images/temporary/profile.png') }}" alt="">
                            </template>
                            <template x-if="instructor.instructor_info">
                                <img class="h-full w-full object-cover object-center"
                                    :src="'{{ asset('storage/instructor_files/') }}/' +
                                    instructor.instructor_info?.user_id + '/' + instructor.instructor_info
                                        ?.folder + '/' + instructor.instructor_info?.id_picture"
                                    alt="profile">
                            </template>
                        </div>
                        <div>
                            <div class="text-lg font-bold tracking-tight text-white md:text-xl"
                                x-text="`${instructor.lname}, ${instructor.fname}`"></div>
                            <div class="md:text-md text-sm text-white/50" x-text="instructor.email">
                            </div>
                        </div>
                    </div>
                </a>
            </template>
        </div>
        {{-- Instructor Info --}}
        <div x-cloak x-show="instructorInfoModal" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-800 bg-opacity-50 pb-4">
            <div class="relative max-h-full w-full max-w-xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                        <div class="flex items-center whitespace-nowrap text-white">
                            <template x-if="!selectedInstructor?.instructorInfo">
                                <img src="{{ asset('images/temporary/profile.png') }}" class="h-12 w-12 rounded-full"
                                    alt="profile">
                            </template>
                            <template x-if="selectedInstructor?.instructorInfo">
                                <img :src="'{{ asset('storage/instructor_files/') }}/' +
                                selectedInstructor?.instructorInfo?.user_id + '/' + selectedInstructor?.instructorInfo
                                    ?.folder + '/' + selectedInstructor?.instructorInfo?.id_picture"
                                    class="h-12 w-12 rounded-full" alt="profile">
                            </template>
                            <div class="pl-3">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"
                                    x-text="`${selectedInstructor?.fname ?? ''} ${selectedInstructor?.lname ?? ''}`">
                                </h3>
                                <div class="font-normal text-gray-400" x-text="selectedInstructor?.email">
                                </div>
                            </div>
                        </div>
                        <button type="button"
                            @click="instructorInfoModal = false;  $('body').removeClass('overflow-hidden')"
                            class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
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

                                <div class="relative mb-8 mt-4 rounded-md bg-gray-800/75 text-white">
                                    <div
                                        class="absolute -top-4 left-2 mb-2 flex w-2/4 items-center justify-center rounded-md bg-sky-700 px-1.5 py-2 text-white shadow-md">
                                        <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>clipboard-outline</title>
                                            <path fill="currentColor"
                                                d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7Z" />
                                        </svg>
                                        <div>
                                            Instructor Profile
                                        </div>
                                    </div>

                                    <div class="px-2 pb-4 pt-10">
                                        <div class="ps-4 text-sm">
                                            <div>
                                                <div class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span class="basis-1/2 text-gray-300">First
                                                        Name:</span>
                                                    <span class="basis-1/2 font-medium"
                                                        x-text="selectedInstructor?.fname"></span>
                                                </div>
                                                <div class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span class="basis-1/2 text-gray-300">Middle
                                                        Name:</span>
                                                    <span class="basis-1/2 font-medium"
                                                        x-text="selectedInstructor?.mname ?? '---'"></span>
                                                </div>
                                                <div class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span class="basis-1/2 text-gray-300">Last Name:</span>
                                                    <span class="basis-1/2 font-medium"
                                                        x-text="selectedInstructor?.lname">
                                                    </span>
                                                </div>
                                                <div class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span class="basis-1/2 text-gray-300">Sex:</span>
                                                    <span class="basis-1/2 font-medium capitalize"
                                                        x-text="selectedInstructor?.instructorInfo?.sex"></span>
                                                </div>
                                                <div class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span class="basis-1/2 text-gray-300">Contact Number:</span>
                                                    <span class="basis-1/2 font-medium capitalize"
                                                        x-text="selectedInstructor?.contact_number ?? '---'"></span>
                                                </div>
                                                <div class="flex space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span class="basis-1/2 text-gray-300">Address:</span>
                                                    <span class="basis-1/2 font-medium normal-case"
                                                        x-text="`${selectedInstructor?.instructorInfo?.barangayName}, ${selectedInstructor?.instructorInfo?.cityName}, ${selectedInstructor?.instructorInfo?.provinceName}, ${selectedInstructor?.instructorInfo?.regionName}`"></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative mb-8 mt-4 rounded-md bg-gray-800/75 text-white">
                                    <div
                                        class="absolute -top-4 left-2 mb-2 flex w-2/4 items-center justify-center rounded-md bg-sky-700 px-1.5 py-2 text-white shadow-md">
                                        <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>clipboard-outline</title>
                                            <path fill="currentColor"
                                                d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7Z" />
                                        </svg>
                                        <div>
                                            Accomplishments
                                        </div>
                                    </div>

                                    <div class="px-2 pb-4 pt-10">
                                        <div class="ps-4 text-sm">
                                            <div>
                                                <div
                                                    class="flex items-center space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span>
                                                        <svg class="h5 w-5" fill="currentColor"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>certificate-outline</title>
                                                            <path
                                                                d="M13 21L15 20L17 21V14H13M17 9V7L15 8L13 7V9L11 10L13 11V13L15 12L17 13V11L19 10M20 3H4A2 2 0 0 0 2 5V15A2 2 0 0 0 4 17H11V15H4V5H20V15H19V17H20A2 2 0 0 0 22 15V5A2 2 0 0 0 20 3M11 8H5V6H11M9 11H5V9H9M11 14H5V12H11Z" />
                                                        </svg>
                                                    </span>
                                                    <span class="basis-1/2">Award 1</span>
                                                </div>
                                                <div
                                                    class="flex items-center space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span>
                                                        <svg class="h-5 w-5" fill="currentColor"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>certificate-outline</title>
                                                            <path
                                                                d="M13 21L15 20L17 21V14H13M17 9V7L15 8L13 7V9L11 10L13 11V13L15 12L17 13V11L19 10M20 3H4A2 2 0 0 0 2 5V15A2 2 0 0 0 4 17H11V15H4V5H20V15H19V17H20A2 2 0 0 0 22 15V5A2 2 0 0 0 20 3M11 8H5V6H11M9 11H5V9H9M11 14H5V12H11Z" />
                                                        </svg>
                                                    </span>
                                                    <span class="basis-1/2">Award 2</span>
                                                </div>
                                                <div
                                                    class="flex items-center space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span>
                                                        <svg class="h-5 w-5" fill="currentColor"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>certificate-outline</title>
                                                            <path
                                                                d="M13 21L15 20L17 21V14H13M17 9V7L15 8L13 7V9L11 10L13 11V13L15 12L17 13V11L19 10M20 3H4A2 2 0 0 0 2 5V15A2 2 0 0 0 4 17H11V15H4V5H20V15H19V17H20A2 2 0 0 0 22 15V5A2 2 0 0 0 20 3M11 8H5V6H11M9 11H5V9H9M11 14H5V12H11Z" />
                                                        </svg>
                                                    </span>
                                                    <span class="basis-1/2">Certificate 1 Holder</span>
                                                </div>
                                                <div
                                                    class="flex items-center space-x-1 rounded-md px-1 hover:bg-gray-700/75">
                                                    <span>
                                                        <svg class="h-5 w-5" fill="currentColor"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                            <title>certificate-outline</title>
                                                            <path
                                                                d="M13 21L15 20L17 21V14H13M17 9V7L15 8L13 7V9L11 10L13 11V13L15 12L17 13V11L19 10M20 3H4A2 2 0 0 0 2 5V15A2 2 0 0 0 4 17H11V15H4V5H20V15H19V17H20A2 2 0 0 0 22 15V5A2 2 0 0 0 20 3M11 8H5V6H11M9 11H5V9H9M11 14H5V12H11Z" />
                                                        </svg>
                                                    </span>
                                                    <span class="basis-1/2">Certificate 2 Holder</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative mb-8 mt-4 rounded-md bg-gray-800/75 text-white">
                                    <div
                                        class="absolute -top-4 left-2 mb-2 flex w-1/2 items-center justify-center rounded-md bg-sky-700 py-2 text-white shadow-md">
                                        <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>clipboard-outline</title>
                                            <path fill="currentColor"
                                                d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7Z" />
                                        </svg>
                                        <div>
                                            Active Batches
                                        </div>
                                    </div>

                                    <div class="px-2 pb-2 pt-10">
                                        <div class="px-2 text-sm">
                                            <template
                                                x-for="batch in selectedInstructor.instructorInfo.batches.filter(batch => batch.completed_at == null)"
                                                :key="batch.id">
                                                <div
                                                    class="mb-1.5 cursor-pointer rounded border border-white/25 bg-gray-700 px-2 py-0.5 text-white hover:bg-gray-700/50">
                                                    <span
                                                        class="my-1.5 me-2 rounded bg-sky-900 px-2 py-0.5 text-xs text-sky-300"
                                                        x-text="batch.course.code"></span><span
                                                        x-text="batch.name"></span>
                                                </div>
                                            </template>
                                            <template
                                                x-if="selectedInstructor.instructorInfo.batches.filter(batch => batch.completed_at == null).length == 0">
                                                <div class="my-1.5 px-2 py-0.5 text-center">
                                                    No Records
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative mt-4 rounded-md bg-gray-800/75 text-white">
                                    <div
                                        class="absolute -top-4 left-2 mb-2 flex w-1/2 items-center justify-center rounded-md bg-sky-700 py-2 text-white shadow-md">
                                        <svg class="h-7 w-7 pr-1.5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <title>clipboard-outline</title>
                                            <path fill="currentColor"
                                                d="M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7Z" />
                                        </svg>
                                        <div>
                                            Completed Batches
                                        </div>
                                    </div>

                                    <div class="px-2 pb-2 pt-10">
                                        <div class="px-2 text-sm">
                                            <template
                                                x-for="batch in selectedInstructor.instructorInfo.batches.filter(batch => batch.completed_at != null)"
                                                :key="batch.id">
                                                <div
                                                    class="mb-1.5 cursor-pointer rounded border border-white/25 bg-gray-700 px-2 py-0.5 text-white hover:bg-gray-700/50">
                                                    <span
                                                        class="my-1.5 me-2 rounded bg-sky-900 px-2 py-0.5 text-xs text-sky-300"
                                                        x-text="batch.course.code"></span><span
                                                        x-text="batch.name"></span>
                                                </div>
                                            </template>
                                            <template
                                                x-if="selectedInstructor.instructorInfo.batches.filter(batch => batch.completed_at != null).length == 0">
                                                <div class="my-1.5 px-2 py-0.5 text-center">
                                                    No Records
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
            </div>
        </div>
    </div>
    @section('script')
        <script>
            function manageInstructors() {
                return {
                    instructors: @json($instructors),
                    selectedInstructor: null,
                    instructorInfoModal: false,
                    recordsLoading: false,
                    filteredInstructors: [],

                    init() {
                        console.log(this.instructors);

                        this.sortInstructors();

                    },
                    getInstructorData(id) {

                        if (id) {
                            $('body').addClass('overflow-hidden')
                            this.recordsLoading = true
                            this.selectedInstructor = this.instructors.find(instructor => instructor.instructor_info?.id == id);
                            console.log(this.selectedInstructor);
                            // this.abortFetch('ajax')
                            var thisFunction = this;
                            this.xhr = $.ajax({
                                url: '{{ route('get_instructor_info') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    instructor_id: id
                                },
                                success: function(response) {

                                    if (response.status == 'error')
                                        thisFunction.notification('error', response.message);
                                    else {
                                        thisFunction.selectedInstructor.instructorInfo = response.instructorInfo;
                                        thisFunction.fetchUserLocations();
                                        thisFunction.recordsLoading = false
                                    }

                                    console.log(thisFunction.selectedInstructor);

                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                            this.instructorInfoModal = true
                        } else {
                            this.notification('info', 'Instructor has no information yet', '')
                        }
                    },
                    sortInstructors() {
                        this.filteredInstructors = this.instructors.sort((a, b) => {
                            if (a.lname < b.lname) {
                                return -1;
                            }
                            if (a.lname > b.lname) {
                                return 1;
                            }
                            return 0;
                        });
                    },

                    searchQuery: null,
                    searchInstructor() {
                        if (this.searchQuery.toLowerCase().trim()) {
                            this.filteredInstructors = this.filteredInstructors.filter(instructor =>
                                instructor.fname.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                instructor.lname.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                instructor.email.toLowerCase().includes(this.searchQuery.toLowerCase())
                            );
                        } else {
                            this.sortInstructors();
                        }
                    },

                    // Utility
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
                    async fetchUserLocations() {

                        const instructor = this.selectedInstructor.instructorInfo;

                        await Promise.all([
                            this.fetchRegionName(instructor.region),
                            this.fetchProvinceName(instructor.province),
                            this.fetchCityName(instructor.city),
                            this.fetchBarangayName(instructor.city, instructor.barangay)
                        ]);
                    },
                    async fetchRegionName(regionCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/regions/${regionCode}`);
                            const data = await response.json();
                            this.selectedInstructor.instructorInfo.regionName = data.name;
                            console.log(data.name);
                        } catch (error) {
                            this.notification('error', 'Error fetching region name', '')
                        }
                    },
                    async fetchProvinceName(provinceCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}`);
                            const data = await response.json();
                            this.selectedInstructor.instructorInfo.provinceName = data.name;
                        } catch (error) {
                            this.notification('error', 'Error fetching province name', '')
                        }
                    },
                    async fetchCityName(cityCode) {
                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}`);
                            const data = await response.json();
                            this.selectedInstructor.instructorInfo.cityName = data.name;
                        } catch (error) {
                            this.notification('error', 'Error fetching city name', '')
                        }
                    },
                    async fetchBarangayName(cityCode, barangayCode) {
                        try {
                            const response = await fetch(
                                `https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays`);
                            const data = await response.json();
                            const barangay = data.find(barangay => barangay.code === barangayCode);
                            this.selectedInstructor.instructorInfo.barangayName = barangay ? barangay
                                .name : '';
                        } catch (error) {
                            this.notification('error', 'Error fetching barangay name', '')
                        }
                    },
                }
            }
        </script>
    @endsection
</x-app-layout>
