<x-guest-layout>
    <!-- Error Messages -->
    @if($error)
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ $error }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Test Mode Notice (for development) -->
    @if($testOtp)
        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-800">
                        <strong>Test Mode:</strong> Your verification code is: <strong>{{ $testOtp }}</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            {{ __('Verify Your Code') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            We sent a 6-digit verification code to your {{ $method === 'email' ? 'email' : 'phone' }}
        </p>
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">
            {{ $identifier }}
        </p>
    </div>

    <form method="POST" action="forgot-password-verify-production-process.php">
        @csrf
        
        <!-- OTP Input -->
        <div class="mb-6">
            <x-input-label for="otp" :value="__('Verification Code')" />
            <x-text-input id="otp" class="block mt-1 w-full text-center text-2xl tracking-widest" 
                         type="text" name="otp" maxlength="6" required autofocus 
                         placeholder="000000" autocomplete="off" :value="$testOtp ?? ''" />
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Enter the 6-digit code sent to your {{ $method === 'email' ? 'email' : 'phone' }}
            </p>
        </div>

        <!-- Verify Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Verify Code') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Resend Code -->
    <div class="mt-4 text-center">
        <button type="button" onclick="resendCode()" 
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
            Didn't receive the code? Resend
        </button>
    </div>

    <!-- Back to Forgot Password -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Want to try a different method?
            <a href="forgot-password-production.php" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                Back to Forgot Password
            </a>
        </p>
    </div>

    <!-- JavaScript -->
    <script>
        // Auto-focus on OTP input
        document.getElementById('otp').focus();
        
        // Auto-submit when 6 digits are entered
        document.getElementById('otp').addEventListener('input', function(e) {
            const value = e.target.value.replace(/\D/g, ''); // Only digits
            e.target.value = value;
            
            if (value.length === 6) {
                // Auto-submit after a short delay
                setTimeout(() => {
                    e.target.form.submit();
                }, 500);
            }
        });
        
        // Resend code function
        function resendCode() {
            if (confirm('Resend verification code?')) {
                window.location.href = 'forgot-password-production-process.php?resend=1';
            }
        }
    </script>
</x-guest-layout>
