<x-layouts.admin>
    <x-slot name="title">Robots.txt Management</x-slot>
    <x-slot name="description">Configure robots.txt file to control search engine crawling</x-slot>
    <x-slot name="pageTitle">🤖 Robots.txt Management</x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Robots.txt Status -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-black">Robots.txt Status</h3>
                <div class="flex items-center space-x-2">
                    @if(file_exists(public_path('robots.txt')))
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">✅ Active</span>
                        <a href="{{ url('/robots.txt') }}" target="_blank" class="btn btn-sm btn-outline">
                            👁️ View Live
                        </a>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">❌ Not Found</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Robots.txt Editor -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-black mb-4">Edit Robots.txt</h3>
            
            <form id="robots-form" onsubmit="updateRobots(event)">
                <div class="mb-4">
                    <label for="robots-content" class="block text-sm font-medium text-gray-700 mb-2">
                        Robots.txt Content
                    </label>
                    <textarea 
                        id="robots-content" 
                        name="content" 
                        rows="15" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-black focus:border-black font-mono text-sm"
                        placeholder="User-agent: *&#10;Allow: /&#10;&#10;Sitemap: {{ url('/sitemap.xml') }}"
                    >{{ $robotsContent }}</textarea>
                </div>
                
                <div class="flex space-x-4">
                    <button type="submit" class="btn btn-primary">
                        💾 Save Robots.txt
                    </button>
                    <button type="button" onclick="resetToDefault()" class="btn btn-outline">
                        🔄 Reset to Default
                    </button>
                    <button type="button" onclick="validateRobots()" class="btn btn-outline">
                        ✅ Validate
                    </button>
                </div>
            </form>
        </div>

        <!-- Common Robots.txt Templates -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-black mb-4">Common Templates</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="font-medium text-black mb-2">🌐 Allow All (Default)</h4>
                    <pre class="text-xs bg-gray-50 p-3 rounded border overflow-x-auto">User-agent: *
Allow: /

Sitemap: {{ url('/sitemap.xml') }}</pre>
                    <button onclick="useTemplate('allow-all')" class="mt-2 btn btn-sm btn-outline">Use Template</button>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="font-medium text-black mb-2">🔒 Block Admin Areas</h4>
                    <pre class="text-xs bg-gray-50 p-3 rounded border overflow-x-auto">User-agent: *
Allow: /
Disallow: /admin/
Disallow: /login
Disallow: /register

Sitemap: {{ url('/sitemap.xml') }}</pre>
                    <button onclick="useTemplate('block-admin')" class="mt-2 btn btn-sm btn-outline">Use Template</button>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="font-medium text-black mb-2">🛡️ E-commerce Optimized</h4>
                    <pre class="text-xs bg-gray-50 p-3 rounded border overflow-x-auto">User-agent: *
Allow: /
Disallow: /admin/
Disallow: /cart
Disallow: /checkout
Disallow: /login
Disallow: /register
Disallow: /wishlist

Sitemap: {{ url('/sitemap.xml') }}</pre>
                    <button onclick="useTemplate('ecommerce')" class="mt-2 btn btn-sm btn-outline">Use Template</button>
                </div>
                
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="font-medium text-black mb-2">🚫 Block All</h4>
                    <pre class="text-xs bg-gray-50 p-3 rounded border overflow-x-auto">User-agent: *
Disallow: /</pre>
                    <button onclick="useTemplate('block-all')" class="mt-2 btn btn-sm btn-outline">Use Template</button>
                </div>
            </div>
        </div>

        <!-- SEO Guidelines -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-yellow-900 mb-4">⚠️ Important Guidelines</h3>
            <div class="space-y-2 text-sm text-yellow-800">
                <p>• Always include your sitemap URL in robots.txt</p>
                <p>• Use "Disallow:" to block specific directories or pages</p>
                <p>• Use "Allow:" to explicitly allow access to specific content</p>
                <p>• Test your robots.txt file using Google Search Console</p>
                <p>• Be careful with "Disallow: /" as it blocks all crawling</p>
                <p>• Changes take effect immediately but may take time for search engines to process</p>
            </div>
        </div>
    </div>

    <script>
        const templates = {
            'allow-all': `User-agent: *
Allow: /

Sitemap: {{ url('/sitemap.xml') }}`,
            'block-admin': `User-agent: *
Allow: /
Disallow: /admin/
Disallow: /login
Disallow: /register

Sitemap: {{ url('/sitemap.xml') }}`,
            'ecommerce': `User-agent: *
Allow: /
Disallow: /admin/
Disallow: /cart
Disallow: /checkout
Disallow: /login
Disallow: /register
Disallow: /wishlist

Sitemap: {{ url('/sitemap.xml') }}`,
            'block-all': `User-agent: *
Disallow: /`
        };

        function useTemplate(templateName) {
            if (templates[templateName]) {
                document.getElementById('robots-content').value = templates[templateName];
            }
        }

        function resetToDefault() {
            if (confirm('Are you sure you want to reset to default robots.txt?')) {
                useTemplate('allow-all');
            }
        }

        function validateRobots() {
            const content = document.getElementById('robots-content').value;
            
            if (!content.trim()) {
                alert('❌ Robots.txt content cannot be empty');
                return;
            }
            
            if (!content.includes('User-agent:')) {
                alert('⚠️ Warning: No User-agent directive found');
                return;
            }
            
            alert('✅ Robots.txt appears to be valid');
        }

        function updateRobots(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const button = event.target.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            
            button.textContent = '💾 Saving...';
            button.disabled = true;

            fetch('{{ route("admin.seo.robots.update") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
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
    </script>
</x-layouts.admin>
