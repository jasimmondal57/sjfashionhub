<x-layouts.main>
    <x-slot name="title">{{ $page->seo_title ?: $page->title }}</x-slot>
    <x-slot name="description">{{ $page->meta_description }}</x-slot>
    <x-slot name="keywords">{{ $page->meta_keywords }}</x-slot>

    <div class="min-h-screen bg-gray-50">
        @if($page->page_type === 'about')
            <!-- About Page Specific Layout -->
            <section class="bg-gradient-to-r from-gray-900 to-gray-700 text-white py-20">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">{{ $page->title }}</h1>
                    <div class="flex justify-center space-x-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold">5000+</div>
                            <div class="text-sm opacity-80">Happy Customers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">1000+</div>
                            <div class="text-sm opacity-80">Products</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">50+</div>
                            <div class="text-sm opacity-80">Categories</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-16">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto prose prose-lg">
                        {!! $page->content !!}
                    </div>
                </div>
            </section>

        @elseif($page->page_type === 'contact')
            <!-- Contact Page Specific Layout -->
            <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-20">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">{{ $page->title }}</h1>
                    <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                        We'd love to hear from you. Get in touch with our friendly team.
                    </p>
                </div>
            </section>

            <section class="py-16">
                <div class="container mx-auto px-4">
                    <div class="max-w-6xl mx-auto">
                        <div class="grid lg:grid-cols-2 gap-12">
                            <!-- Contact Information -->
                            <div>
                                <div class="prose prose-lg">
                                    {!! $page->content !!}
                                </div>
                            </div>
                            
                            <!-- Contact Form -->
                            <div class="bg-white p-8 rounded-lg shadow-sm">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>
                                <form class="space-y-6" action="#" method="POST">
                                    @csrf
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                            <input type="text" id="first_name" name="first_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                            <input type="text" id="last_name" name="last_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    </div>
                                    
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                        <select id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                            <option value="">Select a subject</option>
                                            <option value="general">General Inquiry</option>
                                            <option value="order">Order Support</option>
                                            <option value="returns">Returns & Exchanges</option>
                                            <option value="product">Product Question</option>
                                            <option value="feedback">Feedback</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tell us how we can help you..." required></textarea>
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

        @else
            <!-- Generic Page Layout for Privacy, Terms, etc. -->
            <section class="bg-gradient-to-r from-gray-800 to-gray-600 text-white py-16">
                <div class="container mx-auto px-4 text-center">
                    <h1 class="text-3xl md:text-5xl font-bold mb-4">{{ $page->title }}</h1>
                    @if($page->meta_description)
                        <p class="text-lg md:text-xl max-w-3xl mx-auto opacity-90">
                            {{ $page->meta_description }}
                        </p>
                    @endif
                </div>
            </section>

            <section class="py-16">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <div class="bg-white rounded-lg shadow-sm p-8">
                            <div class="prose prose-lg max-w-none">
                                {!! $page->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Call to Action Section (for all pages except contact) -->
        @if($page->page_type !== 'contact')
            <section class="py-16 bg-gray-900 text-white">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Shopping?</h2>
                    <p class="text-xl mb-8 max-w-2xl mx-auto">
                        Discover our latest collection and find your perfect style today.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('products.index') }}" class="bg-white text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                            Shop Now
                        </a>
                        <a href="{{ route('contact') }}" class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors">
                            Contact Us
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </div>
</x-layouts.main>
