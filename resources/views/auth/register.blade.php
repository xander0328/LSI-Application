<head>
    <title>LSI | Register</title>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .hidden {
            opacity: 0;
            transform: translateY(20px);
            visibility: hidden;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s linear 0.3s;
        }

        .visible {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s;
        }
    </style>
</head>

<x-guest-layout>
    <form id="registrationForm" method="POST" action="{{ route('submit_register') }}">
        @csrf
        <div x-data="formValidation()">
            <!-- Name -->
            <div x-cloak id="step1" x-show="currentStep === 1">
                <input type="hidden" name="role" value="guest">

                <div class="mt-4">
                    <x-input-label for="fname" :value="__('First Name')" />
                    <x-text-input x-model="firstName" @input="validateName($event, 'first name')" id="fname"
                        class="mt-1 block w-full border border-red-600" type="text" name="fname" :value="old('fname')"
                        required autofocus autocomplete="fname" />
                    {{-- <x-input-error :messages="$errors->get('fname')" class="mt-2" /> --}}
                </div>
                <div id="fnameError" x-show="fnameError" x-text="fnameError"
                    class="error rounded-md p-1 text-sm text-red-500"></div>

                <div class="mt-4">
                    <x-input-label for="mname" :value="__('Middle Name (Optional)')" />
                    <x-text-input id="mname" class="mt-1 block w-full" type="text" name="mname"
                        :value="old('mname')" autocomplete="mname" />
                    <x-input-error :messages="$errors->get('mname')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="lname" :value="__('Last Name')" />
                    <x-text-input x-model="lastName" @input="validateName($event, 'last name')" id="lname"
                        class="mt-1 block w-full" type="text" name="lname" :value="old('lname')" required
                        autocomplete="lname" />
                    {{-- <x-input-error :messages="$errors->get('lname')" class="mt-2" /> --}}
                </div>
                <div id="lnameError" x-show="lnameError" x-text="lnameError"
                    class="error rounded-md p-1 text-sm text-red-500"></div>

                <div class="mt-4 text-end">
                    <a class="mr-3 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button
                        class="rounded-md from-cyan-500 to-blue-500 px-3 py-2 font-bold text-black hover:bg-gradient-to-r hover:text-white"
                        type="button" @click="checkForm1()">Next</x-primary-button>
                </div>
            </div>

            <div id="step2" x-show="currentStep === 2">
                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input x-model="email" @input="checkEmail" id="email" class="mt-1 block w-full"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                </div>
                <div id="lnameError" x-show="emailError" x-text="emailError"
                    class="error rounded-md p-1 text-sm text-red-500"></div>

                <!-- Contact Number -->
                <div class="mt-4">
                    <x-input-label for="contact_number" :value="__('Contact Number')" />
                    <x-text-input x-model="contactNumber" @input="validateContact($event)" id="contact_number"
                        class="mt-1 block w-full" type="text" name="contact_number" :value="old('contact_number')" required
                        autocomplete="username" />
                    {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
                </div>
                <div x-show="contactError" x-text="contactError" class="error rounded-md p-1 text-sm text-red-500">
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input x-model="password" @input="validatePassword" id="password" class="mt-1 block w-full"
                        type="password" name="password" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div x-show="passwordError" x-text="passwordError" id="passwordError"
                    class="error rounded-md p-1 text-sm text-red-500"></div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input x-model="confirmPassword" @input="validateConfirmPassword" id="password_confirmation"
                        class="mt-1 block w-full" type="password" name="password_confirmation" required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div x-show="confirmPasswordError" x-text="confirmPasswordError" id="confirm_passwordError"
                    class="error rounded-md p-1 text-sm text-red-500"></div>

                <div class="mt-4 flex items-center justify-between">
                    <x-primary-button type="button" class="bg-gray-800 text-black"
                        @click="prevStep(2)">{{ __('Previous') }}</x-primary-button>

                    <div>
                        <x-primary-button type="button" @click="submitForm"
                            class="rounded-md from-cyan-500 to-blue-500 px-3 py-2 font-bold text-black hover:bg-gradient-to-r">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>

                </div>
            </div>
        </div>
    </form>

</x-guest-layout>

{{-- <script>
    function validateName() {
        var firstName = document.getElementById('fname');
        var lastName = document.getElementById('lname');
        var fnameError = document.getElementById('fnameError');
        var lnameError = document.getElementById('lnameError');

        if (firstName.value.trim() === '') {
            fnameError.textContent = 'Please enter your first name.';
            fnameError.classList.remove('hidden')
            firstName.classList.add('border-red-600')
        } else if (lastName.value.trim() === '') {
            lnameError.textContent = 'Please enter your last name.';
            lnameError.classList.remove('hidden')
            lastName.classList.add('border-red-600')

        } else {
            nextStep(1);
        }

        if (firstName.value.trim() !== '') {
            fnameError.textContent = '';
            fnameError.classList.add('hidden')
        }

        if (lastName.value.trim() !== '') {
            lnameError.textContent = '';
            lnameError.classList.add('hidden')
        }
    }

    function nextStep(step) {
        document.getElementById('step' + step).classList.remove('visible');
        document.getElementById('step' + step).classList.add('hidden');
        document.getElementById('step' + (step + 1)).classList.add('visible');
        document.getElementById('step' + (step + 1)).classList.remove('hidden');
    }

    function prevStep(step) {
        document.getElementById('step' + step).classList.remove('visible');
        document.getElementById('step' + step).classList.add('hidden');
        document.getElementById('step' + (step - 1)).classList.add('visible');
        document.getElementById('step' + (step - 1)).classList.remove('hidden');
    }

    function validatePassword() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('password_confirmation').value;
        var passwordError = document.getElementById('passwordError');
        var confirm_passwordError = document.getElementById('confirm_passwordError');

        // Regular expressions for password validation
        var lowercaseRegex = /[a-z]/;
        var numberRegex = /[0-9]/;
        var symbolRegex = /[$@$!%*?&]/;

        // Check if password meets all criteria
        if (
            password.length < 8 ||
            !lowercaseRegex.test(password) ||
            !numberRegex.test(password) ||
            !symbolRegex.test(password)
        ) {
            passwordError.textContent =
                'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, one symbol, and match the confirm password.';
            passwordError.classList.remove('hidden');
            confirm_passwordError.textContent = '';
            confirm_passwordError.classList.add('hidden');
        } else if (password !== confirmPassword) {
            confirm_passwordError.textContent = 'Confirm Password does not match';
            confirm_passwordError.classList.remove('hidden');

        } else {
            passwordError.textContent = '';
            passwordError.classList.add('hidden');
            document.getElementById('registrationForm').submit();
        }

        if (
            password.length >= 8 &&
            uppercaseRegex.test(password) &&
            lowercaseRegex.test(password) &&
            numberRegex.test(password) &&
            symbolRegex.test(password)
        ) {
            passwordError.textContent = '';
            passwordError.classList.add('hidden');
        }
    }
</script> --}}

<script>
    function formValidation() {
        return {
            firstName: '',
            lastName: '',
            email: '',
            contactNumber: '',
            password: '',
            confirmPassword: '',
            fnameError: '',
            lnameError: '',
            emailError: '',
            contactError: '',
            passwordError: '',
            confirmPasswordError: '',
            currentStep: 1,

            errorShow(inputName, error) {
                if (inputName === 'first name') {
                    this.fnameError = error
                }
                if (inputName === 'last name') {
                    this.lnameError = error
                }
            },
            validateName(event, inputName) {
                var error = event.target.value.trim() === '' ? 'Please enter your ' + inputName : '';
                this.errorShow(inputName, error);
            },
            checkForm1() {
                if (this.firstName.trim() && this.lastName.trim()) {
                    if (!this.fnameError && !this.lnameError) {
                        this.nextStep(1);
                    }
                }
                var i = !this.firstName.trim() ? this.errorShow('first name', 'Please enter your first name') : '';
                var j = !this.lastName.trim() ? this.errorShow('last name', 'Please enter your last name') : ''
            },

            async checkEmail() {
                if (this.email.trim() === '') {
                    this.emailError = 'Please enter your email.';
                    return;
                }

                const response = await fetch(`/check_email`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure you have CSRF protection
                    },
                    body: JSON.stringify({
                        email: this.email,
                    })
                });
                const data = await response.json();

                if (data.isRegistered) {
                    this.emailError = 'Email is already registered.';
                } else {
                    this.emailError = '';
                }
            },

            nextStep(step) {
                this.currentStep = step + 1;
            },

            prevStep(step) {
                this.currentStep = step - 1;
            },

            // validateContact() {
            //     this.contactNumber.replace(/\D/g, ''); // Remove non-digits
            //     if (this.contactNumber.length > 11) {
            //         this.contactNumber = this.contactNumber.slice(0, 11); // Truncate value to 11 digits
            //     } else {
            //         this.contactError = '';
            //     }
            // },

            validateContact(event) {
                const input = event.target;
                let value = input.value.trim();

                value = value.replace(/\D/g, '');

                if (value.length > 11) {
                    value = value.slice(0, 11);
                }

                this.contactNumber = value;
                input.value = value;

                this.contactError = value.length === 0 ? 'Contact number is required.' : '';
            },

            validatePassword() {
                const lowercaseRegex = /[a-z]/;
                const numberRegex = /[0-9]/;
                const symbolRegex = /[$@$!%*?&]/;

                this.passwordError = (this.password.length < 8 ||
                        !lowercaseRegex.test(this.password) ||
                        !numberRegex.test(this.password) ||
                        !symbolRegex.test(this.password)) ?
                    'Password must be at least 8 characters long and contain at least one lowercase letter, one number, and one symbol.' :
                    '';


            },

            validateConfirmPassword() {
                this.confirmPasswordError = this.password !== this.confirmPassword ?
                    'Confirm Password does not match' :
                    '';
            },

            submitForm() {
                var i = !this.contactNumber.trim() ? this.contactError = 'Please input your contact number' : (this
                    .contactNumber.trim().length < 11 ? this.contactError = 'Please input valid contact number' : ''
                );

                if (!this.passwordError && !this.confirmPasswordError && !this.emailError && !this.contactError) {
                    document.getElementById('registrationForm').submit();
                }
            }
        }
    }
</script>
