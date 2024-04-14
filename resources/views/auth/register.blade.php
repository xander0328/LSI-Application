<head>
    <title>LSI | Register</title>
    <style>
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
    <form id="registrationForm" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div id="step1" class="visible">
            <input type="hidden" name="role" value="student">
            <div class="mt-4">
                <x-input-label for="fname" :value="__('First Name')" />
                <x-text-input id="fname" class="mt-1 block w-full border border-red-600" type="text" name="fname"
                    :value="old('fname')" required autofocus autocomplete="fname" />
                <x-input-error :messages="$errors->get('fname')" class="mt-2" />
            </div>
            <div id="fnameError" class="error mt-2 hidden rounded-md bg-gray-700 p-1 text-red-400"></div>

            <div class="mt-4">
                <x-input-label for="mname" :value="__('Middle Name (Optional)')" />
                <x-text-input id="mname" class="mt-1 block w-full" type="text" name="mname" :value="old('mname')"
                    autocomplete="mname" />
                <x-input-error :messages="$errors->get('mname')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="lname" :value="__('Last Name')" />
                <x-text-input id="lname" class="mt-1 block w-full" type="text" name="lname" :value="old('lname')"
                    required autocomplete="lname" />
                <x-input-error :messages="$errors->get('lname')" class="mt-2" />
            </div>
            <div id="lnameError" class="error mt-2 hidden rounded-md bg-gray-700 p-1 text-red-400"></div>

            <div class="mt-4 text-end">
                <a class="mr-3 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button
                    class="rounded-md from-cyan-500 to-blue-500 px-3 py-2 font-bold text-black hover:bg-gradient-to-r"
                    type="button" onclick="validateName()">Next</x-primary-button>
            </div>
        </div>

        <div id="step2" class="hidden">
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div id="passwordError" class="error m m-2 hidden rounded-md bg-gray-700 text-red-400"></div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <div id="confirm_passwordError" class="error hidden rounded-md bg-gray-800 text-red-400"></div>

            <div class="mt-4 flex items-center justify-between">
                <x-primary-button type="button" class="bg-gray-800 text-black"
                    onclick="prevStep(2)">{{ __('Previous') }}</x-primary-button>

                <div>
                    <x-primary-button type="button" onclick="validatePassword()"
                        class="rounded-md from-cyan-500 to-blue-500 px-3 py-2 font-bold text-black hover:bg-gradient-to-r">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>

            </div>
        </div>
    </form>

</x-guest-layout>

<script>
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
        var uppercaseRegex = /[A-Z]/;
        var lowercaseRegex = /[a-z]/;
        var numberRegex = /[0-9]/;
        var symbolRegex = /[$@$!%*?&]/;

        // Check if password meets all criteria
        if (
            password.length < 8 ||
            !uppercaseRegex.test(password) ||
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
</script>
