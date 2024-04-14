<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Modal body -->
    <form id="enroll_to_course" class="p-4 md:p-5" method="POSt" action="{{ route('enroll_save') }}">
        @csrf
        <?php
        $course_id = request()->segment(count(request()->segments()));
        
        ?>
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="course_id" value="{{ $course_id }}">
        <div id="step1" class="visible mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-white">Mailing Address</div>
            <div class="col-span-2">
                <label for="region"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Region</label>

                <select name="region" id="region"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                <input type="hidden" id="region_name" name="region_name" value="">

            </div>

            <div class="col-span-2">
                <label for="province"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Province</label>

                <select name="province" id="province"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                <input type="hidden" id="province_name" name="province_name" value="">
            </div>

            <div class="col-span-2">
                <label for="district"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">District</label>

                <select name="district" id="district"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                <input type="hidden" id="district_name" name="district_name" value="">

            </div>

            <div class="col-span-2">
                <label for="city"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">City/Municipality</label>

                <select name="city" id="city"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                <input type="hidden" id="city_name" name="city_name" value="">

            </div>

            <div class="col-span-2">
                <label for="barangay"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Barangay</label>

                <select name="barangay" id="barangay"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                <input type="hidden" id="barangay_name" name="barangay_name" value="">

            </div>

            <div class="col-span-2">
                <label for="street"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Street</label>
                <input type="text" name="street" id="street"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>

            <div class="col-span-2">
                <label for="zip" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Zip
                    Code</label>
                <input type="text" name="zip" id="zip"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>

            <div class="col-span-2 justify-self-end">
                <x-primary-button id="step1_next" class="col-span-1 col-end-3 w-full text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step2" class="mb-4 grid hidden grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-white">Sex</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="male" type="radio" value="male" name="sex"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="male"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                </div>
                <div class="flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="female" type="radio" value="female" name="sex"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="female"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                </div>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step2_prev" onclick="prevStep(2)" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step2_next" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>

            {{-- <button type="submit"
                class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="mr-2 h-5 w-5 text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m5 12 4.7 4.5 9.3-9" />
                </svg>
                <span class="mr-2">Save</span>
            </button> --}}
        </div>
        <div id="step3" class="mb-4 grid hidden grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-white">Civil Status</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="single" type="radio" value="single" name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="single"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Single</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="married" type="radio" value="married" name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="married"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Married</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="window" type="radio" value="window" name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="window"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Window/er</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="separated" type="radio" value="separated" name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="separated"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Separated</label>
                </div>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step3_prev" onclick="prevStep(3)" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step3_next" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step4" class="mb-4 grid hidden grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-white">Employment Type</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="employed" type="radio" value="employed" name="employment_type"
                        onchange="updateEmploymentOptions()"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="employed"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Employed</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="self-employed" type="radio" value="self-employed" name="employment_type"
                        onchange="updateEmploymentOptions()"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="self-employed"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Self-employed</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="unemployed" type="radio" value="unemployed" name="employment_type"
                        onchange="updateEmploymentOptions()"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="unemployed"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Unemployed</label>
                </div>
                <div class="col-span-2 mt-2">
                    <label for="employment_status"
                        class="mb-2 block font-bold text-gray-900 dark:text-white">Employment
                        Status</label>
                    <select name="employment_status" id="employment_status"
                        class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                        <option selected="">Select</option>
                        <option value="casual">Casual</option>
                        <option value="contractual">Contractual</option>
                        <option value="job_order">Job Order</option>
                        <option value="temporary">Temporary</option>
                        <option value="probationary">Probationary</option>
                        <option value="regular">Regular</option>
                        <option value="permanent">Permanent</option>
                    </select>
                </div>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step4_prev" onclick="prevStep(4)" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step4_next" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>

        </div>
        <div id="step5" class="mb-4 grid hidden grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-white">Personal Information</div>
            <div class="col-span-2 mb-2">
                <label for="birth_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Birth
                    Date</label>
                <div class="relative max-w-sm">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input id="birth_date" datepicker datepicker-autohide oninput="dateChanged()" type="text"
                        name="birth_date"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Select date" required>
                </div>
            </div>
            <div class="col-span-2">
                <label for="birth_place" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Birth
                    Place</label>
                <input type="text" name="birth_place" id="birth_place"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="citizenship"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Citizenship</label>
                <input type="text" name="citizenship" id="citizenship"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="religion"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Religion</label>
                <input type="text" name="religion" id="religion"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-1">
                <label for="height"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Height</label>
                <input oninput="heightChanged()" placeholder="kilogram" type="text" name="height"
                    id="height"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-1">
                <label for="weight"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Weight</label>
                <input oninput="weightChanged()" placeholder="centimeter" type="text" name="weight"
                    id="weight"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="blood_type" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Blood
                    Type</label>
                <select name="blood_type" id="blood_type"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected>Select</option>
                    <option value="unidentified">Unidentified</option>
                    <option value="a_plus">A+</option>
                    <option value="a_minus">A-</option>
                    <option value="b_plus">B+</option>
                    <option value="b_minus">B-</option>
                    <option value="ab_plus">AB+</option>
                    <option value="ab_minus">AB-</option>
                    <option value="o_plus">O+</option>
                    <option value="o_minus">O-</option>
                </select>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step5_prev" onclick="prevStep(5)" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step5_next" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step6" class="mb-4 grid hidden grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-white">Personal Information</div>
            <div class="col-span-2">
                <label for="sss" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">SSS
                    No.</label>
                <input type="text" name="sss" id="sss" oninput="part6Changed()"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="gsis" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">GSIS
                    No.</label>
                <input type="text" oninput="part6Changed()" name="gsis" id="gsis"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="tin" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">TIN
                    No.</label>
                <input type="text" oninput="part6Changed()" name="tin" id="tin"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="disting_marks"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Distinguishing Marks</label>
                <input type="text" name="disting_marks" id="disting_marks"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step6_prev" onclick="prevStep(6)" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step6_next" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step7" class="mb-4 grid hidden grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 flex justify-between font-bold text-white">
                <div class="content-center">Educational Background</div>
                <button class="col-span-1 text-white" type="button" onclick="createForm()">Add</button>
            </div>

            <div class="col-span-2 grid grid-cols-2 gap-4" id="formContainer"></div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step7_prev" onclick="prevStep(7)" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step7_next" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step8" class="mb-4 grid hidden grid-cols-2 gap-4">
            <div class="col-span-2 mb-2">
                <div class="mb-2 font-bold text-white">Preferred Schedule (Training)</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="weekdays" type="radio" value="weekdays" name="preferred_schedule"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="weekdays"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Weekdays</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="weekends" type="radio" value="weekends" name="preferred_schedule"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="weekends"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Weekends</label>
                </div>
                <div class="flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="both" type="radio" value="both" name="preferred_schedule"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="both"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Both</label>
                </div>
            </div>
            <div class="col-span-2 font-bold text-white">Duration (100 Hours)</div>
            <div class="col-span-1 mb-2">

                <label for="preferred_start" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Date
                    Start</label>
                <div class="relative max-w-sm">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input datepicker datepicker-autohide oninput="dateChanged()" type="text"
                        name="preferred_start"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Select date">
                </div>
            </div>
            <div class="col-span-1 mb-2">
                <label for="preferred_finish"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Date
                    Finish</label>
                <div class="relative max-w-sm">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input datepicker datepicker-autohide oninput="dateChanged()" type="text"
                        name="preferred_finish"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Select date">
                </div>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step8_prev" onclick="prevStep(8)" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button onclick="finish()" class="col-span-1 text-white"
                    type="button">Finish</x-primary-button>
            </div>
        </div>
    </form>
    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                // Fetch Regions 
                $.ajax({
                    url: 'https://psgc.gitlab.io/api/regions/',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        // Iterate over the regions and append options to select element
                        $.each(data, function(index, region) {
                            $('#region').append($('<option>', {
                                value: region.code,
                                text: region.name.toUpperCase()
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching regions:', error);
                    }
                });

                $('#region').on('change', function() {
                    var regionCode = $(this).val();
                    var regionName = $(this).find('option:selected').text();
                    console.log(regionName);

                    // Change Provinces Options
                    $.ajax({
                        url: 'https://psgc.gitlab.io/api/regions/' + regionCode + '/provinces',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Clear existing options
                            $('#province').empty();
                            $('#province').append($('<option>', {
                                text: 'Select'
                            }))
                            $('#region_name').val(regionName);

                            // Append new options for provinces
                            $.each(data, function(index, province) {
                                $('#province').append($('<option>', {
                                    value: province.code,
                                    text: province.name.toUpperCase(),
                                }));
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching provinces:', error);
                        }
                    });

                    // District Option
                    $.ajax({
                        url: 'https://psgc.gitlab.io/api/districts',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Clear existing options
                            $('#district').empty();
                            $('#district').append($('<option>', {
                                text: 'Select'
                            }))

                            // Append new options for districts
                            $.each(data, function(index, district) {
                                $('#district').append($('<option>', {
                                    value: district.code,
                                    text: district.name.toUpperCase()
                                }));
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching districts:', error);
                        }
                    });
                });

                // Change City Options
                $('#province').on('change', function() {
                    var provCode = $(this).val();
                    var provName = $(this).find('option:selected').text();
                    console.log(provCode);

                    $.ajax({
                        url: 'https://psgc.gitlab.io/api/provinces/' + provCode +
                            '/cities-municipalities',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#city').empty();
                            $('#city').append($('<option>', {
                                text: 'Select'
                            }))
                            $('#province_name').val(provName)

                            $.each(data, function(index, city) {
                                $('#city').append($('<option>', {
                                    value: city.code,
                                    text: city.name.toUpperCase()
                                }));
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching barangays:', error);
                        }
                    });

                });

                // Change Barangay Options
                $('#city').on('change', function() {
                    var cityCode = $(this).val();
                    var cityName = $(this).find('option:selected').text();

                    console.log(cityCode);

                    $.ajax({
                        url: 'https://psgc.gitlab.io/api/cities-municipalities/' + cityCode +
                            '/barangays',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#barangay').empty();
                            $('#barangay').append($('<option>', {
                                text: 'Select'
                            }))
                            $('#city_name').val(cityName)

                            $.each(data, function(index, barangay) {
                                $('#barangay').append($('<option>', {
                                    value: barangay.code,
                                    text: barangay.name.toUpperCase()
                                }));
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching barangays:', error);
                        }
                    });

                });


            })
            $('#barangay').on('change', function() {
                var barangayName = $(this).find('option:selected').text();
                $('#barangay_name').val(barangayName)

            })

            $('#district').on('change', function() {
                var districtName = $(this).find('option:selected').text();
                $('#district_name').val(districtName)

            });

            // Validation Step 1
            $(document).ready(function() {
                $('#step1_next').click(function() {
                    // var region = $('#region').val();
                    // var province = $('#province').val();
                    // var district = $('#district').val();
                    // var city = $('#city').val();
                    // var barangay = $('#barangay').val();
                    // var street = $('#street').val();
                    // var zip = $('#zip').val();

                    // if (region == "" || province == "" || district == "" || city == "" || barangay == "" ||
                    //     street == "" || zip == "") {
                    //     alert("Please fill in all fields.");
                    //     return false;
                    // }

                    var inputs = document.querySelectorAll("#step1 input:not([type=hidden]), #step1 select");
                    var labels = document.querySelectorAll("#step1 label");
                    console.log(inputs);
                    for (var i = 0; i < inputs.length; i++) {
                        var input = inputs[i];
                        var label = labels[i];
                        var value = input.value.trim();

                        if (!value && input.required || value === "Select") {
                            input.classList.remove('dark:border-gray-500')
                            input.classList.add('dark:border-red-500')
                            label.classList.remove('dark:text-white')
                            label.classList.add('dark:text-red-500')
                            var label = input.previousElementSibling.textContent.trim();
                            if (i < 5)
                                alert("Please indicate your " + label.toUpperCase());
                            else
                                alert("Please fill in the " + label.toUpperCase() + " FIELD");
                            return;
                        } else {
                            input.classList.add('dark:border-gray-500')
                            input.classList.remove('dark:border-red-500')
                            label.classList.add('dark:text-white')
                            label.classList.remove('dark:text-red-500')
                        }
                    }

                    nextStep(1);
                });

                $("#street").on('input', function() {
                    $(this).val($(this).val().toUpperCase())
                })

                $("#zip").on('input', function() {
                    $(this).val($(this).val().replace(/[^0-9]/g, ''));

                    // Limit input to maximum of 4 characters
                    if ($(this).val().length > 4) {
                        $(this).val($(this).val().slice(0, 4));
                    }
                })
            });

            // Validation Step 2
            $(document).ready(function() {
                $('#step2_next').click(function() {
                    if (!$("input[name='sex']:checked").val()) {
                        alert("Please indicate your SEX");
                        return
                    } else {
                        nextStep(2);
                    }
                })
            });

            // Validation Step 3
            $(document).ready(function() {
                $('#step3_next').click(function() {
                    if (!$("input[name='civil_status']:checked").val()) {
                        alert('Please indicate your CIVIL STATUS.');
                    } else {
                        nextStep(3);
                    }
                })
            });

            // Validation Step 4
            $(document).ready(function() {
                $('#step4_next').click(function() {
                    var emp_type = $("input[name='employment_type']:checked").val()
                    var emp_status = $('#employment_status').val();
                    if (!emp_type) {
                        alert('Please indicate your EMPLOYMENT TYPE');
                    } else if (emp_type === "employed") {
                        if (emp_status === "Select") {
                            alert('Please indicate your EMPLOYMENT STATUS');
                            validate = false;
                        } else {
                            nextStep(4)
                        }
                    } else {
                        console.log(emp_status);
                        nextStep(4);
                    }

                })
            });

            // Validation Step 5
            $(document).ready(function() {
                $('#step5_next').click(function() {
                    var inputs = document.querySelectorAll("#step5 input, #step5 select");
                    var labels = document.querySelectorAll("#step5 label");
                    // console.log(labels[0].textContent);
                    for (var i = 0; i < inputs.length; i++) {
                        var input = inputs[i];
                        var label = labels[i];
                        var value = input.value.trim();

                        if (!value && input.required || value === "Select") {
                            input.classList.remove('dark:border-gray-500')
                            input.classList.add('dark:border-red-500')
                            label.classList.remove('dark:text-white')
                            label.classList.add('dark:text-red-500')
                            var label = label.textContent.trim();
                            if (i == 0 || i == 6)
                                alert("Please indicate your " + label.replace(/\s+/g, ' ').trim()
                                    .toUpperCase());
                            else
                                alert("Please fill in the " + label.replace(/\s+/g, ' ').trim().toUpperCase() +
                                    " FIELD");
                            return;
                        } else {
                            input.classList.add('dark:border-gray-500')
                            input.classList.remove('dark:border-red-500')
                            label.classList.add('dark:text-white')
                            label.classList.remove('dark:text-red-500')
                        }
                    }

                    nextStep(5);
                })
            });

            // Validation 6
            $(document).ready(function() {
                $('#step6_next').click(function() {
                    var inputs = document.querySelectorAll("#step6 input, #step6 select");
                    var labels = document.querySelectorAll("#step6 label")
                    // console.log(labels[0].textContent);
                    // for (var i = 0; i < inputs.length; i++) {
                    //     var input = inputs[i];
                    //     var label = labels[i];
                    //     var value = input.value.trim();

                    //     if (!value && input.required || value === "Select") {
                    //         input.classList.remove('dark:border-gray-500')
                    //         input.classList.add('dark:border-red-500')
                    //         label.classList.remove('dark:text-white')
                    //         label.classList.add('dark:text-red-500')
                    //         var label = label.textContent.trim();
                    //         alert("Please fill in the " + label.replace(/\s+/g, ' ').trim().toUpperCase() +
                    //             " FIELD");
                    //         return;
                    //     } else {
                    //         input.classList.add('dark:border-gray-500')
                    //         input.classList.remove('dark:border-red-500')
                    //         label.classList.add('dark:text-white')
                    //         label.classList.remove('dark:text-red-500')
                    //     }
                    // }

                    nextStep(6)
                })
            });

            // Validation 7
            $(document).ready(function() {
                $('#step7_next').click(function() {
                    var inputs = document.querySelectorAll("#step7 input, #step7 select");
                    var labels = document.querySelectorAll("#step7 label");
                    console.log(inputs);
                    for (var i = 0; i < inputs.length; i++) {
                        var input = inputs[i];
                        var label = labels[i];
                        var value = input.value.trim();

                        if (!value && input.required || value === "Select") {
                            input.classList.remove('dark:border-gray-500')
                            input.classList.add('dark:border-red-500')
                            label.classList.remove('dark:text-white')
                            label.classList.add('dark:text-red-500')
                            var label = label.textContent.trim();
                            if (i == 0 || i == 6)
                                alert("Please indicate your " + label.replace(/\s+/g, ' ').trim()
                                    .toUpperCase());
                            else
                                alert("Please fill in the " + label.replace(/\s+/g, ' ').trim().toUpperCase() +
                                    " FIELD");
                            return;
                        } else {
                            input.classList.add('dark:border-gray-500')
                            input.classList.remove('dark:border-red-500')
                            label.classList.add('dark:text-white')
                            label.classList.remove('dark:text-red-500')
                        }
                    }

                    nextStep(7)
                })
            });

            // Validation 8
            function finish() {
                if (!$("input[name='preferred_schedule']:checked").val()) {
                    alert("Please indicate your PREFERRED SCHEDULE");
                    return
                }
                if (!$("input[name='preferred_start']").val() || !$("input[name='preferred_finish']").val()) {
                    alert("Please indicate your PREFERRED START AND END DATES");
                    return
                }

                const input = prompt(
                    "Confirm that the data you've entered is true and correct by typing 'YES' if it is."
                )
                if (input !== null && input.toUpperCase() === "YES") {
                    $("#enroll_to_course").submit()
                } else {
                    // User did not confirm
                    alert("Confirmation failed. Please type 'YES' to confirm.");
                }
            }

            // Step Navigator: Next
            function nextStep(step) {
                document.getElementById('step' + step).classList.remove('visible');
                document.getElementById('step' + step).classList.add('hidden');
                document.getElementById('step' + (step + 1)).classList.add('visible');
                document.getElementById('step' + (step + 1)).classList.remove('hidden');
            }

            // Step Navigator: Previous
            function prevStep(step) {
                document.getElementById('step' + step).classList.remove('visible');
                document.getElementById('step' + step).classList.add('hidden');
                document.getElementById('step' + (step - 1)).classList.add('visible');
                document.getElementById('step' + (step - 1)).classList.remove('hidden');
            }

            function dateChanged() {
                let inputValue = event.target.value;
                let inputName = event.target.name

                // Validate the input format using a regular expression
                let isValidFormat = /^\d{2}\/\d{2}\/\d{4}$/.test(inputValue);

                // If the input format is invalid, remove the last character
                if (!isValidFormat) {
                    event.target.value = inputValue.slice(0, -1);
                }
            }

            function heightChanged() {
                let inputValue = event.target.value;

                // Remove any non-numeric characters
                let numericValue = inputValue.replace(/[^0-9]/g, '');

                if (numericValue === '' || numericValue === '0') {
                    event.target.value = '';
                } else {
                    // Append "kg" only if numeric value is not empty and not '0'
                    event.target.value = numericValue + ' kg';
                }

                event.target.setSelectionRange(numericValue.length, numericValue.length);
            }

            function weightChanged() {
                let inputValue = event.target.value;

                // Remove any non-numeric characters
                let numericValue = inputValue.replace(/[^0-9]/g, '');

                if (numericValue === '' || numericValue === '0') {
                    event.target.value = '';
                } else {
                    // Append "kg" only if numeric value is not empty and not '0'
                    event.target.value = numericValue + ' cm';
                }
                event.target.setSelectionRange(numericValue.length, numericValue.length);
            }

            var groupCount = 0; // To keep track of the number of groups added
            var tertiaryFieldsContainer;

            function createForm() {
                groupCount++; // Increment group count
                var formContainer = document.getElementById("formContainer");
                var div = document.createElement("div");
                div.classList.add('education-form_' + groupCount, 'bg-gray-700', 'p-3', 'rounded-lg', 'col-span-2', 'grid',
                    'grid-cols-2', 'gap-4')
                div.id = 'education-form_' + groupCount

                var schoolNameInput = createInput("text", "School Name", "schoolName_" + groupCount);
                div.appendChild(schoolNameInput);

                var educationLevelSelect = createSelect("Education Level", ["Primary", "Secondary", "Tertiary"],
                    "educationLevel_" + groupCount);
                div.appendChild(educationLevelSelect);

                // var schoolYearInput = createInput("text", "School Year", "schoolYear_" + groupCount);
                // div.appendChild(schoolYearInput);

                var schoolYearFromInput = createInput("text", "School Year", "schoolYear_" + groupCount);
                div.appendChild(schoolYearFromInput);


                tertiaryFieldsContainer = document.createElement("div");
                tertiaryFieldsContainer.id = 'tertiaryFieldsContainer_' + groupCount
                tertiaryFieldsContainer.classList.add('col-span-2', 'grid', 'grid-cols-2', 'gap-4')

                var degreeSelect = createSelect("Degree", ["Bachelor's", "Master's", "PhD"], "degree_" + groupCount);
                tertiaryFieldsContainer.appendChild(degreeSelect);

                var minorInput = createInput("text", "Minor", "minor_" + groupCount);
                tertiaryFieldsContainer.appendChild(minorInput);

                var majorInput = createInput("text", "Major", "major_" + groupCount);
                tertiaryFieldsContainer.appendChild(majorInput);

                var unitsEarnedInput = createInput("number", "Units Earned", "unitsEarned_" + groupCount);
                tertiaryFieldsContainer.appendChild(unitsEarnedInput);

                var honorsReceivedInput = createInput("text", "Honors Received", "honorsReceived_" + groupCount);
                tertiaryFieldsContainer.appendChild(honorsReceivedInput);

                var removeButton = createRemoveButton(tertiaryFieldsContainer.id);


                tertiaryFieldsContainer.classList.add("hidden");
                div.appendChild(tertiaryFieldsContainer);

                div.appendChild(removeButton);
                // Show additional fields only when "Tertiary" is selected
                // educationLevelSelect.addEventListener("change", function() {

                // });

                formContainer.appendChild(div);
            }

            function createRemoveButton(tertiaryFieldsContainer) {
                var suffix = tertiaryFieldsContainer.split("_")[1];
                var removeButton = document.createElement("button");

                removeButton.textContent = "Remove";
                removeButton.setAttribute("type", "button")
                removeButton.classList.add("col-span-2", "justify-self-end", "bg-red-500", "hover:bg-red-600", "text-white",
                    "font-bold",
                    "py-2",
                    "px-2", "rounded");
                removeButton.addEventListener("click", function() {
                    const confirmed = confirm('Are you sure you want to remove this?');

                    if (confirmed) {
                        var div = document.getElementById('education-form_' + suffix)
                        div.remove();
                    } else {
                        console.log(false);
                    }

                    console.log(div);
                });

                return removeButton
            }

            function educationChange(id) {
                var suffix = id.split("_")[1];
                var val = document.getElementById(id);
                var tertiary = document.getElementById("tertiaryFieldsContainer_" + suffix)
                var unitsEarned = document.getElementById("unitsEarned_" + suffix)

                if (val.value === "Tertiary") {
                    // console.log(tertiaryFieldsContainer);
                    tertiary.classList.remove("hidden");
                    unitsEarned.required = true;
                } else {
                    // console.log("not tertiary");
                    tertiary.classList.add("hidden");
                    unitsEarned.required = false;

                }
            }

            function createInput(type, label, id) {
                var inputDiv = document.createElement("div");
                if (label === "Minor" || label === "Major") {
                    inputDiv.classList.add("col-span-1");

                } else {
                    inputDiv.classList.add("col-span-2");
                }

                var inputLabel = document.createElement("label");
                inputLabel.classList.add("mb-2", "block", "text-sm", "font-medium", "text-gray-900", "dark:text-white");
                inputLabel.textContent = label;
                inputDiv.appendChild(inputLabel);

                var input = document.createElement("input");
                input.setAttribute("type", type);
                input.setAttribute("id", id);
                input.setAttribute("name", id);

                input.classList.add("focus:ring-primary-600", "focus:border-primary-600", "dark:focus:ring-primary-500",
                    "dark:focus:border-primary-500", "block", "w-full", "rounded-lg", "border", "border-gray-300",
                    "bg-gray-50", "p-2.5", "text-sm", "text-gray-900", "dark:border-gray-500", "dark:bg-gray-600",
                    "dark:text-white", "dark:placeholder-gray-400");

                if (label === "School Year") {
                    input.setAttribute("placeholder", "XXXX-XXXX")
                    input.addEventListener("input", function(event) {
                        let input = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
                        let formattedInput = '';

                        // Insert "-" at specific positions
                        for (let i = 0; i < input.length && i < 8; i++) {
                            if (i === 4) {
                                formattedInput += '-';
                            }
                            formattedInput += input[i];
                        }

                        event.target.value = formattedInput;
                    });
                }
                if (label === "School Name" || label === "School Year") {
                    input.required = true;
                }
                inputDiv.appendChild(input);

                return inputDiv;
            }

            function createSelect(label, options, id) {
                var selectDiv = document.createElement("div");
                selectDiv.classList.add("col-span-2");

                var selectLabel = document.createElement("label");
                selectLabel.setAttribute("for", id);
                selectLabel.classList.add("mb-2", "block", "text-sm", "font-medium", "text-gray-900", "dark:text-white");
                selectLabel.textContent = label;
                selectDiv.appendChild(selectLabel);

                var select = document.createElement("select");
                select.setAttribute("id", id);
                select.setAttribute("name", id);
                if (id.split("_")[0] === "educationLevel") {
                    select.setAttribute("onchange", "educationChange('" + id + "')");
                } else if (id.split("_")[0] === "degree") {
                    select.setAttribute("onchange", "degreeChange('" + id + "')");
                }
                select.classList.add("focus:ring-primary-600", "focus:border-primary-600", "dark:focus:ring-primary-500",
                    "dark:focus:border-primary-500", "block", "w-full", "rounded-lg", "border", "border-gray-300",
                    "bg-gray-50", "p-2.5", "text-sm", "text-gray-900", "dark:border-gray-500", "dark:bg-gray-600",
                    "dark:text-white", "dark:placeholder-gray-400");
                options.forEach(function(optionText) {
                    var option = document.createElement("option");
                    option.text = optionText;
                    option.setAttribute("value", optionText)
                    select.appendChild(option);
                });
                selectDiv.appendChild(select);

                return selectDiv;
            }

            function updateEmploymentOptions() {
                var selectedOption = $('input[name="employment_type"]:checked').val();
                var selectedStatus = $('#employment_status')[0]

                if (selectedOption !== "employed") {
                    // $('#employment_status').addClass("hidden")
                    $('#employment_status').prop("disabled", true)
                    selectedStatus.selectedIndex = 0;
                } else {
                    // $('#employment_status').removeClass('hidden')
                    $('#employment_status').prop('disabled', false)
                }
            }

            function part6Changed() {
                let input = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
                let formattedInput = '';

                // Insert "-" at specific positions
                if (event.target.id === "sss") {
                    for (let i = 0; i < input.length && i < 10; i++) {
                        if (i === 2 || i === 9) {
                            formattedInput += '-';
                        }
                        formattedInput += input[i];
                    }
                } else if (event.target.id === "tin") {
                    for (let i = 0; i < input.length; i++) {
                        if (i % 4 === 0 && i !== 0) {
                            formattedInput += '-';
                        }
                        formattedInput += input[i];
                    }
                } else if (event.target.id === "gsis") {
                    for (let i = 0; i < input.length && i < 11; i++) {
                        formattedInput += input[i];
                    }
                }

                event.target.value = formattedInput;
            }
        </script>
    @endsection

</x-guest-layout>
