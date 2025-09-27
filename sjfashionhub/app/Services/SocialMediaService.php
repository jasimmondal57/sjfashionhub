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
    public function postToplatform(SocialMediaPost $post, SocialMediaConfig $config): array
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
        // Pinterest API implementation would go here
        return [
            'success' => false,
            'error' => 'Pinterest integration coming soon'
        ];
    }

    /**
     * Post to TikTok using TikTok API
     */
    protected function postToTikTok(SocialMediaPost $post, SocialMediaConfig $config): array
    {
        // TikTok API implementation would go here
        return [
            'success' => false,
            'error' => 'TikTok integration coming soon'
        ];
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
