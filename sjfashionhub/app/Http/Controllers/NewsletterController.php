<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        // Log the request for debugging
        \Log::info('Newsletter subscription request', [
            'email' => $request->email,
            'source' => $request->source,
            'ajax' => $request->ajax(),
            'content_type' => $request->header('Content-Type'),
        ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            \Log::warning('Newsletter subscription validation failed', $validator->errors()->toArray());

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first('email') ?: 'Please provide a valid email address.',
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        try {
            $subscriber = NewsletterSubscriber::create([
                'email' => $request->email,
                'name' => $request->name,
                'status' => 'active',
                'subscribed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'source' => $request->source ?? 'homepage',
            ]);

            \Log::info('Newsletter subscription successful', ['subscriber_id' => $subscriber->id]);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for subscribing to our newsletter!',
                ]);
            }

            return back()->with('success', 'Thank you for subscribing to our newsletter!');

        } catch (\Exception $e) {
            \Log::error('Newsletter subscription error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.',
                ], 500);
            }

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:newsletter_subscribers,email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $subscriber = NewsletterSubscriber::where('email', $request->email)->first();

        if ($subscriber) {
            $subscriber->unsubscribe();
            return back()->with('success', 'You have been unsubscribed from our newsletter.');
        }

        return back()->with('error', 'Email address not found.');
    }
}
