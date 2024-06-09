<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Modal body -->
    <form x-data="formEnroll" id="enroll_to_course" class="p-4 md:p-5" method="POSt">
        @csrf
        @php
            $course_id = request()->segment(count(request()->segments()));
        @endphp
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="course_id" value="{{ $course_id }}">
        <div id="step1" x-show="currentStep === 1" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-white">Mailing Address</div>
            <div class="col-span-2">
                <label for="region" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Region
                    <span x-if="errors.region" class="text-xs text-red-500" x-text="errors.region"></span></label>

                <select name="region" id="region" x-model="form.region" @change="regionSelect"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected value="">Select</option>
                </select>
                {{-- <input x-model="form.region" type="hidden" id="region_name" name="region_name" value=""> --}}
                <template x-if="errors.region">
                    <p class="text-sm text-red-500" x-text="errors.region"></p>
                </template>

            </div>

            <div class="col-span-2">
                <label for="province"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Province</label>

                <select x-model="form.province" name="province" id="province" @change="provinceSelect"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                {{-- <input type="hidden" id="province_name" name="province_name" value=""> --}}
                <template x-if="errors.province">
                    <p class="text-sm text-red-500" x-text="errors.province"></p>
                </template>
            </div>

            <div class="col-span-2">
                <label for="district"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">District</label>

                <select x-model="form.district" name="district" id="district"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                {{-- <input type="hidden" id="district_name" name="district_name" value=""> --}}

                <template x-if="errors.district">
                    <p class="text-sm text-red-500" x-text="errors.district"></p>
                </template>
            </div>

            <div class="col-span-2">
                <label for="city"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">City/Municipality</label>

                <select x-model="form.city" name="city" id="city" @change="citySelect"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                <input type="hidden" id="city_name" name="city_name" value="">
                <template x-if="errors.city">
                    <p class="text-sm text-red-500" x-text="errors.city"></p>
                </template>
            </div>

            <div class="col-span-2">
                <label for="barangay"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Barangay</label>

                <select x-model="form.barangay" name="barangay" id="barangay"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option selected="">Select</option>
                </select>
                <input type="hidden" id="barangay_name" name="barangay_name" value="">
                <template x-if="errors.barangay">
                    <p class="text-sm text-red-500" x-text="errors.barangay"></p>
                </template>
            </div>

            <div class="col-span-2">
                <label for="street"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Street</label>
                <input x-model="form.street" type="text" name="street" id="street"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
                <template x-if="errors.street">
                    <p class="text-sm text-red-500" x-text="errors.street"></p>
                </template>
            </div>

            <div class="col-span-2">
                <label for="zip" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Zip
                    Code</label>
                <input x-model="form.zip" type="text" name="zip" id="zip"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
                <template x-if="errors.zip">
                    <p class="text-sm text-red-500" x-text="errors.zip"></p>
                </template>
            </div>

            <div class="col-span-2 justify-self-end">
                <x-primary-button @click="nextStep" id="step1_next" class="col-span-1 col-end-3 w-full text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step2" x-show="currentStep === 2" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-white">Sex</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input x-model="form.sex" id="male" type="radio" value="male" name="sex"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="male"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                </div>
                <div class="flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input x-model="form.sex" id="female" type="radio" value="female" name="sex"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="female"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                </div>
                <template x-if="errors.sex">
                    <p class="text-sm text-red-500" x-text="errors.sex"></p>
                </template>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step2_prev" @click="prevStep" @click="prevStep" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step2_next" @click="nextStep" @click="nextStep" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step3" x-show="currentStep === 3" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-white">Civil Status</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="single" type="radio" x-model="form.civil_status" value="single"
                        name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="single"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Single</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="married" type="radio" x-model="form.civil_status" value="married"
                        name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="married"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Married</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="window" type="radio" x-model="form.civil_status" value="window"
                        name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="window"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Window/er</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="separated" type="radio" x-model="form.civil_status" value="separated"
                        name="civil_status"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="separated"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Separated</label>
                </div>
                <template x-if="errors.civil_status">
                    <p class="text-sm text-red-500" x-text="errors.civil_status"></p>
                </template>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step3_prev" @click="prevStep" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step3_next" @click="nextStep" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step4" x-show="currentStep === 4" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-white">Employment Type</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="employed" type="radio" value="employed" name="employment_type"
                        @change="updateEmploymentOptions()" x-model="form.employment_type"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="employed"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Employed</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="self-employed" type="radio" value="self-employed" name="employment_type"
                        @change="updateEmploymentOptions()" x-model="form.employment_type"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="self-employed"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Self-employed</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="unemployed" type="radio" value="unemployed" name="employment_type"
                        @change="updateEmploymentOptions()" x-model="form.employment_type"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="unemployed"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Unemployed</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input id="trainee" type="radio" value="trainee" name="employment_type"
                        @change="updateEmploymentOptions()" x-model="form.employment_type"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="trainee"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Trainee/OJT</label>
                </div>
                <div class="col-span-2 mt-2">
                    <label for="employment_status"
                        class="mb-2 block font-bold text-gray-900 dark:text-white">Employment
                        Status</label>
                    <select x-model="form.employment_status" name="employment_status" id="employment_status"
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
                <x-primary-button id="step4_prev" @click="prevStep" onclick="prevStep(4)"
                    class="col-span-1 text-white" type="button">Previous</x-primary-button>
                <x-primary-button id="step4_next" @click="nextStep" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>

        </div>
        <div id="step5" x-show="currentStep === 5" class="mb-4 grid grid-cols-2 gap-4">
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
                    <input id="birth_date" x-model="form.birth_date" x-ref="datePickerBirth" type="text"
                        name="birth_date"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Select date" autocomplete="false" required>
                </div>
            </div>
            <div class="col-span-2">
                <label for="birth_place" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Birth
                    Place</label>
                <input type="text" x-model="form.birth_place" name="birth_place" id="birth_place"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="citizenship"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Citizenship</label>
                <input x-model="form.citizenship" type="text" name="citizenship" id="citizenship"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="religion"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Religion</label>
                <input x-model="form.religion" type="text" name="religion" id="religion"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-1">
                <label for="height"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Height</label>
                <input x-model="form.height" @input="heightChanged()" placeholder="kilogram" type="text"
                    name="height" id="height"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-1">
                <label for="weight"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Weight</label>
                <input x-model="form.weight" @input="weightChanged()" placeholder="centimeter" type="text"
                    name="weight" id="weight"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="blood_type" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Blood
                    Type</label>
                <select x-model="form.blood_type" name="blood_type" id="blood_type"
                    class="focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                    <option value="" selected>Select</option>
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
                <x-primary-button id="step5_prev" @click="prevStep" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button id="step5_next" @click="nextStep" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step6" x-show="currentStep === 6" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-white">Personal Information</div>
            <div class="col-span-2">
                <label for="sss" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">SSS
                    No.</label>
                <input type="text" name="sss" id="sss" @input="part6Changed()"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="gsis" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">GSIS
                    No.</label>
                <input type="text" @input="part6Changed()" name="gsis" id="gsis"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="tin" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">TIN
                    No.</label>
                <input type="text" @input="part6Changed()" name="tin" id="tin"
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
                <x-primary-button id="step6_prev" @click="prevStep" onclick="prevStep(6)"
                    class="col-span-1 text-white" type="button">Previous</x-primary-button>
                <x-primary-button id="step6_next" @click="nextStep" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step7" x-show="currentStep === 7" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 flex justify-between font-bold text-white">
                <div class="content-center">Educational Background</div>
                <button class="col-span-1 text-white" type="button" @click="addField">Add</button>
            </div>
            <div class="col-span-2 grid grid-cols-2 gap-4" id="formContainer">
                <template x-for="(education, index) in form.education" :key="index">
                    <div :id="'education-form_' + (index + 1)"
                        class="col-span-2 grid grid-cols-2 gap-2 rounded-lg bg-gray-700 p-2.5">
                        <div class="col-span-2">
                            <label :for="'schoolName_' + (index + 1)"
                                class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">School
                                Name</label>
                            <input :id="'schoolName_' + (index + 1)" type="text" x-model="education.schoolName"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                required>
                        </div>
                        <div class="col-span-2">
                            <label :for="'educationLevel_' + (index + 1)"
                                class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Education
                                Level</label>
                            <select :id="'educationLevel_' + (index + 1)" x-model="education.educationLevel"
                                x-on:change="toggleTertiaryFields(index)"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                <option value="Primary">Primary</option>
                                <option value="Secondary">Secondary</option>
                                <option value="Tertiary">Tertiary</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label :for="'schoolYear_' + (index + 1)"
                                class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">School
                                Year</label>
                            <input :id="'schoolYear_' + (index + 1)" type="text" @input="formatSchoolYear(index)"
                                x-model="education.schoolYear"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="XXXX-XXXX" required>
                        </div>
                        <div :id="'tertiaryFieldsContainer_' + (index + 1)" class="col-span-2 grid grid-cols-2 gap-2"
                            x-show="education.educationLevel === 'Tertiary'">
                            <div class="col-span-2">
                                <label :for="'degree_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Degree</label>
                                <select :id="'degree_' + (index + 1)" x-model="education.degree"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <option value="">Select</option>
                                    <option value="Bachelor's">Bachelor's</option>
                                    <option value="Master's">Master's</option>
                                    <option value="PhD">PhD</option>
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label :for="'minor_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Minor</label>
                                <input :id="'minor_' + (index + 1)" type="text" x-model="education.minor"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                            </div>
                            <div class="col-span-1">
                                <label :for="'major_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Major</label>
                                <input :id="'major_' + (index + 1)" type="text" x-model="education.major"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                            </div>
                            <div class="col-span-2">
                                <label :for="'unitsEarned_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Units
                                    Earned</label>
                                <input :id="'unitsEarned_' + (index + 1)" type="number"
                                    x-model="education.unitsEarned"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    required>
                            </div>
                            <div class="col-span-2">
                                <label :for="'honorsReceived_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Honors
                                    Received</label>
                                <input :id="'honorsReceived_' + (index + 1)" type="text"
                                    x-model="education.honorsReceived"
                                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                            </div>
                        </div>
                        <button type="button"
                            class="col-span-2 justify-self-end rounded bg-red-500 px-1.5 py-1.5 text-xs font-bold text-white hover:bg-red-600"
                            x-on:click="removeField(index)">Remove</button>
                    </div>
                </template>
            </div>
            <div class="col-span-2 grid grid-cols-2 gap-4" id="formContainer"></div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step7_prev" @click="prevStep" onclick="prevStep(7)"
                    class="col-span-1 text-white" type="button">Previous</x-primary-button>
                <x-primary-button id="step7_next" @click="checkMissingFields" class="col-span-1 text-white"
                    type="button">Next</x-primary-button>
            </div>
        </div>
        <div id="step8" x-show="currentStep === 8" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2">
                <div class="mb-2 font-bold text-white">Preferred Schedule (Training)</div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input x-model="form.preferred_schedule" id="weekdays" type="radio" value="weekdays"
                        name="preferred_schedule"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="weekdays"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Weekdays</label>
                </div>
                <div class="mb-2 flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input x-model="form.preferred_schedule" id="weekends" type="radio" value="weekends"
                        name="preferred_schedule"
                        class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600">
                    <label for="weekends"
                        class="ms-2 w-full py-4 text-sm font-medium text-gray-900 dark:text-gray-300">Weekends</label>
                </div>
                <div class="flex items-center rounded border border-gray-200 ps-4 dark:border-gray-700">
                    <input x-model="form.preferred_schedule" id="both" type="radio" value="both"
                        name="preferred_schedule"
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
                    <input x-model="form.preferred_start" x-ref="datePickerStart" type="text"
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
                    <input x-model="form.preferred_finish" x-ref="datePickerFinish" type="text"
                        name="preferred_finish"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Select date">
                </div>
            </div>
            <div class="col-span-2 flex justify-between">
                <x-primary-button id="step8_prev" @click="prevStep" class="col-span-1 text-white"
                    type="button">Previous</x-primary-button>
                <x-primary-button @click="submitForm" class="col-span-1 text-white"
                    type="button">Finish</x-primary-button>
            </div>
        </div>

    </form>
    @section('script')
        <script type="text/javascript">
            // $(document).ready(function() {

            //     // Fetch Regions 
            //     // $.ajax({
            //     //     url: 'https://psgc.gitlab.io/api/regions/',
            //     //     type: 'GET',
            //     //     dataType: 'json',
            //     //     success: function(data) {
            //     //         console.log(data);
            //     //         // Iterate over the regions and append options to select element
            //     //         $.each(data, function(index, region) {
            //     //             $('#region').append($('<option>', {
            //     //                 value: region.code,
            //     //                 text: region.name.toUpperCase()
            //     //             }));
            //     //         });
            //     //     },
            //     //     error: function(xhr, status, error) {
            //     //         console.error('Error fetching regions:', error);
            //     //     }
            //     // });

            //     // $('#region').on('change', function() {
            //     //     var regionCode = $(this).val();
            //     //     var regionName = $(this).find('option:selected').text();
            //     //     console.log(regionName);

            //     //     // Change Provinces Options
            //     //     $.ajax({
            //     //         url: 'https://psgc.gitlab.io/api/regions/' + regionCode + '/provinces',
            //     //         type: 'GET',
            //     //         dataType: 'json',
            //     //         success: function(data) {
            //     //             // Clear existing options
            //     //             $('#province').empty();
            //     //             $('#province').append($('<option>', {
            //     //                 text: 'Select'
            //     //             }))
            //     //             $('#region_name').val(regionName);

            //     //             // Append new options for provinces
            //     //             $.each(data, function(index, province) {
            //     //                 $('#province').append($('<option>', {
            //     //                     value: province.code,
            //     //                     text: province.name.toUpperCase(),
            //     //                 }));
            //     //             });
            //     //         },
            //     //         error: function(xhr, status, error) {
            //     //             console.error('Error fetching provinces:', error);
            //     //         }
            //     //     });

            //     //     // District Option
            //     //     $.ajax({
            //     //         url: 'https://psgc.gitlab.io/api/districts',
            //     //         type: 'GET',
            //     //         dataType: 'json',
            //     //         success: function(data) {
            //     //             // Clear existing options
            //     //             $('#district').empty();
            //     //             $('#district').append($('<option>', {
            //     //                 text: 'Select'
            //     //             }))

            //     //             // Append new options for districts
            //     //             $.each(data, function(index, district) {
            //     //                 $('#district').append($('<option>', {
            //     //                     value: district.code,
            //     //                     text: district.name.toUpperCase()
            //     //                 }));
            //     //             });
            //     //         },
            //     //         error: function(xhr, status, error) {
            //     //             console.error('Error fetching districts:', error);
            //     //         }
            //     //     });
            //     // });

            //     // // Change City Options
            //     // $('#province').on('change', function() {
            //     //     var provCode = $(this).val();
            //     //     var provName = $(this).find('option:selected').text();
            //     //     console.log(provCode);

            //     //     $.ajax({
            //     //         url: 'https://psgc.gitlab.io/api/provinces/' + provCode +
            //     //             '/cities-municipalities',
            //     //         type: 'GET',
            //     //         dataType: 'json',
            //     //         success: function(data) {
            //     //             $('#city').empty();
            //     //             $('#city').append($('<option>', {
            //     //                 text: 'Select'
            //     //             }))
            //     //             $('#province_name').val(provName)

            //     //             $.each(data, function(index, city) {
            //     //                 $('#city').append($('<option>', {
            //     //                     value: city.code,
            //     //                     text: city.name.toUpperCase()
            //     //                 }));
            //     //             });
            //     //         },
            //     //         error: function(xhr, status, error) {
            //     //             console.error('Error fetching barangays:', error);
            //     //         }
            //     //     });

            //     // });

            //     // // Change Barangay Options
            //     // $('#city').on('change', function() {
            //     //     var cityCode = $(this).val();
            //     //     var cityName = $(this).find('option:selected').text();

            //     //     console.log(cityCode);

            //     //     $.ajax({
            //     //         url: 'https://psgc.gitlab.io/api/cities-municipalities/' + cityCode +
            //     //             '/barangays',
            //     //         type: 'GET',
            //     //         dataType: 'json',
            //     //         success: function(data) {
            //     //             $('#barangay').empty();
            //     //             $('#barangay').append($('<option>', {
            //     //                 text: 'Select'
            //     //             }))
            //     //             $('#city_name').val(cityName)

            //     //             $.each(data, function(index, barangay) {
            //     //                 $('#barangay').append($('<option>', {
            //     //                     value: barangay.code,
            //     //                     text: barangay.name.toUpperCase()
            //     //                 }));
            //     //             });
            //     //         },
            //     //         error: function(xhr, status, error) {
            //     //             console.error('Error fetching barangays:', error);
            //     //         }
            //     //     });

            //     // });


            // })
            // $('#barangay').on('change', function() {
            //     var barangayName = $(this).find('option:selected').text();
            //     $('#barangay_name').val(barangayName)

            // })

            // $('#district').on('change', function() {
            //     var districtName = $(this).find('option:selected').text();
            //     $('#district_name').val(districtName)

            // });

            function formEnroll() {
                return {
                    currentStep: 1,
                    form: {
                        course_id: '{{ encrypt($course_id) }}',
                        user_id: '{{ encrypt(auth()->user()->id) }}',
                        region: '',
                        province: '',
                        district: '',
                        city: '',
                        barangay: '',
                        street: '',
                        zip: '',
                        sex: '',
                        civil_status: '',
                        employment_type: '',
                        employment_status: '',
                        birth_date: '',
                        birth_place: '',
                        citizenship: '',
                        religion: '',
                        height: '',
                        weight: '',
                        blood_type: '',
                        sss: '',
                        gsis: '',
                        tin: '',
                        disting_marks: '',
                        education: [],
                        preferred_schedule: '',
                        preferred_start: '',
                        preferred_finish: '',
                    },
                    errors: {},
                    fetchRegions() {
                        $.ajax({
                            url: 'https://psgc.gitlab.io/api/regions/',
                            type: 'GET',
                            dataType: 'json',
                            success: (data) => {
                                const regionField = document.getElementById('region');
                                data.forEach(region => {
                                    const option = document.createElement('option');
                                    option.value = region.code;
                                    option.text = region.name.toUpperCase();
                                    regionField.appendChild(option);
                                });

                                // Auto-select the region loaded from the cookie
                                if (this.form.region) {
                                    regionField.value = this.form.region;
                                    this.regionSelect(); // Trigger province loading
                                }

                                // console.log(regionField);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching regions:', error);
                            }
                        });
                    },
                    async regionSelect() {
                        const regionCode = this.form.region;

                        try {
                            const response = await fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces`);
                            const data = await response.json();

                            const provinceField = document.getElementById('province');
                            provinceField.innerHTML = '<option value="">Select</option>';

                            // Append new options for provinces
                            data.forEach(province => {
                                const option = document.createElement('option');
                                option.value = province.code;
                                option.text = province.name.toUpperCase();
                                provinceField.appendChild(option);
                            });

                            if (this.form.province) {
                                provinceField.value = this.form.province;
                                this.provinceSelect(); // Trigger province loading
                            }
                        } catch (error) {
                            console.error('Error fetching provinces:', error);
                        }
                    },
                    async provinceSelect() {
                        const provCode = this.form.province; // Use the selected province from parameter or from data

                        try {
                            const response = await fetch(
                                `https://psgc.gitlab.io/api/provinces/${provCode}/cities-municipalities`);
                            const data = await response.json();

                            $('#city').empty();
                            $('#district').empty();
                            $('#city').append($('<option>', {
                                text: 'Select'
                            }));

                            data.forEach(city => {
                                $('#city').append($('<option>', {
                                    value: city.code,
                                    text: city.name.toUpperCase()
                                }));
                            });

                            if (this.form.district) {
                                $('#district').val(this.form.district)
                            }
                            this.districtSelect()

                        } catch (error) {
                            console.error('Error fetching cities:', error);
                        }
                    },
                    async districtSelect() {
                        try {
                            const response = await fetch('https://psgc.gitlab.io/api/districts');
                            const data = await response.json();

                            var districtField = $('#district');
                            $('#district').append($('<option>', {
                                text: 'Select'
                            }));

                            data.forEach(district => {
                                $('#district').append($('<option>', {
                                    value: district.code,
                                    text: district.name.toUpperCase()
                                }));
                            });

                            if (this.form.city) {
                                $('#city').val(this.form.city)
                                this.citySelect()
                            }

                            if (this.form.district) {
                                $('#district').val(this.form.district)

                            }
                        } catch (error) {
                            console.error('Error fetching districts:', error);
                        }
                    },
                    async citySelect() {
                        const cityCode = this.form.city; // Use the selected city from parameter or from data
                        try {
                            const response = await fetch(
                                `https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays`);
                            const data = await response.json();

                            $('#barangay').empty();
                            $('#barangay').append($('<option>', {
                                text: 'Select'
                            }));

                            data.forEach(barangay => {
                                $('#barangay').append($('<option>', {
                                    value: barangay.code,
                                    text: barangay.name.toUpperCase()
                                }));
                            });

                            if (this.form.barangay) {
                                $('#barangay').val(this.form.barangay)
                            }
                        } catch (error) {
                            console.error('Error fetching barangays:', error);
                        }
                    },
                    nextStep() {
                        this.clearErrors();
                        if (this.validateStep()) {
                            this.currentStep++;
                            this.saveProgress();
                        }
                    },
                    prevStep() {
                        this.clearErrors();
                        this.currentStep--;
                        this.saveProgress();
                    },
                    validateStep() {
                        console.log(this.form);
                        this.errors = {}; // Clear previous errors
                        switch (this.currentStep) {
                            case 1:
                                if (!this.form.region) this.errors.region = "Required";
                                if (!this.form.province) this.errors.province = "Required";
                                if (!this.form.district) this.errors.district = "Required";
                                if (!this.form.city) this.errors.city = "Required";
                                if (!this.form.barangay) this.errors.barangay = "Required";
                                if (!this.form.street) this.errors.street = "Required";
                                if (!this.form.zip) this.errors.zip = "Required ";
                                break;
                            case 2:
                                if (!this.form.sex) this.errors.sex = "Required";
                                break;
                            case 3:
                                if (!this.form.civil_status) this.errors.civil_status = "Required ";
                                break;
                            case 4:
                                if (!this.form.employment_type) this.errors.employment_type = "Required ";
                                if (this.form.employment_type === 'employed') {
                                    if (!this.form.employment_status) this.errors.employment_status = "Required ";
                                }
                                break;
                            case 5:
                                if (!this.form.birth_date) this.errors.birth_date = "Required ";
                                if (!this.form.birth_place) this.errors.birth_place = "Required ";
                                if (!this.form.citizenship) this.errors.citizenship = "Required ";
                                if (!this.form.religion) this.errors.religion = "Required ";
                                if (!this.form.height) this.errors.height = "Required ";
                                if (!this.form.weight) this.errors.weight = "Required ";
                                if (!this.form.blood_type) this.errors.blood_type = "Required ";
                                break;
                            case 8:
                                if (!this.form.preferred_schedule) this.errors.preferred_schedule = "Required ";
                                if (!this.form.preferred_start) this.errors.preferred_start = "Required ";
                                if (!this.form.preferred_finish) this.errors.preferred_finish = "Required ";
                                break;

                        }
                        return Object.keys(this.errors).length === 0;
                    },
                    updateEmploymentOptions() {
                        if (this.form.employment_type !== "employed") {
                            $('#employment_status').prop("disabled", true)
                            this.form.employment_status = '';
                        } else {
                            $('#employment_status').prop('disabled', false)
                        }
                    },
                    dateChanged() {
                        let inputValue = event.target.value;
                        let inputName = event.target.name

                        let isValidFormat = /^\d{2}\/\d{2}\/\d{4}$/.test(inputValue);

                        if (!isValidFormat) {
                            event.target.value = inputValue.slice(0, -1);
                        }
                    },
                    heightChanged() {
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
                    },
                    weightChanged() {
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
                    },
                    part6Changed() {
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
                    },

                    addField() {
                        var data = this.form.education
                        console.log(this.form);
                        data.push({
                            schoolName: '',
                            educationLevel: 'Primary',
                            schoolYear: '',
                            degree: '',
                            minor: '',
                            major: '',
                            unitsEarned: '',
                            honorsReceived: ''
                        });
                        console.log(data);

                    },

                    removeField(index) {
                        var user = confirm("Are you sure you want to remove this?");
                        if (user) {
                            this.form.education.splice(index, 1);
                        }
                    },

                    toggleTertiaryFields(index) {
                        console.log(this.form.education);
                        if (this.form.education[index].educationLevel !== 'Tertiary') {
                            this.form.education[index].degree = '';
                            this.form.education[index].minor = '';
                            this.form.education[index].major = '';
                            this.form.education[index].unitsEarned = '';
                            this.form.education[index].honorsReceived = '';
                        }
                    },
                    formatSchoolYear(index) {
                        let input = this.form.education[index].schoolYear.replace(/\D/g, ''); // Remove non-numeric characters
                        let formattedInput = '';

                        // Insert "-" at specific positions
                        for (let i = 0; i < input.length && i < 8; i++) {
                            if (i === 4) {
                                formattedInput += '-';
                            }
                            formattedInput += input[i];
                        }

                        this.form.education[index].schoolYear = formattedInput;
                    },
                    missingFields: [],
                    checkMissingFields() {
                        this.missingFields = [];

                        this.form.education.forEach((edu, index) => {
                            if (!edu.schoolName) {
                                this.missingFields.push(`Education No.${index + 1}: School Name`);
                            }
                            if (!edu.educationLevel) {
                                this.missingFields.push(`Education No.${index + 1}: Education Level`);
                            }
                            if (!edu.schoolYear) {
                                this.missingFields.push(`Education No.${index + 1}: School Year`);
                            }
                            if (edu.educationLevel === "Tertiary") {
                                if (!edu.unitsEarned) {
                                    this.missingFields.push(`Education No.${index + 1}: Units Earned`);
                                }
                                if (!edu.degree) {
                                    this.missingFields.push(`Education No.${index + 1}: Degree`);
                                }
                            }
                        });

                        if (this.missingFields.length === 0) {
                            this.nextStep()
                        }
                        console.log(this.missingFields);
                    },
                    updateDate(event) {
                        this.date = event.target.value;
                        console.log('Selected date:', this.date);
                    },
                    clearErrors() {
                        this.errors = {};
                    },
                    submitForm() {
                        // this.clearErrors();

                        if (this.validateStep()) {
                            const formData = JSON.stringify(this.form);

                            // Perform the submission (e.g., via AJAX)
                            // Example using AJAX:
                            $.ajax({
                                url: '{{ route('enroll_save') }}',
                                type: 'POST',
                                contentType: 'application/json',
                                data: formData,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: (response) => {
                                    // Handle successful submission
                                    alert("Form submitted successfully!");
                                    this.clearProgress();
                                    console.log('Submission response:', response);

                                    const url = `{{ route('enroll_requirements', ':id') }}`.replace(':id', response
                                        .id);
                                    window.location.href = url;
                                },
                                error: (xhr, status, error) => {
                                    console.error('Submission error:', error);
                                }
                            });
                        }
                    },
                    saveProgress() {
                        const formProgress = JSON.stringify(this.form);
                        const expirationDate = new Date();
                        expirationDate.setDate(expirationDate.getDate() + 1); // Set expiration to 1 day from now
                        document.cookie = `formProgress=${formProgress};expires=${expirationDate.toUTCString()};path=/`;
                        document.cookie =
                            `currentStep=${this.currentStep};expires=${expirationDate.toUTCString()};path=/`;
                    },
                    loadProgress() {
                        const cookies = document.cookie.split(';').reduce((acc, cookie) => {
                            const [key, ...valueParts] = cookie.trim().split('=');
                            const value = valueParts.join('=');
                            acc[key] = value;
                            return acc;
                        }, {});
                        if (cookies.formProgress) {
                            this.form = JSON.parse(cookies.formProgress);
                        }
                        if (cookies.currentStep) {
                            this.currentStep = parseInt(cookies.currentStep, 10);
                        }
                    },
                    clearProgress() {
                        document.cookie = "formProgress=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
                        document.cookie = "currentStep=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
                    },
                    init() {
                        this.loadProgress();
                        this.fetchRegions();
                        // this.regionSelect();
                        if (this.form.employment_type !== 'employed' || this.form.employment_type !== 'trainee') {
                            $('#employment_status').prop("disabled", true)
                        }
                        console.log(this.form);
                        flatpickr(this.$refs.datePickerStart, {
                            altInput: true,
                            altFormat: "F j, Y",
                            dateFormat: "Y-m-d",
                            minDate: "today",
                            defaultDate: this.form.preferred_start,

                        })
                        flatpickr(this.$refs.datePickerFinish, {
                            altInput: true,
                            altFormat: "F j, Y",
                            dateFormat: "Y-m-d",
                            minDate: new Date().fp_incr(30),
                            defaultDate: this.form.preferred_finish,

                        })
                        flatpickr(this.$refs.datePickerBirth, {
                            altInput: true,
                            altFormat: "F j, Y",
                            dateFormat: "Y-m-d",
                            maxDate: new Date().fp_incr(-6205),
                            defaultDate: this.form.birth_date,
                        })
                    }
                }
            }


            // // Validation Step 1
            // $(document).ready(function() {
            //     $('#step1_next').click(function() {
            //         // var region = $('#region').val();
            //         // var province = $('#province').val();
            //         // var district = $('#district').val();
            //         // var city = $('#city').val();
            //         // var barangay = $('#barangay').val();
            //         // var street = $('#street').val();
            //         // var zip = $('#zip').val();

            //         // if (region == "" || province == "" || district == "" || city == "" || barangay == "" ||
            //         //     street == "" || zip == "") {
            //         //     alert("Please fill in all fields.");
            //         //     return false;
            //         // }

            //         var inputs = document.querySelectorAll("#step1 input:not([type=hidden]), #step1 select");
            //         var labels = document.querySelectorAll("#step1 label");
            //         console.log(inputs);
            //         for (var i = 0; i < inputs.length; i++) {
            //             var input = inputs[i];
            //             var label = labels[i];
            //             var value = input.value.trim();

            //             if (!value && input.required || value === "Select") {
            //                 input.classList.remove('dark:border-gray-500')
            //                 input.classList.add('dark:border-red-500')
            //                 label.classList.remove('dark:text-white')
            //                 label.classList.add('dark:text-red @click="prevStep"-500')
            //                 var label = input.previousElementSibling.textContent.trim();
            //                 if @click="nextStep" (i < 5)
            //                     alert("Please indicate your " + label.toUpperCase());
            //                 else
            //                     alert("Please fill in the " + label.toUpperCase() + " FIELD");
            //                 return;
            //             } else {
            //                 input.classList.add('dark:border-gray-500')
            //                 input.classList.remove('dark:border-red-500')
            //                 label.classList.add('dark:text-white')
            //                 label.classList.remove('dark:text-red-500')
            //             }
            //         }

            //         nextStep(1);
            //     });

            //     $("#street").on('input', function() {
            //         $(this).val($(this).val().toUpperCase())
            //     })

            //     $("#zip").on('input', function() {
            //         $(this).val($(this).val().replace(/[^0-9]/g, ''));

            //         // Limit input to maximum of 4 characters
            //         if ($(this).val().length > 4) {
            //             $(this).val($(this).val().slice(0, 4));
            //         }
            //     })
            // });

            // // Validation Step 2
            // $(document).ready(function() {
            //     $('#step2_next').click(function() {
            //         if (!$("input[name='sex']:checked").val()) {
            //             alert("Please indicate your SEX");
            //             return
            //         } else {
            //             nextStep(2);
            //         }
            //     })
            // });

            // // Validation Step 3
            // $(document).ready(function() {
            //     $('#step3_next').click(function() {
            //         if (!$("input[name='civil_status']:checked").val()) {
            //             alert('Please indicate your CIVIL STATUS.');
            //         } else {
            //             nextStep(3);
            //         }
            //     })
            // });

            // // Validation Step 4
            // $(document).ready(function() {
            //     $('#step4_next').click(function() {
            //         var emp_type = $("input[name='employment_type']:checked").val()
            //         var emp_status = $('#employment_status').val();
            //         if (!emp_type) {
            //             alert('Please indicate your EMPLOYMENT TYPE');
            //         } else if (emp_type === "employed") {
            //             if (emp_status === "Select") {
            //                 alert('Please indicate your EMPLOYMENT STATUS');
            //                 validate = false;
            //             } else {
            //                 nextStep(4)
            //             }
            //         } else {
            //             console.log(emp_status);
            //             nextStep(4);
            //         }

            //     })
            // });

            // // Validation Step 5
            // $(document).ready(function() {
            //     $('#step5_next').click(function() {
            //         var inputs = document.querySelectorAll("#step5 input, #step5 select");
            //         var labels = document.querySelectorAll("#step5 label");
            //         // console.log(labels[0].textContent);
            //         for (var i = 0; i < inputs.length; i++) {
            //             var input = inputs[i];
            //             var label = labels[i];
            //             var value = input.value.trim();

            //             if (!value && input.required || value === "Select") {
            //                 input.classList.remove('dark:border-gray-500')
            //                 input.classList.add('dark:border-red-500')
            //                 label.classList.remove('dark:text-white')
            //                 label.classList.add('dark:text-red-500')
            //                 var label = label.textContent.trim();
            //                 if (i == 0 || i == 6)
            //                     alert("Please indicate your " + label.replace(/\s+/g, ' ').trim()
            //                         .toUpperCase());
            //                 else
            //                     alert("Please fill in the " + label.replace(/\s+/g, ' ').trim().toUpperCase() +
            //                         " FIELD");
            //                 return;
            //             } else {
            //                 input.classList.add('dark:border-gray-500')
            //                 input.classList.remove('dark:border-red-500')
            //                 label.classList.add('dark:text-white')
            //                 label.classList.remove('dark:text-red-500')
            //             }
            //         }

            //         nextStep(5);
            //     })
            // });

            // // Validation 6
            // $(document).ready(function() {
            //     $('#step6_next').click(function() {
            //         var inputs = document.querySelectorAll("#step6 input, #step6 select");
            //         var labels = document.querySelectorAll("#step6 label")
            //         // console.log(labels[0].textContent);
            //         // for (var i = 0; i < inputs.length; i++) {
            //         //     var input = inputs[i];
            //         //     var label = labels[i];
            //         //     var value = input.value.trim();

            //         //     if (!value && input.required || value === "Select") {
            //         //         input.classList.remove('dark:border-gray-500')
            //         //         input.classList.add('dark:border-red-500')
            //         //         label.classList.remove('dark:text-white')
            //         //         label.classList.add('dark:text-red-500')
            //         //         var label = label.textContent.trim();
            //         //         alert("Please fill in the " + label.replace(/\s+/g, ' ').trim().toUpperCase() +
            //         //             " FIELD");
            //         //         return;
            //         //     } else {
            //         //         input.classList.add('dark:border-gray-500')
            //         //         input.classList.remove('dark:border-red-500')
            //         //         label.classList.add('dark:text-white')
            //         //         label.classList.remove('dark:text-red-500')
            //         //     }
            //         // }

            //         nextStep(6)
            //     })
            // });

            // // Validation 7
            // $(document).ready(function() {
            //     $('#step7_next').click(function() {
            //         var inputs = document.querySelectorAll("#step7 input, #step7 select");
            //         var labels = document.querySelectorAll("#step7 label");
            //         console.log(inputs);
            //         for (var i = 0; i < inputs.length; i++) {
            //             var input = inputs[i];
            //             var label = labels[i];
            //             var value = input.value.trim();

            //             if (!value && input.required || value === "Select") {
            //                 input.classList.remove('dark:border-gray-500')
            //                 input.classList.add('dark:border-red-500')
            //                 label.classList.remove('dark:text-white')
            //                 label.classList.add('dark:text-red-500')
            //                 var label = label.textContent.trim();
            //                 if (i == 0 || i == 6)
            //                     alert("Please indicate your " + label.replace(/\s+/g, ' ').trim()
            //                         .toUpperCase());
            //                 else
            //                     alert("Please fill in the " + label.replace(/\s+/g, ' ').trim().toUpperCase() +
            //                         " FIELD");
            //                 return;
            //             } else {
            //                 input.classList.add('dark:border-gray-500')
            //                 input.classList.remove('dark:border-red-500')
            //                 label.classList.add('dark:text-white')
            //                 label.classList.remove('dark:text-red-500')
            //             }
            //         }

            //         nextStep(7)
            //     })
            // });

            // // Validation 8
            // function finish() {
            //     if (!$("input[name='preferred_schedule']:checked").val()) {
            //         alert("Please indicate your PREFERRED SCHEDULE");
            //         return
            //     }
            //     if (!$("input[name='preferred_start']").val() || !$("input[name='preferred_finish']").val()) {
            //         alert("Please indicate your PREFERRED START AND END DATES");
            //         return
            //     }

            //     const input = prompt(
            //         "Confirm that the data you've entered is true and correct by typing 'YES' if it is."
            //     )
            //     if (input !== null && input.toUpperCase() === "YES") {
            //         $("#enroll_to_course").submit()
            //     } else {
            //         // User did not confirm
            //         alert("Confirmation failed. Please type 'YES' to confirm.");
            //     }
            // }

            // // Step Navigator: Next
            // function nextStep(step) {
            //     document.getElementById('step' + step).classList.remove('visible');
            //     document.getElementById('step' + step).classList.add('hidden');
            //     document.getElementById('step' + (step + 1)).classList.add('visible');
            //     document.getElementById('step' + (step + 1)).classList.remove('hidden');
            // }

            // // Step Navigator: Previous
            // function prevStep(step) {
            //     document.getElementById('step' + step).classList.remove('visible');
            //     document.getElementById('step' + step).classList.add('hidden');
            //     document.getElementById('step' + (step - 1)).classList.add('visible');
            //     document.getElementById('step' + (step - 1)).classList.remove('hidden');
            // }

            // function dateChanged() {
            //     let inputValue = event.target.value;
            //     let inputName = event.target.name

            //     // Validate the input format using a regular expression
            //     let isValidFormat = /^\d{2}\/\d{2}\/\d{4}$/.test(inputValue);

            //     // If the input format is invalid, remove the last character
            //     if (!isValidFormat) {
            //         event.target.value = inputValue.slice(0, -1);
            //     }
            // }

            // function heightChanged() {
            //     let inputValue = event.target.value;

            //     // Remove any non-numeric characters
            //     let numericValue = inputValue.replace(/[^0-9]/g, '');

            //     if (numericValue === '' || numericValue === '0') {
            //         event.target.value = '';
            //     } else {
            //         // Append "kg" only if numeric value is not empty and not '0'
            //         event.target.value = numericValue + ' kg';
            //     }

            //     event.target.setSelectionRange(numericValue.length, numericValue.length);
            // }

            // function weightChanged() {
            //     let inputValue = event.target.value;

            //     // Remove any non-numeric characters
            //     let numericValue = inputValue.replace(/[^0-9]/g, '');

            //     if (numericValue === '' || numericValue === '0') {
            //         event.target.value = '';
            //     } else {
            //         // Append "kg" only if numeric value is not empty and not '0'
            //         event.target.value = numericValue + ' cm';
            //     }
            //     event.target.setSelectionRange(numericValue.length, numericValue.length);
            // }

            // var groupCount = 0; // To keep track of the number of groups added
            // var tertiaryFieldsContainer;

            // function createForm() {
            //     groupCount++; // Increment group count
            //     var formContainer = document.getElementById("formContainer");
            //     var div = document.createElement("div");
            //     div.classList.add('education-form_' + groupCount, 'bg-gray-700', 'p-2.5', 'rounded-lg', 'col-span-2', 'grid',
            //         'grid-cols-2', 'gap-2')
            //     div.id = 'education-form_' + groupCount

            //     var schoolNameInput = createInput("text", "School Name", "schoolName_" + groupCount);
            //     div.appendChild(schoolNameInput);

            //     var educationLevelSelect = createSelect("Education Level", ["Primary", "Secondary", "Tertiary"],
            //         "educationLevel_" + groupCount);
            //     div.appendChild(educationLevelSelect);

            //     // var schoolYearInput = createInput("text", "School Year", "schoolYear_" + groupCount);
            //     // div.appendChild(schoolYearInput);

            //     var schoolYearFromInput = createInput("text", "School Year", "schoolYear_" + groupCount);
            //     div.appendChild(schoolYearFromInput);


            //     tertiaryFieldsContainer = document.createElement("div");
            //     tertiaryFieldsContainer.id = 'tertiaryFieldsContainer_' + groupCount
            //     tertiaryFieldsContainer.classList.add('col-span-2', 'grid', 'grid-cols-2', 'gap-2')

            //     var degreeSelect = createSelect("Degree", ["Bachelor's", "Master's", "PhD"], "degree_" + groupCount);
            //     tertiaryFieldsContainer.appendChild(degreeSelect);

            //     var minorInput = createInput("text", "Minor", "minor_" + groupCount);
            //     tertiaryFieldsContainer.appendChild(minorInput);

            //     var majorInput = createInput("text", "Major", "major_" + groupCount);
            //     tertiaryFieldsContainer.appendChild(majorInput);

            //     var unitsEarnedInput = createInput("number", "Units Earned", "unitsEarned_" + groupCount);
            //     tertiaryFieldsContainer.appendChild(unitsEarnedInput);

            //     var honorsReceivedInput = createInput("text", "Honors Received", "honorsReceived_" + groupCount);
            //     tertiaryFieldsContainer.appendChild(honorsReceivedInput);

            //     var removeButton = createRemoveButton(tertiaryFieldsContainer.id);


            //     tertiaryFieldsContainer.classList.add("hidden");
            //     div.appendChild(tertiaryFieldsContainer);

            //     div.appendChild(removeButton);
            //     // Show additional fields only when "Tertiary" is selected
            //     // educationLevelSelect.addEventListener("change", function() {

            //     // });

            //     formContainer.appendChild(div);
            // }

            // function createRemoveButton(tertiaryFieldsContainer) {
            //     var suffix = tertiaryFieldsContainer.split("_")[1];
            //     var removeButton = document.createElement("button");

            //     removeButton.textContent = "Remove";
            //     removeButton.setAttribute("type", "button")
            //     removeButton.classList.add("col-span-2", "justify-self-end", "bg-red-500", "hover:bg-red-600", "text-white",
            //         "font-bold", "py-1.5", "px-1.5", "text-xs", "rounded");
            //     removeButton.addEventListener("click", function() {
            //         const confirmed = confirm('Are you sure you want to remove this?');

            //         if (confirmed) {
            //             var div = document.getElementById('education-form_' + suffix)
            //             div.remove();
            //         } else {
            //             console.log(false);
            //         }

            //         console.log(div);
            //     });

            //     return removeButton
            // }

            // function educationChange(id) {
            //     var suffix = id.split("_")[1];
            //     var val = document.getElementById(id);
            //     var tertiary = document.getElementById("tertiaryFieldsContainer_" + suffix)
            //     var unitsEarned = document.getElementById("unitsEarned_" + suffix)

            //     if (val.value === "Tertiary") {
            //         // console.log(tertiaryFieldsContainer);
            //         tertiary.classList.remove("hidden");
            //         unitsEarned.required = true;
            //     } else {
            //         // console.log("not tertiary");
            //         tertiary.classList.add("hidden");
            //         unitsEarned.required = false;

            //     }
            // }

            // function createInput(type, label, id) {
            //     var inputDiv = document.createElement("div");
            //     if (label === "Minor" || label === "Major") {
            //         inputDiv.classList.add("col-span-1");

            //     } else {
            //         inputDiv.classList.add("col-span-2");
            //     }

            //     var inputLabel = document.createElement("label");
            //     inputLabel.classList.add("mb-1", "block", "text-sm", "font-medium", "text-gray-900", "dark:text-white");
            //     inputLabel.textContent = label;
            //     inputDiv.appendChild(inputLabel);

            //     var input = document.createElement("input");
            //     input.setAttribute("type", type);
            //     input.setAttribute("id", id);
            //     input.setAttribute("name", id);

            //     input.classList.add("focus:ring-primary-600", "focus:border-primary-600", "dark:focus:ring-primary-500",
            //         "dark:focus:border-primary-500", "block", "w-full", "rounded-lg", "border", "border-gray-300",
            //         "bg-gray-50", "p-2", "text-xs", "text-gray-900", "dark:border-gray-500", "dark:bg-gray-600",
            //         "dark:text-white", "dark:placeholder-gray-400");

            //     if (label === "School Year") {
            //         input.setAttribute("placeholder", "XXXX-XXXX")
            //         input.addEventListener("input", function(event) {
            //             let input = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
            //             let formattedInput = '';

            //             // Insert "-" at specific positions
            //             for (let i = 0; i < input.length && i < 8; i++) {
            //                 if (i === 4) {
            //                     formattedInput += '-';
            //                 }
            //                 formattedInput += input[i];
            //             }

            //             event.target.value = formattedInput;
            //         });
            //     }
            //     if (label === "School Name" || label === "School Year") {
            //         input.required = true;
            //     }
            //     inputDiv.appendChild(input);

            //     return inputDiv;
            // }

            // function createSelect(label, options, id) {
            //     var selectDiv = document.createElement("div");
            //     selectDiv.classList.add("col-span-2");

            //     var selectLabel = document.createElement("label");
            //     selectLabel.setAttribute("for", id);
            //     selectLabel.classList.add("mb-1", "block", "text-sm", "font-medium", "text-gray-900", "dark:text-white");
            //     selectLabel.textContent = label;
            //     selectDiv.appendChild(selectLabel);

            //     var select = document.createElement("select");
            //     select.setAttribute("id", id);
            //     select.setAttribute("name", id);
            //     if (id.split("_")[0] === "educationLevel") {
            //         select.setAttribute("onchange", "educationChange('" + id + "')");
            //     } else if (id.split("_")[0] === "degree") {
            //         select.setAttribute("onchange", "degreeChange('" + id + "')");
            //     }
            //     select.classList.add("focus:ring-primary-600", "focus:border-primary-600", "dark:focus:ring-primary-500",
            //         "dark:focus:border-primary-500", "block", "w-full", "rounded-lg", "border", "border-gray-300",
            //         "bg-gray-50", "p-2", "text-xs", "text-gray-900", "dark:border-gray-500", "dark:bg-gray-600",
            //         "dark:text-white", "dark:placeholder-gray-400");
            //     options.forEach(function(optionText) {
            //         var option = document.createElement("option");
            //         option.text = optionText;
            //         option.setAttribute("value", optionText)
            //         select.appendChild(option);
            //     });
            //     selectDiv.appendChild(select);

            //     return selectDiv;
            // }

            // function updateEmploymentOptions() {
            //     var selectedOption = $('input[name="employment_type"]:checked').val();
            //     var selectedStatus = $('#employment_status')[0]

            //     if (selectedOption !== "employed") {
            //         // $('#employment_status').addClass("hidden")
            //         $('#employment_status').prop("disabled", true)
            //         selectedStatus.selectedIndex = 0;
            //     } else {
            //         // $('#employment_status').removeClass('hidden')
            //         $('#employment_status').prop('disabled', false)
            //     }
            // }

            // function part6Changed() {
            //     let input = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
            //     let formattedInput = '';

            //     // Insert "-" at specific positions
            //     if (event.target.id === "sss") {
            //         for (let i = 0; i < input.length && i < 10; i++) {
            //             if (i === 2 || i === 9) {
            //                 formattedInput += '-';
            //             }
            //             formattedInput += input[i];
            //         }
            //     } else if (event.target.id === "tin") {
            //         for (let i = 0; i < input.length; i++) {
            //             if (i % 4 === 0 && i !== 0) {
            //                 formattedInput += '-';
            //             }
            //             formattedInput += input[i];
            //         }
            //     } else if (event.target.id === "gsis") {
            //         for (let i = 0; i < input.length && i < 11; i++) {
            //             formattedInput += input[i];
            //         }
            //     }

            //     event.target.value = formattedInput;
            // }
        </script>
    @endsection

</x-guest-layout>
