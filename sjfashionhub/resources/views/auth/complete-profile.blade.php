<x-guest-layout>
    <div class="text-center mb-6">
        <!-- Profile Icon -->
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900 mb-4">
            <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
            Complete Your Profile
        </h2>
        
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
            Welcome! Please complete your profile to finish setting up your account.
        </p>

        <!-- Social Provider Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-6">
            <p class="text-sm text-blue-800 dark:text-blue-200">
                <span class="font-medium">Connected via {{ ucfirst($provider) }}</span>
                @if(!empty($socialData['email']))
                    <br>{{ $socialData['email'] }}
                @endif
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('profile.complete') }}">
        @csrf

        <!-- Name (only show if not provided by social) -->
        @if(empty($socialData['name']))
        <div class="mb-4">
            <x-input-label for="name" :value="__('Full Name *')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        @else
        <div class="mb-4">
            <x-input-label for="name" :value="__('Full Name')" />
            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md">
                <span class="text-gray-900 dark:text-gray-100">{{ $socialData['name'] }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(from {{ ucfirst($provider) }})</span>
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Want to use a different name? 
                <button type="button" onclick="toggleNameEdit()" class="text-indigo-600 hover:text-indigo-500">Edit</button>
            </p>
            <div id="nameEditField" class="hidden mt-2">
                <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name', $socialData['name'])" autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>
        @endif

        <!-- Email (only show if not provided by social) -->
        @if(empty($socialData['email']))
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email Address *')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        @else
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md">
                <span class="text-gray-900 dark:text-gray-100">{{ $socialData['email'] }}</span>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(from {{ ucfirst($provider) }})</span>
            </div>
        </div>
        @endif

        <!-- Phone Number (always required) -->
        <div class="mb-4">
            <x-input-label for="phone" :value="__('Phone Number *')" />
            <div class="flex mt-1">
                <select name="country_code" id="country_code" class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="+91" {{ old('country_code', '+91') == '+91' ? 'selected' : '' }}>🇮🇳 +91</option>
                    <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                    <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                    <option value="+971" {{ old('country_code') == '+971' ? 'selected' : '' }}>🇦🇪 +971</option>
                    <option value="+966" {{ old('country_code') == '+966' ? 'selected' : '' }}>🇸🇦 +966</option>
                    <option value="+65" {{ old('country_code') == '+65' ? 'selected' : '' }}>🇸🇬 +65</option>
                    <option value="+60" {{ old('country_code') == '+60' ? 'selected' : '' }}>🇲🇾 +60</option>
                    <option value="+61" {{ old('country_code') == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                    <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>🇩🇪 +49</option>
                    <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>🇫🇷 +33</option>
                </select>
                <x-text-input id="phone" class="flex-1 rounded-l-none" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="Enter your phone number" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Required for order updates and account security
            </p>
        </div>

        <!-- Password (optional for social signups) -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Set Password (Optional)')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Leave blank to use {{ ucfirst($provider) }} login only. You can set a password later.
            </p>
        </div>

        <!-- Password Confirmation (only show if password is entered) -->
        <div class="mb-4" id="passwordConfirmField" style="display: none;">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Verification Method -->
        <div class="mb-6">
            <x-input-label for="verification_method" :value="__('Verify Account Via *')" />
            <div class="mt-2 space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="verification_method" value="phone" 
                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" 
                           {{ old('verification_method', 'phone') == 'phone' ? 'checked' : '' }} required>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">📱 Phone Number (SMS/WhatsApp)</span>
                </label>
                @if(!empty($socialData['email']))
                <label class="flex items-center">
                    <input type="radio" name="verification_method" value="email" 
                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" 
                           {{ old('verification_method') == 'email' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">📧 Email Address</span>
                </label>
                @endif
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Choose how you'd like to receive your verification code
            </p>
            <x-input-error :messages="$errors->get('verification_method')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300">
                ← Back to Login
            </a>
            
            <x-primary-button>
                {{ __('Complete Profile & Verify') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Toggle name edit field
        function toggleNameEdit() {
            const editField = document.getElementById('nameEditField');
            editField.classList.toggle('hidden');
            if (!editField.classList.contains('hidden')) {
                document.getElementById('name').focus();
            }
        }

        // Show/hide password confirmation based on password input
        document.getElementById('password').addEventListener('input', function() {
            const confirmField = document.getElementById('passwordConfirmField');
            if (this.value.length > 0) {
                confirmField.style.display = 'block';
                document.getElementById('password_confirmation').required = true;
            } else {
                confirmField.style.display = 'none';
                document.getElementById('password_confirmation').required = false;
                document.getElementById('password_confirmation').value = '';
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value.trim();
            const countryCode = document.getElementById('country_code').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            let errors = [];

            // Validate phone
            if (countryCode === '+91' && phone.length !== 10) {
                errors.push('Indian mobile number must be exactly 10 digits');
            } else if (phone.length < 7) {
                errors.push('Phone number must be at least 7 digits');
            }

            // Validate password if provided
            if (password.length > 0) {
                if (password.length < 8) {
                    errors.push('Password must be at least 8 characters long');
                }
                if (password !== passwordConfirmation) {
                    errors.push('Passwords do not match');
                }
            }

            // Show errors if any
            if (errors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
                return false;
            }
        });
    </script>
</x-guest-layout>
