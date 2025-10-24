<x-guest-layout>
    <!-- Success Messages -->
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

    <!-- Error Messages -->
    @if (isset($error) && $error)
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md dark:bg-red-900 dark:border-red-700">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800 dark:text-red-200">{{ $error }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
            Verify Your Code
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            We sent a verification code to your 
            @if($method === 'email')
                <span class="font-medium">email address</span>
            @elseif($method === 'whatsapp')
                <span class="font-medium">WhatsApp</span>
            @else
                <span class="font-medium">phone number</span>
            @endif
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ $method === 'email' ? $identifier : '***' . substr($identifier, -4) }}
        </p>
    </div>

    <form method="POST" action="/forgot-password-verify-process.php" id="otpForm">
        @csrf
        
        <!-- OTP Input -->
        <div class="mb-6">
            <label for="otp" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                Enter 6-digit verification code
            </label>
            <input id="otp" name="otp" type="text" maxlength="6" required 
                   class="block w-full px-4 py-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-center text-lg font-mono tracking-widest" 
                   placeholder="000000"
                   autocomplete="one-time-code">
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            <button type="submit" id="verifyBtn" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Verify Code
            </button>
        </div>

        <!-- Resend OTP -->
        <div class="text-center mb-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Didn't receive the code?
            </p>
            <button type="button" id="resendBtn" class="mt-2 font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition duration-150 ease-in-out disabled:text-gray-400 disabled:cursor-not-allowed">
                <span id="resendText">Resend Code</span>
                <span id="resendTimer" class="hidden">Resend in <span id="countdown">60</span>s</span>
            </button>
        </div>

        <!-- Back Link -->
        <div class="text-center">
            <a href="/forgot-password" class="text-sm font-medium text-gray-600 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300">
                ← Use different method
            </a>
        </div>
    </form>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.getElementById('otp');
            const resendBtn = document.getElementById('resendBtn');
            const resendText = document.getElementById('resendText');
            const resendTimer = document.getElementById('resendTimer');
            const countdown = document.getElementById('countdown');
            
            let countdownInterval;
            
            // Auto-focus OTP input
            otpInput.focus();
            
            // Only allow numbers in OTP input
            otpInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                
                // Auto-submit when 6 digits are entered
                if (this.value.length === 6) {
                    document.getElementById('otpForm').submit();
                }
            });
            
            // Start resend timer
            function startResendTimer() {
                let timeLeft = 60;
                resendBtn.disabled = true;
                resendText.classList.add('hidden');
                resendTimer.classList.remove('hidden');
                
                countdownInterval = setInterval(function() {
                    timeLeft--;
                    countdown.textContent = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        resendBtn.disabled = false;
                        resendText.classList.remove('hidden');
                        resendTimer.classList.add('hidden');
                    }
                }, 1000);
            }
            
            // Start timer on page load
            startResendTimer();
            
            // Handle resend OTP
            resendBtn.addEventListener('click', function() {
                if (this.disabled) return;
                
                // Reload the page to resend
                window.location.href = '/forgot-password?success=' + encodeURIComponent('Please request a new code');
            });
        });
    </script>
</x-guest-layout>

