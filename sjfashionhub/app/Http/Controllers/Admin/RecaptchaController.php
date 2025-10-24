<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecaptchaSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecaptchaController extends Controller
{
    /**
     * Show reCAPTCHA settings page
     */
    public function index()
    {
        $settings = RecaptchaSetting::getCurrent();
        
        return view('admin.recaptcha.index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update reCAPTCHA settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'enabled' => 'boolean',
            'site_key' => 'nullable|string|max:255',
            'secret_key' => 'nullable|string|max:255',
            'threshold' => 'required|numeric|min:0|max:1',
        ]);

        $settings = RecaptchaSetting::getCurrent();
        $settings->update($validated);

        Log::info('reCAPTCHA settings updated', [
            'enabled' => $validated['enabled'],
            'threshold' => $validated['threshold'],
        ]);

        return back()->with('success', 'reCAPTCHA settings updated successfully!');
    }

    /**
     * Test reCAPTCHA connection
     */
    public function test(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $settings = RecaptchaSetting::getCurrent();

        if (!$settings->enabled || !$settings->secret_key) {
            return response()->json([
                'success' => false,
                'message' => 'reCAPTCHA is not properly configured',
            ], 400);
        }

        try {
            $response = \Http::post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $settings->secret_key,
                'response' => $request->token,
            ]);

            $data = $response->json();

            if ($response->successful() && $data['success']) {
                return response()->json([
                    'success' => true,
                    'score' => $data['score'] ?? 0,
                    'message' => 'reCAPTCHA verification successful!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'reCAPTCHA verification failed',
                'errors' => $data['error-codes'] ?? [],
            ], 400);

        } catch (\Exception $e) {
            Log::error('reCAPTCHA test failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error testing reCAPTCHA: ' . $e->getMessage(),
            ], 500);
        }
    }
}

