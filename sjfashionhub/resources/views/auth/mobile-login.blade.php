<x-guest-layout>
    @php
        // Get enabled OTP methods
        $smsEnabled = \App\Models\AuthenticationSetting::isMethodEnabled('mobile_sms');
        $whatsappEnabled = \App\Models\AuthenticationSetting::isMethodEnabled('mobile_whatsapp');

        // Determine default method
        $defaultMethod = $whatsappEnabled ? 'whatsapp' : 'sms';
    @endphp

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Enter your mobile number to receive an OTP for quick login.
    </div>

    <form id="mobileLoginForm">
        @csrf

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone" :value="__('Mobile Number')" />
            <div class="flex mt-1">
                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    +91
                </span>
                <x-text-input id="phone" class="block w-full rounded-l-none" type="tel" name="phone"
                             placeholder="Enter 10-digit mobile number" required maxlength="10" />
            </div>
            <div id="phoneError" class="mt-2 text-sm text-red-600 hidden"></div>
        </div>

        <!-- OTP Type Selection -->
        @if($smsEnabled || $whatsappEnabled)
        <div class="mt-4">
            <x-input-label :value="__('Receive OTP via')" />
            <div class="mt-2 space-y-2">
                @if($smsEnabled)
                <label class="inline-flex items-center">
                    <input type="radio" name="type" value="sms" {{ $defaultMethod === 'sms' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">📱 SMS</span>
                </label>
                @endif
                @if($whatsappEnabled)
                <label class="inline-flex items-center {{ $smsEnabled ? 'ml-6' : '' }}">
                    <input type="radio" name="type" value="whatsapp" {{ $defaultMethod === 'whatsapp' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">💬 WhatsApp</span>
                </label>
                @endif
            </div>
        </div>
        @else
        <input type="hidden" name="type" value="sms">
        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
            <p class="text-sm text-yellow-700 dark:text-yellow-300">
                ⚠️ OTP methods are not configured. Please contact administrator.
            </p>
        </div>
        @endif

        <div class="flex items-center justify-end mt-6">
            <button type="submit" id="sendOtpBtn" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm font-medium shadow-lg border border-indigo-500">
                📱 Send OTP
            </button>
        </div>
    </form>

    <!-- OTP Verification Form (Hidden initially) -->
    <form id="otpVerificationForm" class="hidden mt-6">
        @csrf
        <input type="hidden" id="verifyPhone" name="phone">
        
        <div>
            <x-input-label for="otp" :value="__('Enter OTP')" />
            <x-text-input id="otp" class="block mt-1 w-full text-center text-lg tracking-widest" 
                         type="text" name="otp" placeholder="000000" required maxlength="6" />
            <div id="otpError" class="mt-2 text-sm text-red-600 hidden"></div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                OTP sent to <span id="sentToNumber" class="font-medium"></span> via <span id="sentVia" class="font-medium"></span>
            </p>
            <p class="text-xs text-gray-500 mt-1">
                OTP expires in <span id="countdown" class="font-medium text-red-600">10:00</span>
            </p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <button type="button" id="resendOtpBtn" 
                    class="text-sm text-indigo-600 hover:text-indigo-500 disabled:text-gray-400 disabled:cursor-not-allowed">
                🔄 Resend OTP
            </button>
            
            <button type="submit" id="verifyOtpBtn"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium shadow-lg border border-green-500">
                ✅ Verify & Login
            </button>
        </div>
    </form>

    <!-- Back to Email Login -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Prefer email login?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                Use Email & Password
            </a>
        </p>
    </div>

    <!-- Register Link -->
    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                Create one here
            </a>
        </p>
    </div>

    <!-- Mobile Login Loading Popup -->
    <div id="mobile-loading-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-8 max-w-sm mx-4 text-center animate-popup-in">
            <!-- Animated Spinner -->
            <div class="mb-6 flex justify-center">
                <div class="relative w-20 h-20">
                    <div class="absolute inset-0 rounded-full border-4 border-gray-100 dark:border-gray-700 animate-spin-slow"></div>
                    <div class="absolute inset-2 rounded-full border-2 border-indigo-600 dark:border-indigo-400 animate-pulse"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-3 h-3 bg-indigo-600 dark:bg-indigo-400 rounded-full animate-bounce-slow"></div>
                    </div>
                </div>
            </div>

            <!-- Loading Text -->
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 animate-fade-in" style="animation-delay: 0.2s;">Sending OTP...</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm animate-fade-in" style="animation-delay: 0.4s;">Please wait while we send your verification code</p>

            <!-- Animated Dots -->
            <div class="mt-4 flex justify-center space-x-1">
                <span class="w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0s;"></span>
                <span class="w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></span>
                <span class="w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.4s;"></span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1 overflow-hidden">
                <div class="bg-indigo-600 dark:bg-indigo-400 h-full animate-progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- OTP Verification Loading Popup -->
    <div id="otp-verify-loading-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-8 max-w-sm mx-4 text-center animate-popup-in">
            <!-- Animated Spinner -->
            <div class="mb-6 flex justify-center">
                <div class="relative w-20 h-20">
                    <div class="absolute inset-0 rounded-full border-4 border-gray-100 dark:border-gray-700 animate-spin-slow"></div>
                    <div class="absolute inset-2 rounded-full border-2 border-green-600 dark:border-green-400 animate-pulse"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-3 h-3 bg-green-600 dark:bg-green-400 rounded-full animate-bounce-slow"></div>
                    </div>
                </div>
            </div>

            <!-- Loading Text -->
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 animate-fade-in" style="animation-delay: 0.2s;">Verifying OTP...</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm animate-fade-in" style="animation-delay: 0.4s;">Please wait while we verify your code and log you in</p>

            <!-- Animated Dots -->
            <div class="mt-4 flex justify-center space-x-1">
                <span class="w-2 h-2 bg-green-600 dark:bg-green-400 rounded-full animate-bounce" style="animation-delay: 0s;"></span>
                <span class="w-2 h-2 bg-green-600 dark:bg-green-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></span>
                <span class="w-2 h-2 bg-green-600 dark:bg-green-400 rounded-full animate-bounce" style="animation-delay: 0.4s;"></span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1 overflow-hidden">
                <div class="bg-green-600 dark:bg-green-400 h-full animate-progress-bar" style="width: 100%;"></div>
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
        let countdownTimer;
        let resendTimeout;

        document.getElementById('mobileLoginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const phone = document.getElementById('phone').value;
            const type = document.querySelector('input[name="type"]:checked').value;
            const sendBtn = document.getElementById('sendOtpBtn');
            const loadingPopup = document.getElementById('mobile-loading-popup');

            // Validate phone number
            if (!/^[0-9]{10}$/.test(phone)) {
                showError('phoneError', 'Please enter a valid 10-digit mobile number');
                return;
            }

            // Show loading popup
            loadingPopup.classList.remove('hidden');
            sendBtn.disabled = true;

            try {
                const response = await fetch('{{ route("mobile.send-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ phone, type })
                });

                const data = await response.json();

                if (data.success) {
                    showOtpForm(phone, type);
                    startCountdown();
                } else {
                    showError('phoneError', data.message);
                    loadingPopup.classList.add('hidden');
                }
            } catch (error) {
                showError('phoneError', 'Network error. Please try again.');
                loadingPopup.classList.add('hidden');
            } finally {
                sendBtn.disabled = false;
            }
        });

        document.getElementById('otpVerificationForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const phone = document.getElementById('verifyPhone').value;
            const otp = document.getElementById('otp').value;
            const verifyBtn = document.getElementById('verifyOtpBtn');
            const loadingPopup = document.getElementById('otp-verify-loading-popup');

            if (!/^[0-9]{6}$/.test(otp)) {
                showError('otpError', 'Please enter a valid 6-digit OTP');
                return;
            }

            // Show loading popup
            loadingPopup.classList.remove('hidden');
            verifyBtn.disabled = true;

            try {
                const response = await fetch('{{ route("mobile.verify-otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ phone, otp })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = data.redirect || '/';
                } else {
                    showError('otpError', data.message);
                    loadingPopup.classList.add('hidden');
                }
            } catch (error) {
                showError('otpError', 'Network error. Please try again.');
                loadingPopup.classList.add('hidden');
            } finally {
                verifyBtn.disabled = false;
            }
        });

        function showOtpForm(phone, type) {
            document.getElementById('mobileLoginForm').classList.add('hidden');
            document.getElementById('otpVerificationForm').classList.remove('hidden');
            document.getElementById('verifyPhone').value = phone;
            document.getElementById('sentToNumber').textContent = '+91 ' + phone;
            document.getElementById('sentVia').textContent = type === 'whatsapp' ? 'WhatsApp' : 'SMS';
            document.getElementById('otp').focus();
        }

        function startCountdown() {
            let timeLeft = 600; // 10 minutes
            const countdownEl = document.getElementById('countdown');
            const resendBtn = document.getElementById('resendOtpBtn');
            
            resendBtn.disabled = true;
            
            countdownTimer = setInterval(() => {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                countdownEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    countdownEl.textContent = 'Expired';
                    resendBtn.disabled = false;
                }
                
                timeLeft--;
            }, 1000);
            
            // Enable resend after 30 seconds
            resendTimeout = setTimeout(() => {
                resendBtn.disabled = false;
            }, 30000);
        }

        function showError(elementId, message) {
            const errorEl = document.getElementById(elementId);
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
            setTimeout(() => errorEl.classList.add('hidden'), 5000);
        }

        // Resend OTP functionality
        document.getElementById('resendOtpBtn').addEventListener('click', function() {
            document.getElementById('otpVerificationForm').classList.add('hidden');
            document.getElementById('mobileLoginForm').classList.remove('hidden');
            document.getElementById('otp').value = '';
            clearInterval(countdownTimer);
            clearTimeout(resendTimeout);
        });

        // Auto-format phone number input
        document.getElementById('phone').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Auto-format OTP input
        document.getElementById('otp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</x-guest-layout>
