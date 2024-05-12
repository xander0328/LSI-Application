<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Message') }}
            </div>
            <div class="flex items-center">
                <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                    class="flex items-center justify-center rounded-md bg-sky-700 p-2 px-3">
                    <svg class="h-4 w-4 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                </button>
            </div>
        </div>

    </x-slot>

    <div id="course_list" class="mx-8 pt-36 text-white">
        @foreach ($users as $user)
            <div class="my-2 w-full rounded-md bg-gray-800 p-3">
                <a href="{{ route('message', $user->id) }} ">
                    <div class="flex items-center justify-start gap-4">
                        <div
                            class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-sky-700">
                            <span
                                class="font-medium text-gray-600 dark:text-gray-300">{{ substr($user->fname, 0, 1) }}{{ substr($user->lname, 0, 1) }}</span>
                        </div>
                        <div class="w-full font-medium dark:text-white">
                            <div>{{ $user->fname }} {{ $user->lname }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->role == 'superadmin' ? 'LSI Admin' : ucwords($user->role) }}</div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- New Message Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        New Message
                    </h3>
                    <button type="button"
                        class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="space-y-4 p-4 md:p-5">

                    <div class="mb-2">
                        <input type="text" id="searchInput"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Search" />
                    </div>
                    <div id="searchResults">
                        @foreach ($all_users as $user)
                            <div class="my-2 w-full rounded-md bg-gray-800 p-3">
                                <a href="{{ route('message', $user->id) }} ">
                                    <div class="flex items-center justify-start gap-4">
                                        <div
                                            class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-sky-700">
                                            <span
                                                class="font-medium text-gray-600 dark:text-gray-300">{{ substr($user->fname, 0, 1) }}{{ substr($user->lname, 0, 1) }}</span>
                                        </div>
                                        <div class="w-full font-medium dark:text-white">
                                            <div>{{ $user->fname }} {{ $user->lname }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->role == 'superadmin' ? 'LSI Admin' : ucwords($user->role) }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                </div>
                <!-- Modal footer -->
                {{-- <div class="flex items-center rounded-b border-t border-gray-200 p-4 dark:border-gray-600 md:p-5">
                    <button data-modal-hide="default-modal" type="button"
                        class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                        accept</button>
                    <button data-modal-hide="default-modal" type="button"
                        class="ms-3 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Decline</button>
                </div> --}}
            </div>
        </div>
    </div>
    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/fuse.js/dist/fuse.js"></script>
        <script>
            var data = [
                @foreach ($all_users as $user)
                    {
                        id: "{{ $user['id'] }}",
                        fname: "{{ $user['fname'] }}",
                        mname: "{{ $user['mname'] }}",
                        lname: "{{ $user['lname'] }}",
                        email: "{{ $user['email'] }}",
                        role: "{{ $user['role'] }}"
                    },
                @endforeach
            ];

            // Initialize Fuse.js with your data and desired options
            var fuse = new Fuse(data, {
                keys: ['fname', 'lname', 'email'], // Specify which fields to search in
                // threshold: 0.3 // Adjust the fuzzy search threshold as needed
            });

            $(document).ready(function() {
                // Event handler for the search input
                $('#searchInput').on('input', function() {
                    var query = $(this).val().trim();
                    console.log(query);
                    if (query !== "") {
                        query = fuse.search(query)
                        performSearch(query);
                    } else {
                        performSearch(data)
                    }
                });
            });


            // Function to perform search and display results
            function performSearch(query) {
                var results = query;
                var $searchResults = $('#searchResults');
                $searchResults.empty(); // Clear previous search results

                if (results.length > 0) {
                    // If there are results, display them
                    results.forEach(function(result) {
                        console.log(result);
                        if (data !== results) {
                            result = result.item
                        }
                        var list = ''
                        list += '<div class="my-2 w-full rounded-md bg-gray-800 p-3">'
                        var id = result.id;
                        list += ' <a href="{{ route('message', ':id') }}"' // insert id here
                        list = list.replace(':id', id);
                        list += ' <div class="flex items-center justify-start gap-4">'
                        list +=
                            '<div class="relative inline-flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-sky-700">'
                        var abbreviatedName = result.fname.substring(0, 1) + result.lname.substring(0, 1);
                        list +=
                            '<span class="font-medium text-gray-600 dark:text-gray-300">' + abbreviatedName + '</span>'
                        list += '</div>'
                        list += '<div class="w-full font-medium dark:text-white">'
                        list += '<div>' + result.fname + ' ' + result.lname + '</div>'
                        list += '<div class="text-sm text-gray-500 dark:text-gray-400">'
                        if (result.role === 'superadmin') {
                            list += 'LSI Admin'
                        } else {
                            var capitalizedRole = result.role.charAt(0).toUpperCase() + result.role
                                .slice(1);
                            list += capitalizedRole;
                        }
                        list += '</div></div></div></a></div>'
                        $searchResults.append(list);
                    })
                } else {
                    $searchResults.append('<li>No results found</li>');
                }
            }

            // function performSearch(query) {}
        </script>
    @endsection
</x-app-layout>
