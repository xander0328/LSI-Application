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
        <div id="step1" x-cloak x-show="currentStep === 1" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-black dark:text-white">MAILING ADDRESS</div>
            <div class="col-span-2">
                <label for="region" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Region <span
                        class="text-red-500">*</span></label>

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
                <label for="province" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Province<span
                        class="text-red-500">*</span></label>

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
                <label for="district" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">District<span
                        class="text-red-500">*</span></label>

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
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">City/Municipality<span
                        class="text-red-500">*</span></label>

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
                <label for="barangay" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Barangay<span
                        class="text-red-500">*</span></label>

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
                <label for="street" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Street<span
                        class="text-red-500">*</span></label>
                <input x-model="form.street" type="text" name="street" id="street"
                    class=" capitalize focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
                <template x-if="errors.street">
                    <p class="text-sm text-red-500" x-text="errors.street"></p>
                </template>
            </div>

            <div class="col-span-2">
                <label for="zip" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Zip
                    Code<span class="text-red-500">*</span></label>
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
        <div id="step2" x-cloak x-show="currentStep === 2" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-black dark:text-white">Sex<span class="text-red-500">*</span></div>
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
        <div id="step3" x-cloak x-show="currentStep === 3" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-black dark:text-white">Civil Status<span class="text-red-500">*</span>
                </div>
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
        <div id="step4" x-cloak x-show="currentStep === 4" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <div class="mb-2 font-bold text-black dark:text-white">Employment Type<span
                        class="text-red-500">*</span></div>
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
                        Status <span x-show="form.employment_type == 'employed'" class="text-red-500">*</span></label>
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
        <div id="step5" x-cloak x-show="currentStep === 5" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-black dark:text-white">PERSONAL INFORMATION</div>
            <div class="col-span-2 mb-2">
                <label for="birth_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Birth
                    Date<span class="text-red-500">*</span></label>
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
                    Place<span class="text-red-500">*</span></label>
                <input type="text" x-model="form.birth_place" name="birth_place" id="birth_place"
                    class="capitalize focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="citizenship"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Citizenship<span
                        class="text-red-500">*</span></label>
                <input list="nationality_list" x-model="form.citizenship" type="text" name="citizenship"
                    id="citizenship"
                    class="capitalize focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
                <datalist id="nationality_list">
                    <template x-for="nationality in nationalities" :key="nationality">
                        <option :value="nationality" x-text="nationality"></option>
                    </template>
                </datalist>
            </div>
            <div class="col-span-2">
                <label for="religion"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Religion<span
                        class="text-red-500">*</span></label>
                <input list="religion_list" x-model="form.religion" type="text" name="religion" id="religion"
                    class="capitalize focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
                <datalist id="religion_list">
                    <template x-for="religion in religions" :key="religion">
                        <option :value="religion" x-text="religion"></option>
                    </template>
                </datalist>
            </div>
            <div class="col-span-1">
                <label for="height" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Height<span
                        class="text-red-500">*</span></label>
                <input x-model="form.height" @input="heightChanged()" placeholder="kilogram" type="text"
                    name="height" id="height"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-1">
                <label for="weight" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Weight<span
                        class="text-red-500">*</span></label>
                <input x-model="form.weight" @input="weightChanged()" placeholder="centimeter" type="text"
                    name="weight" id="weight"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="" required="">
            </div>
            <div class="col-span-2">
                <label for="blood_type" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Blood
                    Type<span class="text-red-500">*</span></label>
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
        <div id="step6" x-cloak x-show="currentStep === 6" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 font-bold text-black dark:text-white">PERSONAL INFORMATION</div>
            <div class="col-span-2">
                <label for="sss" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">SSS
                    No.</label>
                <input type="text" name="sss" id="sss" @input="part6Changed()" x-model="form.sss"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="gsis" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">GSIS
                    No.</label>
                <input type="text" @input="part6Changed()" name="gsis" id="gsis" x-model="form.gsis"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="tin" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">TIN
                    No.</label>
                <input type="text" @input="part6Changed()" name="tin" id="tin" x-model="form.tin"
                    class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                    placeholder="">
            </div>
            <div class="col-span-2">
                <label for="disting_marks"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Distinguishing Marks</label>
                <input type="text" name="disting_marks" id="disting_marks" x-model="form.disting_marks"
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
        <div id="step7" x-cloak x-show="currentStep === 7" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2 flex justify-between font-bold text-white">
                <div class="content-center">EDUCATIONAL BACKGROUND</div>
                <button class="col-span-1 text-white" type="button" @click="addField">Add</button>
            </div>
            <div class="col-span-2 grid grid-cols-2 gap-4" id="formContainer">
                <template x-for="(education, index) in form.education" :key="index">
                    <div :id="'education-form_' + (index + 1)"
                        class="col-span-2 grid grid-cols-2 gap-2 rounded-lg bg-gray-700 p-2.5">
                        <div class="col-span-2">
                            <label :for="'schoolName_' + (index + 1)"
                                class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">School
                                Name<span class="text-red-500">*</span></label>
                            <input :id="'schoolName_' + (index + 1)" type="text" x-model="education.schoolName"
                                class="focus:ring-primary-600 capitalize focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                required>
                        </div>
                        <div class="col-span-2">
                            <label :for="'educationLevel_' + (index + 1)"
                                class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Education
                                Level<span class="text-red-500">*</span></label>
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
                                Year<span class="text-red-500">*</span></label>
                            <input :id="'schoolYear_' + (index + 1)" type="text" @input="formatSchoolYear(index)"
                                x-model="education.schoolYear"
                                class="focus:ring-primary-600 focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                placeholder="XXXX-XXXX" required>
                        </div>
                        <div :id="'tertiaryFieldsContainer_' + (index + 1)" class="col-span-2 grid grid-cols-2 gap-2"
                            x-show="education.educationLevel === 'Tertiary'">
                            <div class="col-span-2">
                                <label :for="'degree_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Degree<span
                                        class="text-red-500">*</span></label>
                                <select :id="'degree_' + (index + 1)" x-model="education.degree"
                                    class="focus:ring-primary-600  focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
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
                                    class="focus:ring-primary-600 capitalize focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                            </div>
                            <div class="col-span-1">
                                <label :for="'major_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Major</label>
                                <input :id="'major_' + (index + 1)" type="text" x-model="education.major"
                                    class="focus:ring-primary-600 capitalize focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
                            </div>
                            <div class="col-span-2">
                                <label :for="'unitsEarned_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Units
                                    Earned<span class="text-red-500">*</span></label>
                                <input :id="'unitsEarned_' + (index + 1)" type="number"
                                    x-model="education.unitsEarned"
                                    class="focus:ring-primary-600 capitalize focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    required>
                            </div>
                            <div class="col-span-2">
                                <label :for="'honorsReceived_' + (index + 1)"
                                    class="mb-1 block text-sm font-medium text-gray-900 dark:text-white">Honors
                                    Received</label>
                                <input :id="'honorsReceived_' + (index + 1)" type="text"
                                    x-model="education.honorsReceived"
                                    class="focus:ring-primary-600 capitalize focus:border-primary-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400">
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
        <div id="step8" x-cloak x-show="currentStep === 8" class="mb-4 grid grid-cols-2 gap-4">
            <div class="col-span-2 mb-2">
                <div class="mb-2 font-bold text-black dark:text-white">Preferred Schedule (Training)<span
                        class="text-red-500">*</span></div>
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
                    Start<span class="text-red-500">*</span></label>
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
                    Finish<span class="text-red-500">*</span></label>
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
                    nationalities: [
                        'Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans',
                        'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian',
                        'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian',
                        'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian',
                        'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian',
                        'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean',
                        'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban',
                        'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese',
                        'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian',
                        'Ethiopian', 'Fijian', 'Filipino', 'Finnish', 'French', 'Gabonese', 'Gambian',
                        'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan',
                        'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'I-Kiribati',
                        'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian',
                        'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian',
                        'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner',
                        'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan',
                        'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian',
                        'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian',
                        'Nauruan', 'Nepalese', 'New Zealander', 'Ni-Vanuatu', 'Nicaraguan', 'Nigerien', 'North Korean',
                        'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian',
                        'Papua New Guinean',
                        'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Qatari', 'Romanian', 'Russian', 'Rwandan',
                        'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish',
                        'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian',
                        'Slovenian',
                        'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan',
                        'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik',
                        'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian or Tobagonian', 'Tunisian',
                        'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan',
                        'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean'
                    ],
                    religions: [
                        'Roman Catholic', 'Islam', 'Evangelical', 'Iglesia ni Cristo',
                        'Aglipayan', 'Baptist', 'Methodist', 'Jehovah’s Witnesses',
                        'Seventh-Day Adventist', 'Church of Christ', 'Pentecostal',
                        'Protestant', 'Lutheran', 'Eastern Orthodox', 'Buddhist'
                    ],

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
                            event.target.value = numericValue + ' cm';
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
                            event.target.value = numericValue + ' kg';
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
                    // loadProgress() {
                    //     const cookies = document.cookie.split(';').reduce((acc, cookie) => {
                    //         const [key, value] = cookie.trim().split('=').map(decodeURIComponent);
                    //         // const value = valueParts.join('=');
                    //         acc[key] = value;
                    //         return acc;
                    //     }, {});
                    //     if (cookies.formProgress) {
                    //         const formProgress = JSON.parse(cookies.formProgress);
                    //         const savedCourseId = formProgress.course_id; // Assuming this is how course_id is stored

                    //         // Check if the course_id matches
                    //         if (savedCourseId === this.form.course_id) {

                    //             this.form = formProgress;
                    //             if (cookies.currentStep) {
                    //                 this.currentStep = parseInt(cookies.currentStep, 10);
                    //             }
                    //         } else {
                    //             this.currentStep = 1;
                    //         }
                    //     }
                    // },
                    loadProgress() {
                        const cookies = document.cookie.split(';').reduce((acc, cookie) => {
                            const [key, ...valueParts] = cookie.trim().split('=');
                            const value = valueParts.join('=');
                            acc[key] = value;
                            return acc;
                        }, {});
                        if (cookies.formProgress) {
                            const formProgress = JSON.parse(cookies.formProgress);
                            const savedCourseId = formProgress.course_id;

                            @php
                                if (isset($_COOKIE['formProgress'])) {
                                    // Decode the JSON string from the 'formProgress' cookie
                                    $cookie_form = json_decode($_COOKIE['formProgress'], true);

                                    // Decrypt the course_id and user_id if they exist and are encrypted
                                    $decryptedCourseId = isset($cookie_form['course_id']) ? decrypt($cookie_form['course_id']) : null;
                                } else {
                                    $decryptedCourseId = null;
                                }
                            @endphp


                            @if ($decryptedCourseId == $course_id)
                                this.form = formProgress;
                                if (cookies.currentStep) {
                                    this.currentStep = parseInt(cookies.currentStep, 10);
                                }
                            @endif
                            // } else {
                            //     this.currentStep = 1;
                            // }
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
                        if (this.form.employment_type !== 'employed') {
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
        </script>
    @endsection

</x-guest-layout>
