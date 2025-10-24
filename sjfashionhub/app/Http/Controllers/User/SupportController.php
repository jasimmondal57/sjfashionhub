<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use App\Mail\ContactReplyNotification;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    /**
     * Display user's support tickets
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get user's tickets based on email (for both logged in and guest submissions)
        $query = Contact::where('email', $user->email)
                        ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $tickets = $query->paginate(10);

        return view('user.support.index', compact('tickets'));
    }

    /**
     * Display a specific support ticket
     */
    public function show(Contact $contact)
    {
        $user = Auth::user();

        // Ensure user can only view their own tickets
        if ($contact->email !== $user->email) {
            abort(403, 'You can only view your own support tickets.');
        }

        // Load replies with user relationship
        $contact->load(['replies.user', 'resolvedBy']);

        return view('user.support.show', compact('contact'));
    }

    /**
     * Add a reply to the support ticket
     */
    public function reply(Request $request, Contact $contact)
    {
        $user = Auth::user();

        // Ensure user can only reply to their own tickets
        if ($contact->email !== $user->email) {
            abort(403, 'You can only reply to your own support tickets.');
        }

        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        // Create the reply
        $reply = ContactReply::create([
            'contact_id' => $contact->id,
            'user_id' => null, // User replies don't have user_id (admin field)
            'message' => $request->message,
            'sender_type' => 'user',
            'sender_name' => $user->name,
            'sender_email' => $user->email,
            'is_internal_note' => false,
        ]);

        // Update contact status to in_progress if it was resolved
        if ($contact->status === 'resolved') {
            $contact->markAsInProgress();
        }

        // Send email notification to all admin users (same as order emails)
        try {
            // Configure mail settings from database
            MailConfigService::configure();

            $adminEmails = User::where('role', 'admin')->orWhere('role', 'super_admin')->pluck('email')->toArray();

            foreach ($adminEmails as $adminEmail) {
                try {
                    Mail::to($adminEmail)->send(new ContactReplyNotification($contact, $reply, 'admin'));
                } catch (\Exception $e) {
                    \Log::error('Failed to send reply notification to admin', [
                        'contact_id' => $contact->id,
                        'reply_id' => $reply->id,
                        'admin_email' => $adminEmail,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get admin emails for reply notification', [
                'contact_id' => $contact->id,
                'reply_id' => $reply->id,
                'error' => $e->getMessage()
            ]);
        }

        return back()->with('success', 'Your reply has been sent successfully. Our support team will respond soon.');
    }
}
