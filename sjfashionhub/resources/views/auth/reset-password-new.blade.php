@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create New Password
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Your identity has been verified. Please create a new secure password.
            </p>
        </div>

        @if ($errors->any())
            <div class="rounded-md bg-red-50 p-4">
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

        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.reset.submit') }}" id="resetPasswordForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="space-y-4">
                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        New Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" required 
                               class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                               placeholder="Enter new password"
                               minlength="8">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                            <svg class="h-5 w-5 text-gray-400" id="password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters long</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirm New Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                               class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm" 
                               placeholder="Confirm new password"
                               minlength="8">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                            <svg class="h-5 w-5 text-gray-400" id="password_confirmation-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Strength Indicator -->
            <div class="mt-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-medium text-gray-700">Password Strength</span>
                    <span id="strength-text" class="text-xs text-gray-500">Weak</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="strength-bar" class="bg-red-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="mt-4 p-3 bg-gray-50 rounded-md">
                <p class="text-xs font-medium text-gray-700 mb-2">Password must contain:</p>
                <ul class="text-xs text-gray-600 space-y-1">
                    <li id="req-length" class="flex items-center">
                        <span class="w-4 h-4 mr-2">❌</span>
                        At least 8 characters
                    </li>
                    <li id="req-uppercase" class="flex items-center">
                        <span class="w-4 h-4 mr-2">❌</span>
                        One uppercase letter
                    </li>
                    <li id="req-lowercase" class="flex items-center">
                        <span class="w-4 h-4 mr-2">❌</span>
                        One lowercase letter
                    </li>
                    <li id="req-number" class="flex items-center">
                        <span class="w-4 h-4 mr-2">❌</span>
                        One number
                    </li>
                    <li id="req-match" class="flex items-center">
                        <span class="w-4 h-4 mr-2">❌</span>
                        Passwords match
                    </li>
                </ul>
            </div>

            <div>
                <button type="submit" id="submitBtn" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    Reset Password
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-gray-500 transition duration-150 ease-in-out">
                    ← Back to Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
    } else {
        field.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    function updateRequirement(id, met) {
        const element = document.getElementById(id);
        const icon = element.querySelector('span');
        if (met) {
            icon.textContent = '✅';
            element.classList.add('text-green-600');
            element.classList.remove('text-gray-600');
        } else {
            icon.textContent = '❌';
            element.classList.add('text-gray-600');
            element.classList.remove('text-green-600');
        }
    }
    
    function checkPassword() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        const hasLength = password.length >= 8;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        const passwordsMatch = password === confirm && password.length > 0;
        
        updateRequirement('req-length', hasLength);
        updateRequirement('req-uppercase', hasUpper);
        updateRequirement('req-lowercase', hasLower);
        updateRequirement('req-number', hasNumber);
        updateRequirement('req-match', passwordsMatch);
        
        // Calculate strength
        let strength = 0;
        if (hasLength) strength += 20;
        if (hasUpper) strength += 20;
        if (hasLower) strength += 20;
        if (hasNumber) strength += 20;
        if (passwordsMatch) strength += 20;
        
        strengthBar.style.width = strength + '%';
        
        if (strength < 40) {
            strengthBar.className = 'bg-red-500 h-2 rounded-full transition-all duration-300';
            strengthText.textContent = 'Weak';
            strengthText.className = 'text-xs text-red-500';
        } else if (strength < 80) {
            strengthBar.className = 'bg-yellow-500 h-2 rounded-full transition-all duration-300';
            strengthText.textContent = 'Medium';
            strengthText.className = 'text-xs text-yellow-500';
        } else {
            strengthBar.className = 'bg-green-500 h-2 rounded-full transition-all duration-300';
            strengthText.textContent = 'Strong';
            strengthText.className = 'text-xs text-green-500';
        }
        
        // Enable submit button only if all requirements are met
        const allMet = hasLength && hasUpper && hasLower && hasNumber && passwordsMatch;
        submitBtn.disabled = !allMet;
    }
    
    passwordInput.addEventListener('input', checkPassword);
    confirmInput.addEventListener('input', checkPassword);
});
</script>
@endsection
