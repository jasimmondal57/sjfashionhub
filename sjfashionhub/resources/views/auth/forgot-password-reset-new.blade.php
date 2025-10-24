<x-guest-layout>
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
            Create New Password
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            Enter a strong password for your account
        </p>
    </div>

    <form method="POST" action="/forgot-password-reset-process.php">
        @csrf
        
        <!-- New Password -->
        <div class="mb-4">
            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                New Password
            </label>
            <input id="password" name="password" type="password" required 
                   class="block w-full px-3 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                   placeholder="Enter your new password">
            
            <!-- Password Strength Indicator -->
            <div class="mt-2">
                <div class="h-1 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full transition-all duration-300" id="strengthBar"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Password strength: <span id="strengthLevel">Enter a password</span>
                </p>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                Confirm Password
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" required 
                   class="block w-full px-3 py-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                   placeholder="Confirm your new password">
            <p class="text-xs mt-1" id="matchText"></p>
        </div>

        <!-- Password Requirements -->
        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-md">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Requirements:</p>
            <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                <li id="req-length" class="flex items-center">
                    <span class="w-4 h-4 mr-2">❌</span> At least 8 characters
                </li>
                <li id="req-upper" class="flex items-center">
                    <span class="w-4 h-4 mr-2">❌</span> One uppercase letter
                </li>
                <li id="req-lower" class="flex items-center">
                    <span class="w-4 h-4 mr-2">❌</span> One lowercase letter
                </li>
                <li id="req-number" class="flex items-center">
                    <span class="w-4 h-4 mr-2">❌</span> One number
                </li>
            </ul>
        </div>

        <!-- Update Password Button -->
        <div class="mb-4">
            <button type="submit" id="submitBtn" disabled
                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150 cursor-not-allowed">
                Update Password
            </button>
        </div>

        <!-- Back to Login -->
        <div class="text-center">
            <a href="/login" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                Back to Login
            </a>
        </div>
    </form>

    <!-- JavaScript -->
    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('strengthBar');
        const strengthLevel = document.getElementById('strengthLevel');
        const matchText = document.getElementById('matchText');
        const submitBtn = document.getElementById('submitBtn');

        // Password strength checker
        function checkPasswordStrength(password) {
            let score = 0;
            const requirements = {
                length: password.length >= 8,
                upper: /[A-Z]/.test(password),
                lower: /[a-z]/.test(password),
                number: /\d/.test(password)
            };

            // Update requirement indicators
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById(`req-${req}`);
                const icon = element.querySelector('span');
                if (requirements[req]) {
                    icon.textContent = '✅';
                    score++;
                } else {
                    icon.textContent = '❌';
                }
            });

            // Update strength bar and text
            if (score === 0) {
                strengthBar.className = 'h-full transition-all duration-300 bg-gray-200';
                strengthBar.style.width = '0%';
                strengthLevel.textContent = 'Enter a password';
            } else if (score <= 2) {
                strengthBar.className = 'h-full transition-all duration-300 bg-red-500';
                strengthBar.style.width = '33%';
                strengthLevel.textContent = 'Weak';
            } else if (score === 3) {
                strengthBar.className = 'h-full transition-all duration-300 bg-yellow-500';
                strengthBar.style.width = '66%';
                strengthLevel.textContent = 'Medium';
            } else {
                strengthBar.className = 'h-full transition-all duration-300 bg-green-500';
                strengthBar.style.width = '100%';
                strengthLevel.textContent = 'Strong';
            }

            return score === 4;
        }

        // Check password match
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (confirm === '') {
                matchText.textContent = '';
                return false;
            } else if (password === confirm) {
                matchText.textContent = '✅ Passwords match';
                matchText.className = 'text-xs text-green-600 dark:text-green-400 mt-1';
                return true;
            } else {
                matchText.textContent = '❌ Passwords do not match';
                matchText.className = 'text-xs text-red-600 dark:text-red-400 mt-1';
                return false;
            }
        }

        // Update submit button state
        function updateSubmitButton() {
            const isStrong = checkPasswordStrength(passwordInput.value);
            const isMatch = checkPasswordMatch();
            
            if (isStrong && isMatch) {
                submitBtn.disabled = false;
                submitBtn.className = 'w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150';
            } else {
                submitBtn.disabled = true;
                submitBtn.className = 'w-full inline-flex items-center justify-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150 cursor-not-allowed';
            }
        }

        // Event listeners
        passwordInput.addEventListener('input', updateSubmitButton);
        confirmInput.addEventListener('input', updateSubmitButton);

        // Focus on password input
        passwordInput.focus();
    </script>
</x-guest-layout>

