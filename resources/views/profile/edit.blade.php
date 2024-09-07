<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 pt-36" x-data="profile">
        <div class ="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    <button type="button" class="cursor-point rounded-md bg-sky-700 p-2 text-white hover:bg-sky-800"
                        @click="generateIdCard">Download ID
                        Card</button>
                </div>
            </div>

            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
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
