<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 pt-40" x-data="profile">
        <div class ="mx-auto max-w-7xl px-4">
            @if (auth()->user()->role == 'student')
                @auth
                    <div
                        class="bg-white mb-4 grid grid-cols-1 md:grid-cols-4 md:gap-4 gap-1 p-4 shadow dark:bg-gray-800 rounded-lg sm:p-8">
                        <h2 class="text-lg flex items-center font-medium text-gray-900 dark:text-gray-100">
                            <span>
                                Identification Card
                            </span>
                        </h2>
                        <div class="max-w-xl mt-2 grid col-span-3 grid-cols-2 gap-2">
                            <button type="button"
                                class="cursor-point flex space-x-2 items-center justify-center rounded-md bg-sky-700 p-2 text-white hover:bg-sky-800"
                                @click="generateIdCard">
                                <span>
                                    <svg class="h-5 w-5 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
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
                                class="cursor-point flex space-x-2 items-center justify-center rounded-md bg-sky-700 p-2 text-white hover:bg-sky-800"
                                @click="generateIdCard">
                                <span>
                                    <svg class="h-5 w-5 text-white" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24">
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
                @endauth
            @endif

            <div class="hidden bg-white p-4 shadow dark:bg-gray-800 rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white p-4 shadow dark:bg-gray-800 rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="hidden bg-white p-4 shadow dark:bg-gray-800 rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <div class="bg-white my-4 flex justify-between p-4 shadow dark:bg-gray-800 rounded-lg sm:p-8">
                <div class="text-lg flex items-center font-medium text-gray-900 dark:text-gray-100">
                    <span>
                        In-app Notification
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

                    // generateIdCard() {
                    //     $.ajax({
                    //         url: "{{ route('generateIDCard', $enrollee_id) }}",
                    //         method: 'GET',
                    //         headers: {
                    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    //         },
                    //         success: function(response) {
                    //             // location.reload();
                    //             // console.log(this.selectedUserIds);
                    //             // alert('Selected users have been saved to the batch.');
                    //         },
                    //         error: function(xhr, status, error) {
                    //             console.error('Error saving to batch:', error);
                    //             alert('An error occurred while saving to the batch.');
                    //         }
                    //     });
                    // }
                    generateIdCard() {
                        window.open("{{ route('id_card', $enrollee_id) }}", "_blank");
                    }
                }));
            });
        </script>
    @endsection
</x-app-layout>
