<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Search by email or name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('subscribed_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('subscribed_at', '<=', $request->date_to . ' 23:59:59');
        }

        $subscribers = $query->latest('subscribed_at')->paginate(20);
        $stats = NewsletterSubscriber::getStats();

        return view('admin.newsletter-subscribers.index', compact('subscribers', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsletterSubscriber $newsletterSubscriber)
    {
        return view('admin.newsletter-subscribers.show', compact('newsletterSubscriber'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsletterSubscriber $newsletterSubscriber)
    {
        return view('admin.newsletter-subscribers.edit', compact('newsletterSubscriber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsletterSubscriber $newsletterSubscriber)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email,' . $newsletterSubscriber->id,
            'name' => 'nullable|string|max:255',
            'status' => 'required|in:active,unsubscribed,bounced',
            'source' => 'nullable|string|max:255',
            'preferences' => 'nullable|array',
        ]);

        $newsletterSubscriber->update($validated);

        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', 'Subscriber updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->delete();

        return redirect()->route('admin.newsletter-subscribers.index')
            ->with('success', 'Subscriber deleted successfully.');
    }

    /**
     * Unsubscribe a subscriber
     */
    public function unsubscribe(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->unsubscribe();

        return response()->json([
            'success' => true,
            'message' => 'Subscriber unsubscribed successfully.'
        ]);
    }

    /**
     * Resubscribe a subscriber
     */
    public function resubscribe(NewsletterSubscriber $newsletterSubscriber)
    {
        $newsletterSubscriber->resubscribe();

        return response()->json([
            'success' => true,
            'message' => 'Subscriber resubscribed successfully.'
        ]);
    }

    /**
     * Export subscribers
     */
    public function export(Request $request)
    {
        $query = NewsletterSubscriber::query();

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $subscribers = $query->latest('subscribed_at')->get();

        $filename = 'newsletter_subscribers_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($subscribers) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Email',
                'Name',
                'Status',
                'Source',
                'Subscribed At',
                'Unsubscribed At',
                'IP Address',
            ]);

            // Add data rows
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->id,
                    $subscriber->email,
                    $subscriber->name,
                    $subscriber->status,
                    $subscriber->source,
                    $subscriber->subscribed_at?->format('Y-m-d H:i:s'),
                    $subscriber->unsubscribed_at?->format('Y-m-d H:i:s'),
                    $subscriber->ip_address,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
