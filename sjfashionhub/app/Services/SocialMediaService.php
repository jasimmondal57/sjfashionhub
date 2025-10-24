<?php

namespace App\Services;

use App\Models\SocialMediaPost;
use App\Models\SocialMediaConfig;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SocialMediaService
{
    /**
     * Post to a specific social media platform
     */
    public function postToPlatform(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        try {
            switch ($config->platform) {
                case 'instagram':
                    return $this->postToInstagram($post, $config);
                case 'facebook':
                    return $this->postToFacebook($post, $config);
                case 'twitter':
                    return $this->postToTwitter($post, $config);
                case 'linkedin':
                    return $this->postToLinkedIn($post, $config);
                case 'pinterest':
                    return $this->postToPinterest($post, $config);
                case 'tiktok':
                    return $this->postToTikTok($post, $config);
                case 'threads':
                    return $this->postToThreads($post, $config);
                default:
                    return [
                        'success' => false,
                        'error' => 'Unsupported platform: ' . $config->platform
                    ];
            }
        } catch (\Exception $e) {
            Log::error("Social media posting error for {$config->platform}: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Post to Instagram using Instagram Basic Display API
     */
    protected function postToInstagram(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        $accessToken = $config->getCredential('access_token');
        $userId = $config->getCredential('user_id');

        if (!$accessToken || !$userId) {
            return [
                'success' => false,
                'error' => 'Instagram access token or user ID not configured'
            ];
        }

        try {
            // For Instagram, we need to create a media object first, then publish it
            $mediaResponse = Http::post("https://graph.instagram.com/v18.0/{$userId}/media", [
                'image_url' => $post->images[0] ?? null,
                'caption' => $post->content . "\n\n" . $post->formatted_hashtags,
                'access_token' => $accessToken
            ]);

            if (!$mediaResponse->successful()) {
                return [
                    'success' => false,
                    'error' => 'Failed to create Instagram media: ' . $mediaResponse->body()
                ];
            }

            $mediaId = $mediaResponse->json('id');

            // Publish the media
            $publishResponse = Http::post("https://graph.instagram.com/v18.0/{$userId}/media_publish", [
                'creation_id' => $mediaId,
                'access_token' => $accessToken
            ]);

            if ($publishResponse->successful()) {
                return [
                    'success' => true,
                    'post_id' => $publishResponse->json('id'),
                    'response' => $publishResponse->json()
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Failed to publish Instagram post: ' . $publishResponse->body()
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Instagram API error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Post to Facebook using Facebook Graph API
     */
    protected function postToFacebook(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        $accessToken = $config->getCredential('access_token');
        $pageId = $config->getCredential('page_id');

        if (!$accessToken || !$pageId) {
            return [
                'success' => false,
                'error' => 'Facebook access token or page ID not configured'
            ];
        }

        try {
            $data = [
                'message' => $post->content . "\n\n" . $post->formatted_hashtags,
                'access_token' => $accessToken
            ];

            // Add image if available
            if (!empty($post->images)) {
                $data['link'] = $post->images[0];
            }

            $response = Http::post("https://graph.facebook.com/v18.0/{$pageId}/feed", $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'post_id' => $response->json('id'),
                    'response' => $response->json()
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Facebook API error: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Facebook posting error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Post to Twitter/X using Twitter API v2
     */
    protected function postToTwitter(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        $bearerToken = $config->getCredential('bearer_token');
        $accessToken = $config->getCredential('access_token');
        $accessTokenSecret = $config->getCredential('access_token_secret');
        $consumerKey = $config->getCredential('consumer_key');
        $consumerSecret = $config->getCredential('consumer_secret');

        if (!$bearerToken && (!$accessToken || !$accessTokenSecret || !$consumerKey || !$consumerSecret)) {
            return [
                'success' => false,
                'error' => 'Twitter API credentials not properly configured'
            ];
        }

        try {
            // Truncate content to fit Twitter's character limit
            $content = $post->content . "\n\n" . $post->formatted_hashtags;
            if (strlen($content) > 280) {
                $content = substr($content, 0, 277) . '...';
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
                'Content-Type' => 'application/json'
            ])->post('https://api.twitter.com/2/tweets', [
                'text' => $content
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'post_id' => $response->json('data.id'),
                    'response' => $response->json()
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Twitter API error: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Twitter posting error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Post to LinkedIn using LinkedIn API
     */
    protected function postToLinkedIn(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        $accessToken = $config->getCredential('access_token');
        $personId = $config->getCredential('person_id');

        if (!$accessToken || !$personId) {
            return [
                'success' => false,
                'error' => 'LinkedIn access token or person ID not configured'
            ];
        }

        try {
            $data = [
                'author' => "urn:li:person:{$personId}",
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $post->content . "\n\n" . $post->formatted_hashtags
                        ],
                        'shareMediaCategory' => 'NONE'
                    ]
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'X-Restli-Protocol-Version' => '2.0.0'
            ])->post('https://api.linkedin.com/v2/ugcPosts', $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'post_id' => $response->header('x-restli-id'),
                    'response' => $response->json()
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'LinkedIn API error: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'LinkedIn posting error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Post to Pinterest using Pinterest API
     */
    protected function postToPinterest(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        try {
            $credentials = $config->getCredentials();
            $accessToken = $credentials['access_token'] ?? null;

            if (!$accessToken) {
                return [
                    'success' => false,
                    'error' => 'Pinterest access token not configured'
                ];
            }

            // Prepare Pinterest pin data
            $pinData = [
                'note' => $post->content,
                'board_id' => $credentials['board_id'] ?? null,
                'media_source' => [
                    'source_type' => 'image_url',
                    'url' => $post->images[0] ?? null
                ]
            ];

            if (!$pinData['board_id']) {
                return [
                    'success' => false,
                    'error' => 'Pinterest board ID not configured'
                ];
            }

            if (!$pinData['media_source']['url']) {
                return [
                    'success' => false,
                    'error' => 'No image available for Pinterest pin'
                ];
            }

            // Post to Pinterest API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ])->post('https://api.pinterest.com/v5/pins', $pinData);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'post_id' => $data['id'] ?? null,
                    'response' => $data
                ];
            }

            return [
                'success' => false,
                'error' => 'Pinterest API error: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Pinterest posting failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Post to TikTok using TikTok API
     */
    protected function postToTikTok(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        try {
            $credentials = $config->getCredentials();
            $accessToken = $credentials['access_token'] ?? null;

            if (!$accessToken) {
                return [
                    'success' => false,
                    'error' => 'TikTok access token not configured'
                ];
            }

            // Prepare TikTok video post data
            $postData = [
                'text' => $post->content,
                'privacy_level' => 'PUBLIC_TO_EVERYONE',
                'disable_duet' => false,
                'disable_comment' => false,
                'disable_stitch' => false,
                'brand_content_toggle' => false
            ];

            // Note: TikTok requires video upload, which is more complex
            // For now, we'll return a placeholder response
            return [
                'success' => false,
                'error' => 'TikTok requires video content. Text-only posts not supported.'
            ];

            // Future implementation would include:
            // 1. Video upload to TikTok
            // 2. Post creation with video
            // 3. Proper error handling

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'TikTok posting failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Post to Threads using Threads API
     */
    protected function postToThreads(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        try {
            $credentials = $config->getCredentials();
            $accessToken = $credentials['access_token'] ?? null;
            $userId = $credentials['user_id'] ?? null;

            if (!$accessToken || !$userId) {
                return [
                    'success' => false,
                    'error' => 'Threads access token or user ID not configured'
                ];
            }

            // Prepare Threads post data
            $postData = [
                'media_type' => 'TEXT',
                'text' => $post->content
            ];

            // Add image if available
            if (!empty($post->images)) {
                $postData['media_type'] = 'IMAGE';
                $postData['image_url'] = $post->images[0];
            }

            // Create Threads media container
            $response = Http::post("https://graph.threads.net/v1.0/{$userId}/threads", array_merge($postData, [
                'access_token' => $accessToken
            ]));

            if ($response->successful()) {
                $data = $response->json();
                $creationId = $data['id'] ?? null;

                if ($creationId) {
                    // Publish the thread
                    $publishResponse = Http::post("https://graph.threads.net/v1.0/{$userId}/threads_publish", [
                        'creation_id' => $creationId,
                        'access_token' => $accessToken
                    ]);

                    if ($publishResponse->successful()) {
                        $publishData = $publishResponse->json();
                        return [
                            'success' => true,
                            'post_id' => $publishData['id'] ?? $creationId,
                            'response' => $publishData
                        ];
                    }
                }
            }

            return [
                'success' => false,
                'error' => 'Threads API error: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Threads posting failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test connection to a platform
     */
    public function testConnection(SocialMediaConfig $config): array
    {
        try {
            switch ($config->platform) {
                case 'instagram':
                    return $this->testInstagramConnection($config);
                case 'facebook':
                    return $this->testFacebookConnection($config);
                case 'twitter':
                    return $this->testTwitterConnection($config);
                case 'linkedin':
                    return $this->testLinkedInConnection($config);
                default:
                    return [
                        'success' => false,
                        'error' => 'Connection test not implemented for ' . $config->platform
                    ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    protected function testInstagramConnection(SocialMediaConfig $config): array
    {
        $accessToken = $config->getCredential('access_token');
        $userId = $config->getCredential('user_id');

        if (!$accessToken || !$userId) {
            return [
                'success' => false,
                'error' => 'Missing access token or user ID'
            ];
        }

        $response = Http::get("https://graph.instagram.com/v18.0/{$userId}", [
            'fields' => 'id,username',
            'access_token' => $accessToken
        ]);

        return [
            'success' => $response->successful(),
            'error' => $response->successful() ? null : $response->body(),
            'data' => $response->json()
        ];
    }

    protected function testFacebookConnection(SocialMediaConfig $config): array
    {
        $accessToken = $config->getCredential('access_token');
        $pageId = $config->getCredential('page_id');

        if (!$accessToken || !$pageId) {
            return [
                'success' => false,
                'error' => 'Missing access token or page ID'
            ];
        }

        // First, test if the token is valid by checking the token info
        $tokenResponse = Http::get("https://graph.facebook.com/debug_token", [
            'input_token' => $accessToken,
            'access_token' => $accessToken
        ]);

        if ($tokenResponse->successful()) {
            $tokenData = $tokenResponse->json();

            // Check if token is valid
            if (isset($tokenData['data']['is_valid']) && $tokenData['data']['is_valid']) {
                return [
                    'success' => true,
                    'error' => null,
                    'data' => [
                        'message' => 'Facebook credentials are valid! ✅',
                        'page_id' => $pageId,
                        'token_valid' => true,
                        'app_id' => $tokenData['data']['app_id'] ?? 'Unknown'
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Access token is invalid or expired',
                    'data' => $tokenData
                ];
            }
        }

        // Fallback: try to get page info (may fail due to permissions)
        $response = Http::get("https://graph.facebook.com/v18.0/{$pageId}", [
            'fields' => 'id,name',
            'access_token' => $accessToken
        ]);

        return [
            'success' => $response->successful(),
            'error' => $response->successful() ? null : $response->body(),
            'data' => $response->json()
        ];
    }

    protected function testTwitterConnection(SocialMediaConfig $config): array
    {
        $bearerToken = $config->getCredential('bearer_token');

        if (!$bearerToken) {
            return [
                'success' => false,
                'error' => 'Missing bearer token'
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken
        ])->get('https://api.twitter.com/2/users/me');

        return [
            'success' => $response->successful(),
            'error' => $response->successful() ? null : $response->body(),
            'data' => $response->json()
        ];
    }

    protected function testLinkedInConnection(SocialMediaConfig $config): array
    {
        $accessToken = $config->getCredential('access_token');

        if (!$accessToken) {
            return [
                'success' => false,
                'error' => 'Missing access token'
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken
        ])->get('https://api.linkedin.com/v2/me');

        return [
            'success' => $response->successful(),
            'error' => $response->successful() ? null : $response->body(),
            'data' => $response->json()
        ];
    }
}
