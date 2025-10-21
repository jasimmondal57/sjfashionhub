<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Mail\ContactReplyNotification;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by ticket ID
        if ($request->has('ticket_id') && $request->ticket_id !== '') {
            $query->where('id', $request->ticket_id);
        }

        // General search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%"); // Also search by ID in general search
            });
        }

        $contacts = $query->with('resolvedBy')
                         ->orderBy('created_at', 'desc')
                         ->paginate(20);

        $statusCounts = [
            'all' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'in_progress' => Contact::where('status', 'in_progress')->count(),
            'resolved' => Contact::where('status', 'resolved')->count(),
            'closed' => Contact::where('status', 'closed')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'statusCounts'));
    }

    /**
     * Display the specified contact message.
     */
    public function show(Contact $contact)
    {
        $contact->load(['resolvedBy', 'replies.user']);
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the contact status.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ];

        // If marking as resolved, set resolved timestamp and user
        if ($request->status === 'resolved' && $contact->status !== 'resolved') {
            $updateData['resolved_at'] = now();
            $updateData['resolved_by'] = Auth::id();
        }

        $contact->update($updateData);

        return back()->with('success', 'Contact status updated successfully.');
    }

    /**
     * Remove the specified contact message.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Delete multiple contact messages
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:contacts,id'
        ]);

        $count = Contact::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.contacts.index')
                        ->with('success', "Successfully deleted {$count} contact message(s).");
    }

    /**
     * Delete all messages on current page only
     */
    public function deletePageMessages(Request $request)
    {
        $query = Contact::query();

        // Apply same filters as index
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Get the current page number
        $page = $request->get('page', 1);
        $perPage = 15; // Must match the pagination in index()

        // Calculate offset for current page
        $offset = ($page - 1) * $perPage;

        // Get only the IDs for the current page
        $ids = $query->orderBy('id', 'desc')
                     ->offset($offset)
                     ->limit($perPage)
                     ->pluck('id')
                     ->toArray();

        // Delete only the messages on current page
        $count = Contact::whereIn('id', $ids)->delete();

        return redirect()->route('admin.contacts.index')
                        ->with('success', "Successfully deleted {$count} contact message(s) from this page.");
    }

    /**
     * Delete all messages across all pages (respecting filters)
     */
    public function deleteAllPages(Request $request)
    {
        $query = Contact::query();

        // Apply same filters as index
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Delete all messages matching the filters
        $count = $query->delete();

        return redirect()->route('admin.contacts.index')
                        ->with('success', "Successfully deleted {$count} contact message(s) across all pages.");
    }

    /**
     * Delete all contact messages (ignoring filters)
     */
    public function deleteAllMessages()
    {
        $count = Contact::count();
        Contact::truncate();

        return redirect()->route('admin.contacts.index')
                        ->with('success', "Successfully deleted all {$count} contact message(s).");
    }

    /**
     * Mark contact as resolved
     */
    public function markAsResolved(Contact $contact)
    {
        $contact->markAsResolved(Auth::id());
        return back()->with('success', 'Contact marked as resolved.');
    }

    /**
     * Mark contact as in progress
     */
    public function markAsInProgress(Contact $contact)
    {
        $contact->markAsInProgress();
        return back()->with('success', 'Contact marked as in progress.');
    }

    /**
     * Add a reply to the contact
     */
    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'is_internal_note' => 'boolean',
            'action' => 'required|in:reply,reply_and_resolve'
        ]);

        // Create the reply
        $reply = ContactReply::create([
            'contact_id' => $contact->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender_type' => 'admin',
            'is_internal_note' => $request->boolean('is_internal_note', false),
        ]);

        // Send email notification to customer (only if not an internal note)
        if (!$reply->is_internal_note) {
            try {
                // Configure mail settings from database
                MailConfigService::configure();
                Mail::to($contact->email)->send(new ContactReplyNotification($contact, $reply, 'user'));
            } catch (\Exception $e) {
                \Log::error('Failed to send reply notification to customer', [
                    'contact_id' => $contact->id,
                    'reply_id' => $reply->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Update contact status if requested
        if ($request->action === 'reply_and_resolve') {
            $contact->markAsResolved(Auth::id());
            $successMessage = $reply->is_internal_note
                ? 'Internal note added and contact marked as resolved.'
                : 'Reply sent and contact marked as resolved.';
        } else {
            // Mark as in progress if it was new
            if ($contact->status === 'new') {
                $contact->markAsInProgress();
            }
            $successMessage = $reply->is_internal_note
                ? 'Internal note added successfully.'
                : 'Reply sent successfully.';
        }

        return back()->with('success', $successMessage);
    }
}
