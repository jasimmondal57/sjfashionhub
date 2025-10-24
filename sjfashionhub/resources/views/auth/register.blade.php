<x-guest-layout>
    @php
        // Get enabled authentication methods
        $emailEnabled = \App\Models\AuthenticationSetting::isMethodEnabled('email');
        $smsEnabled = \App\Models\AuthenticationSetting::isMethodEnabled('mobile_sms');
        $whatsappEnabled = \App\Models\AuthenticationSetting::isMethodEnabled('mobile_whatsapp');

        // Get enabled social providers
        $googleEnabled = \App\Models\SocialLoginSetting::isProviderEnabled('google');
        $facebookEnabled = \App\Models\SocialLoginSetting::isProviderEnabled('facebook');

        // Check if any OTP method is enabled
        $otpEnabled = $smsEnabled || $whatsappEnabled;
    @endphp

    @if($emailEnabled)
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name *')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email *')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
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
                <x-text-input id="phone" class="block w-full rounded-l-none" type="tel" name="phone" :value="old('phone')"
                             placeholder="Enter mobile number" required maxlength="15" autocomplete="tel" />
            </div>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            <x-input-error :messages="$errors->get('country_code')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password *')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Password must be at least 8 characters long
            </p>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password *')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Verification Method -->
        <div class="mt-4">
            <x-input-label for="verification_method" :value="__('Verify Account Via *')" />
            <div class="mt-2 space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="verification_method" value="phone"
                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                           {{ old('verification_method', 'phone') == 'phone' ? 'checked' : '' }} required>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">📱 Phone Number (SMS/WhatsApp)</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="verification_method" value="email"
                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                           {{ old('verification_method') == 'email' ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">📧 Email Address</span>
                </label>
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Choose how you'd like to receive your verification code
            </p>
            <x-input-error :messages="$errors->get('verification_method')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Register & Verify') }}
            </x-primary-button>
        </div>
    </form>
    @endif

    <!-- Social Registration Options -->
    @if($googleEnabled || $facebookEnabled)
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Or register with</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            <!-- Google Registration -->
            @if($googleEnabled)
            <a href="{{ route('social.redirect.google') }}"
               class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Google
            </a>
            @endif

            <!-- Facebook Registration -->
            @if($facebookEnabled)
            <a href="{{ route('social.redirect.facebook') }}"
               class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                <svg class="w-5 h-5 mr-2" fill="#1877F2" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                Facebook
            </a>
            @endif
        </div>
    </div>
    @endif

    <!-- Login Link -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                Sign in here
            </a>
        </p>
    </div>

    <script>
        // Phone number validation based on country code
        document.getElementById('country_code').addEventListener('change', function() {
            const phone = document.getElementById('phone');
            const countryCode = this.value;

            // Set placeholder and maxlength based on country
            switch(countryCode) {
                case '+91': // India
                    phone.placeholder = 'Enter 10-digit mobile number';
                    phone.maxLength = 10;
                    break;
                case '+1': // USA
                    phone.placeholder = 'Enter 10-digit phone number';
                    phone.maxLength = 10;
                    break;
                case '+44': // UK
                    phone.placeholder = 'Enter 10-11 digit phone number';
                    phone.maxLength = 11;
                    break;
                default:
                    phone.placeholder = 'Enter mobile number';
                    phone.maxLength = 15;
            }
        });

        // Auto-format phone number input (numbers only)
        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            let errors = [];

            // Validate name
            if (name.length < 2) {
                errors.push('Name must be at least 2 characters long');
            }

            // Validate email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errors.push('Please enter a valid email address');
            }

            // Validate phone
            const countryCode = document.getElementById('country_code').value;
            if (countryCode === '+91' && phone.length !== 10) {
                errors.push('Indian mobile number must be exactly 10 digits');
            } else if (phone.length < 7) {
                errors.push('Phone number must be at least 7 digits');
            }

            // Validate password
            if (password.length < 8) {
                errors.push('Password must be at least 8 characters long');
            }

            if (password !== passwordConfirmation) {
                errors.push('Passwords do not match');
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
