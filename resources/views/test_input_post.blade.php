<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between text-white">
            <div class="text-2xl font-semibold text-white">
                {{ __('Enrolled Course') }} <span class="text-slate-600">|</span> <span
                    class="text-lg font-normal text-sky-500"></span>
            </div>
            <div>Batch:</div>
        </div>

    </x-slot>
    <div id="course_list" class="mx-8 my-4 text-white">
        <form action="{{ route('post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="message">Message:</label><br>
            <textarea class="text-black" id="message" name="message" rows="4" cols="50"></textarea><br><br>

            <div class="flex w-full items-center justify-center">
                <label for="file"
                    class="dark:hover:bg-bray-800 flex h-64 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pb-6 pt-5">
                        <svg class="mb-4 h-8 w-8 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input type="file" id="file" name="file" class="hidden" />
                </label>
            </div><br><br>
            <input type="submit" value="Submit">
        </form>
    </div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
</x-app-layout>
