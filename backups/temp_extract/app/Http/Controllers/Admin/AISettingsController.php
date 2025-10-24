<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class AISettingsController extends Controller
{
    public function index()
    {
        $currentApiKey = env('GEMINI_API_KEY');
        $isConfigured = !empty($currentApiKey);
        $connectionStatus = null;
        
        if ($isConfigured) {
            $connectionStatus = $this->testGeminiConnection($currentApiKey);
        }
        
        return view('admin.ai-settings.index', compact('currentApiKey', 'isConfigured', 'connectionStatus'));
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'gemini_api_key' => 'required|string|min:10',
        ]);
        
        $apiKey = $request->input('gemini_api_key');
        
        // Test the API key before saving
        $testResult = $this->testGeminiConnection($apiKey);
        
        if (!$testResult['success']) {
            return back()->withErrors(['gemini_api_key' => 'Invalid API key. ' . $testResult['message']]);
        }
        
        // Update the .env file
        $this->updateEnvFile('GEMINI_API_KEY', $apiKey);
        
        return back()->with('success', 'Gemini AI API key updated successfully! AI features are now active.');
    }
    
    public function test(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
        ]);
        
        $result = $this->testGeminiConnection($request->input('api_key'));
        
        return response()->json($result);
    }
    
    private function testGeminiConnection($apiKey)
    {
        // Validate API key format
        if (empty($apiKey) || strlen($apiKey) < 10) {
            return [
                'success' => false,
                'message' => 'Invalid API key format. Please check your API key.'
            ];
        }

        try {
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for localhost
                'timeout' => 10,
            ])->withHeaders([
                'Content-Type' => 'application/json',
            ])->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Hello, this is a test message. Please respond with "API connection successful".']
                            ]
                        ]
                    ]
                ]
            );
            
            if ($response->successful()) {
                $result = $response->json();
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    return [
                        'success' => true,
                        'message' => 'API connection successful! Gemini AI is working properly.',
                        'response' => $result['candidates'][0]['content']['parts'][0]['text']
                    ];
                }
            }

            $errorBody = $response->body();
            $statusCode = $response->status();
            $errorData = $response->json();

            // Handle specific error cases
            if ($statusCode == 400 && isset($errorData['error']['message'])) {
                $errorMessage = $errorData['error']['message'];
                if (strpos($errorMessage, 'API key not valid') !== false) {
                    return [
                        'success' => false,
                        'message' => 'Invalid API key. Please check that you copied the correct API key from Google AI Studio.'
                    ];
                }
                return [
                    'success' => false,
                    'message' => 'API Error: ' . $errorMessage
                ];
            }

            if ($statusCode == 404) {
                return [
                    'success' => false,
                    'message' => 'API endpoint not found. The Gemini API might be unavailable or the model name is incorrect.'
                ];
            }

            return [
                'success' => false,
                'message' => "API request failed (Status: {$statusCode}). Please check your API key and try again.",
                'error' => $errorBody
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
                'debug' => [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ];
        }
    }
    
    private function updateEnvFile($key, $value)
    {
        $envFile = base_path('.env');
        $envContent = File::get($envFile);
        
        // Escape special characters in the value
        $value = '"' . str_replace('"', '\"', $value) . '"';
        
        // Check if the key already exists
        if (preg_match("/^{$key}=.*$/m", $envContent)) {
            // Update existing key
            $envContent = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $envContent);
        } else {
            // Add new key
            $envContent .= "\n{$key}={$value}";
        }
        
        File::put($envFile, $envContent);
        
        // Clear config cache to reload environment variables
        if (function_exists('config_clear')) {
            config_clear();
        }
    }
    
    public function remove(Request $request)
    {
        // Remove the API key from .env
        $this->updateEnvFile('GEMINI_API_KEY', '');
        
        return back()->with('success', 'Gemini AI API key removed successfully. AI features are now disabled.');
    }
    
    public function generateSample(Request $request)
    {
        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Gemini API key not configured'
            ]);
        }
        
        try {
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for localhost
                'timeout' => 15,
            ])->withHeaders([
                'Content-Type' => 'application/json',
            ])->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Generate a sample product description for a "Blue Cotton T-Shirt" from brand "SJ Fashion". Make it engaging and SEO-friendly. Keep it under 200 characters.']
                            ]
                        ]
                    ]
                ]
            );
            
            if ($response->successful()) {
                $result = $response->json();
                $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'No response generated';
                
                return response()->json([
                    'success' => true,
                    'sample' => $generatedText
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate sample content'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
