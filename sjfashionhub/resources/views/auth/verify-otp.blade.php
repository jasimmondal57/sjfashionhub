<x-guest-layout>
    <div class="text-center mb-6">
        <!-- Verification Icon -->
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
            Verify Your {{ ucfirst($type) }}
        </h2>
        
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            We've sent a 6-digit verification code to<br>
            <span class="font-medium text-gray-900 dark:text-gray-100">
                @if($type === 'email')
                    {{ $identifier }}
                @else
                    {{ substr($identifier, 0, 3) . '****' . substr($identifier, -2) }}
                @endif
            </span>
            @if($method)
                via {{ ucfirst($method) }}
            @endif
        </p>
    </div>

    <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
        @csrf

        <!-- OTP Input -->
        <div class="mb-6">
            <x-input-label for="otp" :value="__('Enter Verification Code')" />
            <div class="flex justify-center mt-2">
                <input type="text" 
                       id="otp" 
                       name="otp" 
                       maxlength="6" 
                       pattern="[0-9]{6}"
                       class="text-center text-2xl font-bold tracking-widest w-full max-w-xs border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                       placeholder="000000"
                       autocomplete="one-time-code"
                       required 
                       autofocus>
            </div>
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="mb-6">
            <x-primary-button class="w-full justify-center" id="verifyBtn">
                {{ __('Verify Code') }}
            </x-primary-button>
        </div>

        <!-- Resend Section -->
        <div class="text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                Didn't receive the code?
            </p>
            
            <div class="space-y-2">
                <form method="POST" action="{{ route('otp.resend') }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium"
                            id="resendBtn">
                        Resend Code
                    </button>
                </form>
                
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    <span id="countdown"></span>
                </div>
            </div>
        </div>

        <!-- Back to Registration -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
            <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300">
                ← Back to Registration
            </a>
        </div>
    </form>

    <script>
        // Auto-format OTP input
        document.getElementById('otp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            e.target.value = value;
            
            // Auto-submit when 6 digits entered
            if (value.length === 6) {
                document.getElementById('otpForm').submit();
            }
        });

        // Countdown timer for resend
        let countdown = 60;
        const countdownElement = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');
        
        function updateCountdown() {
            if (countdown > 0) {
                countdownElement.textContent = `Resend available in ${countdown}s`;
                resendBtn.disabled = true;
                resendBtn.classList.add('opacity-50', 'cursor-not-allowed');
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                countdownElement.textContent = '';
                resendBtn.disabled = false;
                resendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        
        // Start countdown
        updateCountdown();

        // Form validation
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            const otp = document.getElementById('otp').value;
            const verifyBtn = document.getElementById('verifyBtn');
            
            if (otp.length !== 6) {
                e.preventDefault();
                alert('Please enter a 6-digit verification code');
                return;
            }
            
            // Show loading state
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = 'Verifying...';
        });

        // Auto-focus on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('otp').focus();
        });
    </script>
</x-guest-layout>
