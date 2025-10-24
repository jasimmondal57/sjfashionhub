<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Choose how you\'d like to receive your verification code and we\'ll send you a link to reset your password.') }}
    </div>

    <!-- Method Selection -->
    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
        @csrf

        <!-- Verification Method Selection -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">
                {{ __('How would you like to receive your verification code?') }}
            </label>
            
            <div class="space-y-3">
                <!-- Email Option -->
                <div class="flex items-center">
                    <input id="method_email" name="method" type="radio" value="email" 
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                    <label for="method_email" class="ml-3 block text-sm font-medium text-gray-700">
                        📧 Email
                    </label>
                </div>

                <!-- Phone/SMS Option -->
                <div class="flex items-center">
                    <input id="method_phone" name="method" type="radio" value="phone" 
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                    <label for="method_phone" class="ml-3 block text-sm font-medium text-gray-700">
                        📱 SMS (Text Message)
                    </label>
                </div>

                <!-- WhatsApp Option -->
                <div class="flex items-center">
                    <input id="method_whatsapp" name="method" type="radio" value="whatsapp" 
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                    <label for="method_whatsapp" class="ml-3 block text-sm font-medium text-gray-700">
                        💬 WhatsApp
                    </label>
                </div>
            </div>
        </div>

        <!-- Email/Phone Input -->
        <div>
            <x-input-label for="identifier" :value="__('Email')" id="identifierLabel" />
            <x-text-input id="identifier" class="block mt-1 w-full" type="email" name="identifier" 
                         :value="old('identifier')" required autofocus placeholder="Enter your email address" />
            <x-input-error :messages="$errors->get('identifier')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send Verification Code') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>
        </div>
    </form>

    <script>
        // Update input type and placeholder based on selected method
        document.addEventListener('DOMContentLoaded', function() {
            const methodRadios = document.querySelectorAll('input[name="method"]');
            const identifierInput = document.getElementById('identifier');
            const identifierLabel = document.getElementById('identifierLabel');
            
            methodRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'email') {
                        identifierInput.type = 'email';
                        identifierInput.placeholder = 'Enter your email address';
                        identifierLabel.textContent = 'Email';
                    } else {
                        identifierInput.type = 'tel';
                        identifierInput.placeholder = 'Enter your phone number';
                        identifierLabel.textContent = 'Phone Number';
                    }
                });
            });
        });
    </script>
</x-guest-layout>
