<x-layouts.main>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-20">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Contact Us</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    We'd love to hear from you. Get in touch with our friendly team.
                </p>
            </div>
        </section>

        <!-- Contact Information & Form Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="grid lg:grid-cols-2 gap-12">
                        <!-- Contact Information -->
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">Get In Touch</h2>
                            <p class="text-lg text-gray-600 mb-8">
                                Have a question about our products, need help with an order, or just want to say hello? We're here to help!
                            </p>
                            
                            <div class="space-y-6">
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-1">Address</h3>
                                        <p class="text-gray-600">
                                            123 Fashion Street<br>
                                            Style City, SC 12345<br>
                                            India
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-1">Phone</h3>
                                        <p class="text-gray-600">
                                            +91 98765 43210<br>
                                            <span class="text-sm">Mon-Sat 9AM-6PM</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                        <p class="text-gray-600">
                                            info@sjfashionhub.com<br>
                                            support@sjfashionhub.com
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-4">
                                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 mb-1">Business Hours</h3>
                                        <p class="text-gray-600">
                                            Monday - Saturday: 9:00 AM - 6:00 PM<br>
                                            Sunday: 10:00 AM - 4:00 PM
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Form -->
                        <div class="bg-white p-8 rounded-lg shadow-sm">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>

                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="mb-6 p-6 bg-green-50 border-2 border-green-400 text-green-800 rounded-lg">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <h4 class="text-lg font-semibold text-green-800">Message Sent Successfully!</h4>
                                    </div>
                                    <p class="mb-3">{{ session('success') }}</p>
                                    @if(session('ticket_id'))
                                        <div class="bg-green-100 border border-green-300 rounded-lg p-3 mt-3">
                                            <p class="text-sm font-medium text-green-800">
                                                📧 <strong>Confirmation emails have been sent to your email address and our support team.</strong>
                                            </p>
                                            <p class="text-sm text-green-700 mt-1">
                                                💡 <em>Tip: Save your ticket number for faster support when following up.</em>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Error Message -->
                            @if(session('error'))
                                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6" id="contactForm">
                                @csrf
                                @if(\App\Models\RecaptchaSetting::isEnabled())
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                @endif
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                        <input type="text" id="first_name" name="first_name"
                                               value="{{ old('first_name') }}"
                                               class="w-full px-4 py-3 border @error('first_name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        @error('first_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                        <input type="text" id="last_name" name="last_name"
                                               value="{{ old('last_name') }}"
                                               class="w-full px-4 py-3 border @error('last_name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        @error('last_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email') }}"
                                           class="w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" id="phone" name="phone"
                                           value="{{ old('phone') }}"
                                           class="w-full px-4 py-3 border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                    <select id="subject" name="subject"
                                            class="w-full px-4 py-3 border @error('subject') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        <option value="">Select a subject</option>
                                        <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="order" {{ old('subject') == 'order' ? 'selected' : '' }}>Order Support</option>
                                        <option value="returns" {{ old('subject') == 'returns' ? 'selected' : '' }}>Returns & Exchanges</option>
                                        <option value="product" {{ old('subject') == 'product' ? 'selected' : '' }}>Product Question</option>
                                        <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                    <textarea id="message" name="message" rows="5"
                                              class="w-full px-4 py-3 border @error('message') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                              placeholder="Tell us how we can help you..." required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if(\App\Models\RecaptchaSetting::isEnabled())
        <!-- reCAPTCHA Execution Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const contactForm = document.getElementById('contactForm');
                if (contactForm) {
                    contactForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        grecaptcha.execute('{{ \App\Models\RecaptchaSetting::getSiteKey() }}', {action: 'submit'}).then(function(token) {
                            document.getElementById('g-recaptcha-response').value = token;
                            contactForm.submit();
                        });
                    });
                }
            });
        </script>
        @endif

        <!-- FAQ Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                        <p class="text-lg text-gray-600">
                            Quick answers to common questions
                        </p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">How long does shipping take?</h3>
                            <p class="text-gray-600">We typically ship orders within 1-2 business days. Standard delivery takes 3-7 business days, while express delivery takes 1-3 business days.</p>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">What is your return policy?</h3>
                            <p class="text-gray-600">We offer hassle-free returns within 7 days of delivery. Items must be in original condition with tags attached.</p>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">Do you offer international shipping?</h3>
                            <p class="text-gray-600">Currently, we only ship within India. We're working on expanding to international markets soon.</p>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="font-semibold text-gray-900 mb-2">How can I track my order?</h3>
                            <p class="text-gray-600">Once your order ships, you'll receive a tracking number via email and SMS. You can also track your order in your account dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.main>
