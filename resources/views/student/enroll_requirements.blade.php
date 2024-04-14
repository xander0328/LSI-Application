<x-guest-layout>
    <form id="upload_files" class="p-4 md:p-5" enctype="multipart/form-data" method="POST"
        action="{{ route('enroll_requirements_save') }}">
        @csrf
        <input type="hidden" name="enrollee_id" value="{{ $enrollee }}">
        <div class="col-span-2 mb-4">
            <div class="col-span-2 flex justify-between font-bold text-white">
                <div class="content-center">Enrollment Requirements</div>
                <button class="underlined col-span-1 rounded rounded-md bg-white p-1 text-sm text-black" type="button"
                    onclick="seeFormats()">See Formats</button>
            </div>
            <div class="text-xs text-white">Click "See Formats" before uploading files</div>
        </div>

        <div class="visible mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="valid_id">Valid
                    ID</label>
                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" name="valid_id" id="valid_id" type="file" accept="image/*">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="diploma_tor">Diploma or
                    Transcript of Records</label>
                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" name="diploma_tor" id="diploma_tor" type="file"
                    accept="image/*">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="birth_certificate">Birth
                    Certificate</label>
                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" name="birth_certificate" id="birth_certificate" type="file"
                    accept="image/*">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-900 dark:text-white" for="id_picture">ID
                    Picture</label>
                <input
                    class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:placeholder-gray-400"
                    aria-describedby="file_input_help" name="id_picture" id="id_picture" type="file"
                    accept="image/*">
            </div>

            <div class="col-span-2 justify-self-end">
                <x-primary-button id="step1_next" class="col-span-1 col-end-3 w-full text-white"
                    type="submit">Submit</x-primary-button>
            </div>

        </div>
    </form>
</x-guest-layout>
