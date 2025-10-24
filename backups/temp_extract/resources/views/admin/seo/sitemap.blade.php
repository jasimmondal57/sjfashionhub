<x-layouts.admin>
    <x-slot name="title">Sitemap Management</x-slot>
    <x-slot name="description">Generate and manage XML sitemap for better search engine indexing</x-slot>
    <x-slot name="pageTitle">🗺️ Sitemap Management</x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Sitemap Status Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-black">Sitemap Status</h3>
                <div id="sitemap-status" class="flex items-center space-x-2">
                    @if(file_exists(public_path('sitemap.xml')))
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">✅ Active</span>
                        <span class="text-sm text-gray-600">Last updated: {{ date('M j, Y g:i A', filemtime(public_path('sitemap.xml'))) }}</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">❌ Not Generated</span>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-black">{{ \App\Models\Product::where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-600">Active Products</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-black">{{ \App\Models\Category::where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-600">Active Categories</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-black">{{ \App\Models\Product::where('is_active', true)->count() + \App\Models\Category::where('is_active', true)->count() + 1 }}</div>
                    <div class="text-sm text-gray-600">Total URLs</div>
                </div>
            </div>

            <div class="flex space-x-4">
                <button onclick="generateSitemap()" class="btn btn-primary">
                    🔄 Generate Sitemap
                </button>
                @if(file_exists(public_path('sitemap.xml')))
                    <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn btn-outline">
                        👁️ View Sitemap
                    </a>
                    <button onclick="downloadSitemap()" class="btn btn-outline">
                        📥 Download
                    </button>
                @endif
            </div>
        </div>

        <!-- Sitemap Configuration -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-black mb-4">Sitemap Configuration</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-black mb-2">Included Pages</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" checked disabled class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Homepage</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" checked disabled class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Product Pages</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" checked disabled class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Category Pages</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-black mb-2">Update Frequency</h4>
                        <div class="space-y-2">
                            <div class="text-sm text-gray-700">Homepage: <span class="font-medium">Daily</span></div>
                            <div class="text-sm text-gray-700">Categories: <span class="font-medium">Weekly</span></div>
                            <div class="text-sm text-gray-700">Products: <span class="font-medium">Weekly</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Tips -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">💡 SEO Tips</h3>
            <div class="space-y-2 text-sm text-blue-800">
                <p>• Submit your sitemap to Google Search Console and Bing Webmaster Tools</p>
                <p>• Regenerate sitemap whenever you add new products or categories</p>
                <p>• Keep your sitemap under 50,000 URLs for optimal performance</p>
                <p>• Ensure all URLs in the sitemap are accessible and return 200 status codes</p>
            </div>
        </div>
    </div>

    <script>
        function generateSitemap() {
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = '🔄 Generating...';
            button.disabled = true;

            fetch('{{ route("admin.seo.sitemap.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ Error: ' + error.message);
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
            });
        }

        function downloadSitemap() {
            window.open('{{ url("/sitemap.xml") }}', '_blank');
        }
    </script>
</x-layouts.admin>
