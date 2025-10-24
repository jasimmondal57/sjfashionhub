<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md dark:bg-green-900 dark:border-green-700">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Forgot your password?') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Choose how you'd like to receive your verification code to reset your password.
        </p>
    </div>

    <form method="POST" action="/forgot-password-process.php">
        @csrf

        <!-- Verification Method Selection -->
        <div class="mb-6">
            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-3">Verification Method</label>

            <div class="space-y-3">
                <!-- Email Option -->
                <div class="flex items-center">
                    <input id="method_email" name="method" type="radio" value="email"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700" checked>
                    <label for="method_email" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email Verification
                        </span>
                    </label>
                </div>

                <!-- Phone/SMS Option -->
                <div class="flex items-center">
                    <input id="method_phone" name="method" type="radio" value="phone"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700">
                    <label for="method_phone" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            SMS (Text Message)
                        </span>
                    </label>
                </div>

                <!-- WhatsApp Option -->
                <div class="flex items-center">
                    <input id="method_whatsapp" name="method" type="radio" value="whatsapp"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-700">
                    <label for="method_whatsapp" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.700"/>
                            </svg>
                            WhatsApp Message
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Email/Phone Input -->
        <div class="mb-6">
            <label for="identifier" id="identifierLabel" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
            <input id="identifier" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                   type="email" name="identifier" value="{{ old('identifier') }}" placeholder="Enter your email address" required autofocus />
            @error('identifier')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Send Verification Code
            </button>
        </div>
    </form>

    <!-- Back to Login -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                Back to Login
            </a>
        </p>
    </div>

    <!-- JavaScript for dynamic input -->
    <script>
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
