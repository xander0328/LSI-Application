<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 pt-40" x-data="profile">
        <div class ="px-4 mx-auto max-w-7xl">
            @if (auth()->user()->role == 'student')
                <div
                    class="p-4 mb-4 text-gray-900 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-100 sm:p-8">
                    <div class="flex w-full">
                        <div class="flex items-center justify-center basis-1/4">
                            <span>
                                <img class="w-32 rounded-full md:w-40" src="{{ auth()->user()->get_profile_picture() }}"
                                    alt="" srcset="">
                            </span>
                        </div>
                        <div class="py-2 basis-3/4 ps-5">
                            <div class="text-2xl font-bold md:text-4xl">
                                {{ auth()->user()->fname . ' ' . (auth()->user()->mname ? substr(auth()->user()->mname, 0, 1) . '. ' : '') . auth()->user()->lname }}
                            </div>
                            <div class="text-sm">{{ auth()->user()->email }}</div>
                            <div class="text-sm">{{ auth()->user()->contact_number }}</div>
                            <div class="p-2 mt-2 text-sm border rounded-md border-slate-400 dark:border-slate-300">
                                <div>
                                    <span class="font-bold">Completed Courses: </span>
                                    <span>
                                        {{ auth()->user()->completed_course_count() }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-bold">
                                        Trainee Status:
                                    </span>
                                    <span>
                                        {{ auth()->user()->has_ongoing_course() ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (auth()->user()->role == 'student' && auth()->user()->has_ongoing_course())
                @auth
                    <div class="flex items-center p-4 mb-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-8">
                        <div class="me-4 ms-2">
                            <img width="96" height="96" src="https://img.icons8.com/fluency/96/security-pass.png"
                                alt="security-pass" />
                        </div>
                        <div class="block w-full md:flex">
                            <h2 class="flex items-center text-lg font-medium text-gray-900 dark:text-gray-100 md:basis-1/2">
                                <span>
                                    Identification Card
                                </span>
                            </h2>
                            <div class="flex mt-2 space-x-2 md:mt-0 md:basis-1/2">
                                <button type="button"
                                    class="flex items-center justify-center p-2 space-x-2 text-white rounded-md cursor-point basis-1/2 bg-sky-700 hover:bg-sky-800"
                                    @click="generateIdCard">
                                    <span>
                                        <svg class="w-5 h-5 text-white" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>eye-outline</title>
                                            <path
                                                d="M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M12,4.5C17,4.5 21.27,7.61 23,12C21.27,16.39 17,19.5 12,19.5C7,19.5 2.73,16.39 1,12C2.73,7.61 7,4.5 12,4.5M3.18,12C4.83,15.36 8.24,17.5 12,17.5C15.76,17.5 19.17,15.36 20.82,12C19.17,8.64 15.76,6.5 12,6.5C8.24,6.5 4.83,8.64 3.18,12Z" />
                                        </svg>
                                    </span>
                                    <span>
                                        View
                                    </span>
                                </button>
                                <button type="button"
                                    class="flex items-center justify-center p-2 space-x-2 text-white rounded-md cursor-point basis-1/2 bg-sky-700 hover:bg-sky-800"
                                    @click="generateIdCard">
                                    <span>
                                        <svg class="w-5 h-5 text-white" fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <title>tray-arrow-down</title>
                                            <path
                                                d="M2 12H4V17H20V12H22V17C22 18.11 21.11 19 20 19H4C2.9 19 2 18.11 2 17V12M12 15L17.55 9.54L16.13 8.13L13 11.25V2H11V11.25L7.88 8.13L6.46 9.55L12 15Z" />
                                        </svg>
                                    </span>
                                    <span>
                                        Download
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endauth
            @endif

            <div class="hidden p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="hidden p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <div class="flex justify-between p-4 my-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-8">
                <div class="flex items-center text-lg font-medium text-gray-900 dark:text-gray-100">
                    <span>
                        Notification
                    </span>
                </div>
                <div class="max-w-xl">

                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('profile', () => ({
                    enrollee_id: '{{ $enrollee_id }}',

                    generateIdCard() {
                        window.open("{{ route('id_card', $enrollee_id) }}", "_blank");
                    },
                    init() {
                        console.log(this.enrollee_id)
                    }
                }));
            });
        </script>
    @endsection
</x-app-layout>
