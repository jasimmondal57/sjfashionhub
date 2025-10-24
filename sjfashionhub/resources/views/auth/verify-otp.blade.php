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
                <button type="button"
                        onclick="resendOtp()"
                        class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium"
                        id="resendBtn">
                    Resend Code
                </button>

                <div class="text-xs text-gray-500 dark:text-gray-400">
                    <span id="countdown"></span>
                </div>

                <div id="resendMessage" class="text-xs hidden"></div>
            </div>
        </div>

        <!-- Back to Registration -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
            <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300">
                ← Back to Registration
            </a>
        </div>
    </form>

    <!-- OTP Verification Loading Popup -->
    <div id="otp-loading-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-8 max-w-sm mx-4 text-center animate-popup-in">
            <!-- Animated Spinner -->
            <div class="mb-6 flex justify-center">
                <div class="relative w-20 h-20">
                    <div class="absolute inset-0 rounded-full border-4 border-gray-100 dark:border-gray-700 animate-spin-slow"></div>
                    <div class="absolute inset-2 rounded-full border-2 border-blue-600 dark:border-blue-400 animate-pulse"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-3 h-3 bg-blue-600 dark:bg-blue-400 rounded-full animate-bounce-slow"></div>
                    </div>
                </div>
            </div>

            <!-- Loading Text -->
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 animate-fade-in" style="animation-delay: 0.2s;">Verifying Code...</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm animate-fade-in" style="animation-delay: 0.4s;">Please wait while we verify your code</p>

            <!-- Animated Dots -->
            <div class="mt-4 flex justify-center space-x-1">
                <span class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0s;"></span>
                <span class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></span>
                <span class="w-2 h-2 bg-blue-600 dark:bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.4s;"></span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1 overflow-hidden">
                <div class="bg-blue-600 dark:bg-blue-400 h-full animate-progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Loading Popup Styles -->
    <style>
        @keyframes popup-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce-slow {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        @keyframes progress-bar {
            0% {
                opacity: 0.3;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.3;
            }
        }

        .animate-popup-in {
            animation: popup-in 0.4s ease-out;
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        .animate-bounce-slow {
            animation: bounce-slow 1.5s ease-in-out infinite;
        }

        .animate-progress-bar {
            animation: progress-bar 1.5s ease-in-out infinite;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
    </style>

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
        const resendMessage = document.getElementById('resendMessage');

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

        // Resend OTP function
        function resendOtp() {
            if (resendBtn.disabled) return;

            // Show loading state
            resendBtn.disabled = true;
            resendBtn.textContent = 'Sending...';
            resendMessage.classList.add('hidden');

            // Make AJAX request
            fetch('{{ route("otp.resend") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    resendMessage.textContent = data.message;
                    resendMessage.className = 'text-xs text-green-600 dark:text-green-400';
                    resendMessage.classList.remove('hidden');

                    // Reset countdown
                    countdown = 60;
                    updateCountdown();
                } else {
                    // Show error message
                    resendMessage.textContent = data.message;
                    resendMessage.className = 'text-xs text-red-600 dark:text-red-400';
                    resendMessage.classList.remove('hidden');

                    // If there's remaining time, update countdown
                    if (data.remaining_time) {
                        countdown = data.remaining_time;
                        updateCountdown();
                    } else {
                        resendBtn.disabled = false;
                        resendBtn.textContent = 'Resend Code';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resendMessage.textContent = 'Failed to resend code. Please try again.';
                resendMessage.className = 'text-xs text-red-600 dark:text-red-400';
                resendMessage.classList.remove('hidden');

                resendBtn.disabled = false;
                resendBtn.textContent = 'Resend Code';
            });
        }

        // Form validation
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            const otp = document.getElementById('otp').value;
            const verifyBtn = document.getElementById('verifyBtn');
            const loadingPopup = document.getElementById('otp-loading-popup');

            if (otp.length !== 6) {
                e.preventDefault();
                alert('Please enter a 6-digit verification code');
                return;
            }

            // Show loading popup
            loadingPopup.classList.remove('hidden');
            verifyBtn.disabled = true;
        });

        // Auto-focus on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('otp').focus();
        });
    </script>
</x-guest-layout>
