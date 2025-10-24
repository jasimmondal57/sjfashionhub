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
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md dark:bg-red-900 dark:border-red-700">
            <div class="flex">
                <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm font-medium text-red-800">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.verify-otp.submit') }}" id="otpForm">
            @csrf
            
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                    Enter 6-digit verification code
                </label>
                <input id="otp" name="otp" type="text" maxlength="6" required 
                       class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 text-center text-lg font-mono tracking-widest focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10" 
                       placeholder="000000"
                       autocomplete="one-time-code">
            </div>

            <div>
                <button type="submit" id="verifyBtn" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    Verify Code
                </button>
            </div>

            <!-- Resend OTP -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Didn't receive the code?
                </p>
                <button type="button" id="resendBtn" class="mt-2 font-medium text-blue-600 hover:text-blue-500 transition duration-150 ease-in-out disabled:text-gray-400 disabled:cursor-not-allowed">
                    <span id="resendText">Resend Code</span>
                    <span id="resendTimer" class="hidden">Resend in <span id="countdown">60</span>s</span>
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('password.request') }}" class="font-medium text-gray-600 hover:text-gray-500 transition duration-150 ease-in-out">
                    ← Use different method
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    const resendBtn = document.getElementById('resendBtn');
    const resendText = document.getElementById('resendText');
    const resendTimer = document.getElementById('resendTimer');
    const countdown = document.getElementById('countdown');
    
    let resendTimeout;
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
        
        fetch('{{ route('password.resend-otp') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'rounded-md bg-green-50 p-4 mb-4';
                successDiv.innerHTML = `
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">${data.message}</p>
                        </div>
                    </div>
                `;
                
                // Remove existing success messages
                const existingSuccess = document.querySelector('.bg-green-50');
                if (existingSuccess) {
                    existingSuccess.remove();
                }
                
                // Insert new success message
                document.querySelector('form').insertAdjacentElement('beforebegin', successDiv);
                
                // Clear OTP input
                otpInput.value = '';
                otpInput.focus();
                
                // Restart timer
                startResendTimer();
                
                // Remove success message after 5 seconds
                setTimeout(() => {
                    successDiv.remove();
                }, 5000);
            } else {
                alert(data.message || 'Failed to resend code. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to resend code. Please try again.');
        });
    });
});
</script>
@endsection
