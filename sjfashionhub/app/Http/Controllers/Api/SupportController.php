<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    /**
     * Get ticket categories
     */
    public function categories(Request $request)
    {
        $categories = [
            ['id' => 1, 'name' => 'Order Issues', 'description' => 'Problems with orders, payments, delivery'],
            ['id' => 2, 'name' => 'Product Issues', 'description' => 'Product quality, defects, returns'],
            ['id' => 3, 'name' => 'Account Issues', 'description' => 'Login problems, profile updates'],
            ['id' => 4, 'name' => 'Technical Issues', 'description' => 'App bugs, website problems'],
            ['id' => 5, 'name' => 'Billing Issues', 'description' => 'Payment problems, refunds'],
            ['id' => 6, 'name' => 'General Inquiry', 'description' => 'General questions and feedback'],
            ['id' => 7, 'name' => 'Other', 'description' => 'Other issues not listed above']
        ];

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get ticket priorities
     */
    public function priorities(Request $request)
    {
        $priorities = [
            ['id' => 1, 'name' => 'Low', 'description' => 'General questions, non-urgent issues'],
            ['id' => 2, 'name' => 'Medium', 'description' => 'Standard issues requiring attention'],
            ['id' => 3, 'name' => 'High', 'description' => 'Important issues affecting service'],
            ['id' => 4, 'name' => 'Urgent', 'description' => 'Critical issues requiring immediate attention']
        ];

        return response()->json([
            'success' => true,
            'data' => $priorities
        ]);
    }

    /**
     * Get user's tickets
     */
    public function ticketList(Request $request)
    {
        $user = $request->user();
        
        $query = SupportTicket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $tickets = $query->paginate($request->get('per_page', 15));

        $formattedTickets = $tickets->getCollection()->map(function ($ticket) {
            return $this->formatTicket($ticket);
        });

        return response()->json([
            'success' => true,
            'data' => $formattedTickets,
            'pagination' => [
                'current_page' => $tickets->currentPage(),
                'last_page' => $tickets->lastPage(),
                'per_page' => $tickets->perPage(),
                'total' => $tickets->total(),
            ]
        ]);
    }

    /**
     * Create new ticket
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|between:1,7',
            'priority_id' => 'required|integer|between:1,4',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();

            // Handle file uploads
            $attachmentPaths = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('ticket_attachments', 'public');
                    $attachmentPaths[] = [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType()
                    ];
                }
            }

            // Get category and priority names
            $categories = [
                1 => 'Order Issues',
                2 => 'Product Issues',
                3 => 'Account Issues',
                4 => 'Technical Issues',
                5 => 'Billing Issues',
                6 => 'General Inquiry',
                7 => 'Other'
            ];

            $priorities = [
                1 => 'Low',
                2 => 'Medium',
                3 => 'High',
                4 => 'Urgent'
            ];

            // Create ticket
            $ticket = SupportTicket::create([
                'user_id' => $user->id,
                'ticket_number' => 'TKT-' . time() . '-' . rand(1000, 9999),
                'category_id' => $request->category_id,
                'category_name' => $categories[$request->category_id],
                'priority_id' => $request->priority_id,
                'priority_name' => $priorities[$request->priority_id],
                'subject' => $request->subject,
                'message' => $request->message,
                'attachments' => $attachmentPaths,
                'status' => 'open'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Support ticket created successfully',
                'data' => $this->formatTicket($ticket)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create support ticket',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show ticket details
     */
    public function show(Request $request)
    {
        $ticketId = $request->get('ticket_id');
        
        if (!$ticketId) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket ID is required'
            ], 400);
        }

        $ticket = SupportTicket::where('id', $ticketId)
            ->where('user_id', $request->user()->id)
            ->with('replies')
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticketData = $this->formatTicket($ticket, true);
        
        // Add replies
        $ticketData['replies'] = $ticket->replies->map(function ($reply) {
            return $this->formatTicketReply($reply);
        });

        return response()->json([
            'success' => true,
            'data' => $ticketData
        ]);
    }

    /**
     * Reply to ticket
     */
    public function reply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:support_tickets,id',
            'message' => 'required|string|max:2000',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $ticket = SupportTicket::where('id', $request->ticket_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        if ($ticket->status === 'closed') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot reply to closed ticket'
            ], 400);
        }

        try {
            // Handle file uploads
            $attachmentPaths = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('ticket_attachments', 'public');
                    $attachmentPaths[] = [
                        'path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType()
                    ];
                }
            }

            // Create reply
            $reply = TicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id' => $request->user()->id,
                'message' => $request->message,
                'attachments' => $attachmentPaths,
                'is_admin' => false
            ]);

            // Update ticket status
            $ticket->update([
                'status' => 'awaiting_response',
                'last_reply_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reply added successfully',
                'data' => $this->formatTicketReply($reply)
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add reply',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format ticket data for API response
     */
    private function formatTicket($ticket, $detailed = false)
    {
        $data = [
            'id' => $ticket->id,
            'ticket_number' => $ticket->ticket_number,
            'subject' => $ticket->subject,
            'category' => $ticket->category_name,
            'priority' => $ticket->priority_name,
            'status' => $ticket->status,
            'created_at' => $ticket->created_at->format('Y-m-d H:i:s'),
            'last_reply_at' => $ticket->last_reply_at ? $ticket->last_reply_at->format('Y-m-d H:i:s') : null
        ];

        if ($detailed) {
            $data['message'] = $ticket->message;
            $data['attachments'] = collect($ticket->attachments ?? [])->map(function ($attachment) {
                return [
                    'url' => asset('storage/' . $attachment['path']),
                    'name' => $attachment['original_name'],
                    'size' => $attachment['size'],
                    'type' => $attachment['mime_type']
                ];
            })->toArray();
        }

        return $data;
    }

    /**
     * Format ticket reply data for API response
     */
    private function formatTicketReply($reply)
    {
        $attachments = collect($reply->attachments ?? [])->map(function ($attachment) {
            return [
                'url' => asset('storage/' . $attachment['path']),
                'name' => $attachment['original_name'],
                'size' => $attachment['size'],
                'type' => $attachment['mime_type']
            ];
        })->toArray();

        return [
            'id' => $reply->id,
            'message' => $reply->message,
            'attachments' => $attachments,
            'is_admin' => $reply->is_admin,
            'author' => $reply->is_admin ? 'Support Team' : $reply->user->name,
            'created_at' => $reply->created_at->format('Y-m-d H:i:s')
        ];
    }
}
