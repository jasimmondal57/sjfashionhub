@php
    $newsletter = \App\Models\Newsletter::getActiveNewsletter();
@endphp

@if($newsletter)
<section class="py-8 md:py-16" style="background-color: {{ $newsletter->background_color }};">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4" style="color: {{ $newsletter->text_color }};">
                {{ $newsletter->title }}
            </h2>

            @if($newsletter->subtitle)
            <p class="text-base md:text-lg mb-2" style="color: {{ $newsletter->text_color }};">
                {{ $newsletter->subtitle }}
            </p>
            @endif

            @if($newsletter->description)
            <p class="text-sm md:text-base mb-6 md:mb-8 max-w-2xl mx-auto" style="color: {{ $newsletter->text_color }};">
                {{ $newsletter->description }}
            </p>
            @endif

            <!-- Newsletter Subscription Form -->
            <div class="max-w-md mx-auto">
                <form id="newsletter-form" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="flex-1">
                        <input type="email"
                               name="email"
                               id="newsletter-email"
                               placeholder="{{ $newsletter->placeholder_text }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent text-sm md:text-base"
                               required>
                    </div>
                    <button type="submit"
                            id="newsletter-submit"
                            class="px-4 md:px-6 py-3 rounded-md font-medium transition-colors hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 text-sm md:text-base"
                            style="background-color: {{ $newsletter->button_color }}; color: {{ $newsletter->button_text_color }};">
                        {{ $newsletter->button_text }}
                    </button>
                </form>

                <!-- Success/Error Messages -->
                <div id="newsletter-message" class="mt-4 hidden">
                    <div id="newsletter-success" class="hidden p-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="newsletter-success-text"></span>
                    </div>
                    <div id="newsletter-error" class="hidden p-3 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="newsletter-error-text"></span>
                    </div>
                </div>
            </div>

            @if($newsletter->show_social_links && $newsletter->social_links)
            <div class="mt-6 md:mt-8">
                <p class="text-xs md:text-sm mb-3 md:mb-4" style="color: {{ $newsletter->text_color }};">Follow us on social media:</p>
                <div class="flex justify-center space-x-3 md:space-x-4">
                    @foreach($newsletter->social_links as $link)
                        @if(!empty($link['platform']) && !empty($link['url']))
                        <a href="{{ $link['url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center px-3 md:px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-md transition-colors text-sm md:text-base"
                           style="color: {{ $newsletter->text_color }};">
                            @switch($link['platform'])
                                @case('facebook')
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    @break
                                @case('twitter')
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                    @break
                                @case('instagram')
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.807-.875-1.297-2.026-1.297-3.323s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323z"/>
                                    </svg>
                                    @break
                                @case('linkedin')
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    @break
                                @case('youtube')
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    @break
                                @case('tiktok')
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm5.568 8.16c-.169 1.858-.896 3.433-2.188 4.72-1.292 1.288-2.896 2.005-4.8 2.16-.95.077-1.906-.069-2.734-.394-.828-.325-1.549-.814-2.081-1.416-.532-.602-.884-1.313-.884-2.13 0-.817.352-1.528.884-2.13.532-.602 1.253-1.091 2.081-1.416.828-.325 1.784-.471 2.734-.394 1.904.155 3.508.872 4.8 2.16 1.292 1.287 2.019 2.862 2.188 4.72z"/>
                                    </svg>
                            @endswitch
                            {{ ucfirst($link['platform']) }}
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const emailInput = document.getElementById('newsletter-email');
    const submitButton = document.getElementById('newsletter-submit');
    const messageContainer = document.getElementById('newsletter-message');
    const successMessage = document.getElementById('newsletter-success');
    const errorMessage = document.getElementById('newsletter-error');
    const successText = document.getElementById('newsletter-success-text');
    const errorText = document.getElementById('newsletter-error-text');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = emailInput.value.trim();
        if (!email) {
            showError('Please enter your email address.');
            return;
        }

        // Disable form during submission
        submitButton.disabled = true;
        submitButton.textContent = 'Subscribing...';

        // Create form data
        const formData = new FormData();
        formData.append('email', email);
        formData.append('source', 'homepage');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        // Submit form via AJAX
        fetch('{{ route("newsletter.subscribe") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                emailInput.value = '';
            } else {
                showError(data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(error => {
            console.error('Newsletter subscription error:', error);
            showError('Something went wrong. Please try again.');
        })
        .finally(() => {
            // Re-enable form
            submitButton.disabled = false;
            submitButton.textContent = '{{ $newsletter->button_text }}';
        });
    });

    function showSuccess(message) {
        hideMessages();
        successText.textContent = message;
        successMessage.classList.remove('hidden');
        messageContainer.classList.remove('hidden');
    }

    function showError(message) {
        hideMessages();
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
        messageContainer.classList.remove('hidden');
    }

    function hideMessages() {
        successMessage.classList.add('hidden');
        errorMessage.classList.add('hidden');
        messageContainer.classList.add('hidden');
    }
});
</script>
@endif
