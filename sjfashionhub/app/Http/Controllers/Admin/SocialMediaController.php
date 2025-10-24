<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SocialMediaPost;
use App\Models\SocialMediaConfig;
use App\Services\SocialMediaService;
use App\Services\AIContentGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{
    protected $socialMediaService;
    protected $aiContentGenerator;

    public function __construct(SocialMediaService $socialMediaService, AIContentGeneratorService $aiContentGenerator)
    {
        $this->socialMediaService = $socialMediaService;
        $this->aiContentGenerator = $aiContentGenerator;
    }

    /**
     * Display social media management dashboard
     */
    public function index()
    {
        $posts = SocialMediaPost::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $configs = SocialMediaConfig::all();

        $stats = [
            'total_posts' => SocialMediaPost::count(),
            'posted_today' => SocialMediaPost::whereDate('posted_at', today())->count(),
            'pending_posts' => SocialMediaPost::pending()->count(),
            'failed_posts' => SocialMediaPost::failed()->count(),
        ];

        return view('admin.social-media.index', compact('posts', 'configs', 'stats'));
    }

    /**
     * Show social media configuration page
     */
    public function config()
    {
        $configs = SocialMediaConfig::all()->keyBy('platform');

        $availablePlatforms = [
            'instagram' => ['name' => 'Instagram', 'icon' => '📷', 'active' => true],
            'facebook' => ['name' => 'Facebook', 'icon' => '📘', 'active' => true],
            'twitter' => ['name' => 'Twitter/X', 'icon' => '🐦', 'active' => true],
            'linkedin' => ['name' => 'LinkedIn', 'icon' => '💼', 'active' => true],
            'pinterest' => ['name' => 'Pinterest', 'icon' => '📌', 'active' => true],
            'tiktok' => ['name' => 'TikTok', 'icon' => '🎵', 'active' => true],
            'threads' => ['name' => 'Threads', 'icon' => '🧵', 'active' => true],
        ];

        return view('admin.social-media.config', compact('configs', 'availablePlatforms'));
    }

    /**
     * Update social media configuration
     */
    public function updateConfig(Request $request, $platform)
    {
        \Log::info("=== Social Media Config Update Request ===");
        \Log::info("Platform: {$platform}");
        \Log::info("All Request Data: " . json_encode($request->all()));

        $request->validate([
            'is_active' => 'boolean',
            'credentials' => 'array',
            'settings' => 'array',
        ]);

        // Get platform display name
        $platformNames = [
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter/X',
            'linkedin' => 'LinkedIn',
            'pinterest' => 'Pinterest',
            'tiktok' => 'TikTok',
            'threads' => 'Threads',
        ];

        $platformName = $platformNames[$platform] ?? ucfirst($platform);

        $config = SocialMediaConfig::firstOrCreate(
            ['platform' => $platform],
            [
                'name' => $platformName,
                'description' => "Configuration for {$platformName} social media platform"
            ]
        );

        // Get credentials and filter out empty values
        $credentials = $request->input('credentials', []);
        \Log::info("Raw credentials for {$platform}: " . json_encode($credentials));

        $credentials = array_filter($credentials, function($value) {
            return !empty($value);
        });

        \Log::info("Filtered credentials for {$platform}: " . json_encode($credentials));

        // Only update credentials if there are non-empty values
        $updateData = [
            'is_active' => $request->boolean('is_active'),
            'settings' => $request->input('settings', []),
        ];

        // Only update credentials if we have values, otherwise keep existing
        if (!empty($credentials)) {
            $updateData['credentials'] = $credentials;
            \Log::info("Updating credentials for {$platform}");
        } else {
            \Log::info("No credentials to update for {$platform}");
        }

        $config->update($updateData);
        \Log::info("Config updated. New credentials: " . json_encode($config->credentials));

        return redirect()->back()->with('success', ucfirst($platform) . ' configuration updated successfully!');
    }

    /**
     * Post product to specific platform
     */
    public function postToSingle(Request $request, Product $product, $platform)
    {
        try {
            $config = SocialMediaConfig::forPlatform($platform)->active()->first();

            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => ucfirst($platform) . ' is not configured or inactive.'
                ], 400);
            }

            // Generate AI content
            $content = $this->aiContentGenerator->generateProductPost($product, $platform);

            // Create social media post record with enhanced data
            $post = SocialMediaPost::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'platform' => $platform,
                'content' => $content['text'],
                'hashtags' => $content['hashtags'],
                'images' => $product->images,
                'status' => 'pending',
                'is_ai_generated' => true,
                'ai_prompt' => $content['prompt'],
                'metadata' => [
                    'product_url' => $content['product_url'] ?? url("/products/{$product->slug}"),
                    'price_info' => $content['price_info'] ?? null,
                    'call_to_action' => $content['call_to_action'] ?? 'Shop now at sjfashionhub.in',
                    'ai_model' => 'gemini-pro'
                ]
            ]);

            // Post to platform
            $result = $this->socialMediaService->postToplatform($post, $config);

            if ($result['success']) {
                $post->update([
                    'status' => 'posted',
                    'post_id' => $result['post_id'],
                    'posted_at' => now(),
                    'platform_response' => $result['response'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Successfully posted to {$platform}!",
                    'post_id' => $post->id
                ]);
            } else {
                $post->update([
                    'status' => 'failed',
                    'error_message' => $result['error'],
                ]);

                return response()->json([
                    'success' => false,
                    'message' => "Failed to post to {$platform}: " . $result['error']
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Post product to all active platforms
     */
    public function postToAll(Request $request, Product $product)
    {
        try {
            $activeConfigs = SocialMediaConfig::active()->get();

            if ($activeConfigs->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active social media platforms configured.'
                ], 400);
            }

            $results = [];
            $successCount = 0;
            $failureCount = 0;

            foreach ($activeConfigs as $config) {
                try {
                    // Generate AI content for this platform with enhanced features
                    $content = $this->aiContentGenerator->generateProductPost($product, $config->platform);

                    // Create social media post record with enhanced data
                    $post = SocialMediaPost::create([
                        'product_id' => $product->id,
                        'user_id' => Auth::id(),
                        'platform' => $config->platform,
                        'content' => $content['text'],
                        'hashtags' => $content['hashtags'],
                        'images' => $product->images,
                        'status' => 'pending',
                        'is_ai_generated' => true,
                        'ai_prompt' => $content['prompt'],
                        'metadata' => [
                            'product_url' => $content['product_url'] ?? url("/products/{$product->slug}"),
                            'price_info' => $content['price_info'] ?? null,
                            'call_to_action' => $content['call_to_action'] ?? 'Shop now at sjfashionhub.in',
                            'ai_model' => 'gemini-pro'
                        ]
                    ]);

                    // Post to platform
                    $result = $this->socialMediaService->postToplatform($post, $config);

                    if ($result['success']) {
                        $post->update([
                            'status' => 'posted',
                            'post_id' => $result['post_id'],
                            'posted_at' => now(),
                            'platform_response' => $result['response'],
                        ]);

                        $results[$config->platform] = ['success' => true, 'message' => 'Posted successfully'];
                        $successCount++;
                    } else {
                        $post->update([
                            'status' => 'failed',
                            'error_message' => $result['error'],
                        ]);

                        $results[$config->platform] = ['success' => false, 'message' => $result['error']];
                        $failureCount++;
                    }

                } catch (\Exception $e) {
                    $results[$config->platform] = ['success' => false, 'message' => $e->getMessage()];
                    $failureCount++;
                }
            }

            return response()->json([
                'success' => $successCount > 0,
                'message' => "Posted to {$successCount} platforms successfully. {$failureCount} failed.",
                'results' => $results,
                'stats' => [
                    'success' => $successCount,
                    'failed' => $failureCount,
                    'total' => count($activeConfigs)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show posts for a specific product
     */
    public function productPosts(Product $product)
    {
        $posts = SocialMediaPost::where('product_id', $product->id)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'posts' => $posts
        ]);
    }

    /**
     * Delete a social media post
     */
    public function deletePost(SocialMediaPost $post)
    {
        $post->delete();

        return redirect()->back()->with('success', 'Social media post deleted successfully!');
    }

    /**
     * Retry failed post
     */
    public function retryPost(SocialMediaPost $post)
    {
        try {
            $config = SocialMediaConfig::forPlatform($post->platform)->active()->first();

            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => ucfirst($post->platform) . ' is not configured or inactive.'
                ], 400);
            }

            $post->update(['status' => 'pending', 'error_message' => null]);

            $result = $this->socialMediaService->postToplatform($post, $config);

            if ($result['success']) {
                $post->update([
                    'status' => 'posted',
                    'post_id' => $result['post_id'],
                    'posted_at' => now(),
                    'platform_response' => $result['response'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Successfully posted to {$post->platform}!"
                ]);
            } else {
                $post->update([
                    'status' => 'failed',
                    'error_message' => $result['error'],
                ]);

                return response()->json([
                    'success' => false,
                    'message' => "Failed to post to {$post->platform}: " . $result['error']
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test connection to a social media platform
     */
    public function testConnection($platform)
    {
        try {
            $config = SocialMediaConfig::where('platform', $platform)->first();

            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => ucfirst($platform) . ' is not configured yet.'
                ], 400);
            }

            if (!$config->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => ucfirst($platform) . ' is not active. Please activate it first.'
                ], 400);
            }

            // Test the connection using the service
            $result = $this->socialMediaService->testConnection($config);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => ucfirst($platform) . ' connection is working properly! ✅',
                    'data' => $result['data'] ?? null
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['error'] ?? 'Connection test failed'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error testing connection: ' . $e->getMessage()
            ], 500);
        }
    }
}
