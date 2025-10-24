<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppConversation;
use App\Models\WhatsAppCatalogProduct;
use App\Models\WhatsAppOrder;
use App\Models\Product;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppManagementController extends Controller
{
    protected $whatsappService;

    public function __construct()
    {
        $this->whatsappService = new WhatsAppService();
    }

    /**
     * Dashboard - Overview of WhatsApp activity
     */
    public function dashboard()
    {
        $stats = [
            'total_messages' => WhatsAppMessage::count(),
            'messages_today' => WhatsAppMessage::whereDate('created_at', today())->count(),
            'delivered_today' => WhatsAppMessage::whereDate('delivered_at', today())->count(),
            'failed_today' => WhatsAppMessage::whereDate('failed_at', today())->count(),
            'open_conversations' => WhatsAppConversation::open()->count(),
            'unread_messages' => WhatsAppConversation::where('unread_count', '>', 0)->sum('unread_count'),
            'pending_orders' => WhatsAppOrder::pending()->count(),
            'catalog_products' => WhatsAppCatalogProduct::synced()->count(),
        ];

        // Messages by category (last 7 days)
        $messagesByCategory = WhatsAppMessage::select('category', DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('category')
            ->get();

        // Messages by day (last 7 days)
        $messagesByDay = WhatsAppMessage::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent messages
        $recentMessages = WhatsAppMessage::with(['user', 'order'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.whatsapp.dashboard', compact(
            'stats',
            'messagesByCategory',
            'messagesByDay',
            'recentMessages'
        ));
    }

    /**
     * Message Logs - All sent/received messages
     */
    public function messages(Request $request)
    {
        $query = WhatsAppMessage::with(['user', 'order', 'returnOrder']);

        // Filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('direction')) {
            $query->where('direction', $request->direction);
        }

        if ($request->filled('phone')) {
            $query->where('phone_number', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $messages = $query->latest()->paginate(50);

        return view('admin.whatsapp.messages.index', compact('messages'));
    }

    /**
     * View single message details
     */
    public function showMessage(WhatsAppMessage $message)
    {
        $message->load(['user', 'order', 'returnOrder', 'conversation']);
        
        return view('admin.whatsapp.messages.show', compact('message'));
    }

    /**
     * Conversations - Chat inbox
     */
    public function conversations(Request $request)
    {
        $query = WhatsAppConversation::with(['user', 'assignedTo']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('unread_only')) {
            $query->where('unread_count', '>', 0);
        }

        $conversations = $query->latest('last_message_at')->paginate(20);

        return view('admin.whatsapp.conversations.index', compact('conversations'));
    }

    /**
     * View conversation and chat
     */
    public function showConversation(WhatsAppConversation $conversation)
    {
        $conversation->load(['user', 'assignedTo']);
        
        $messages = WhatsAppMessage::where('phone_number', $conversation->phone_number)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark as read
        $conversation->markAsRead();

        return view('admin.whatsapp.conversations.show', compact('conversation', 'messages'));
    }

    /**
     * Send message in conversation
     */
    public function sendMessage(Request $request, WhatsAppConversation $conversation)
    {
        $request->validate([
            'message' => 'required|string|max:4096',
        ]);

        try {
            // Send via WhatsApp API
            $response = $this->whatsappService->sendMessage(
                $conversation->phone_number,
                $request->message
            );

            // Log the message
            $message = WhatsAppMessage::create([
                'message_id' => $response['messages'][0]['id'] ?? null,
                'direction' => 'outbound',
                'type' => 'text',
                'status' => 'sent',
                'phone_number' => $conversation->phone_number,
                'user_id' => $conversation->user_id,
                'category' => 'support',
                'content' => $request->message,
                'sent_at' => now(),
            ]);

            // Update conversation
            $conversation->updateLastMessage($message);

            return back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }

    /**
     * Assign conversation to admin
     */
    public function assignConversation(Request $request, WhatsAppConversation $conversation)
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $conversation->update([
            'assigned_to' => $request->assigned_to,
        ]);

        return back()->with('success', 'Conversation assigned successfully!');
    }

    /**
     * Close conversation
     */
    public function closeConversation(WhatsAppConversation $conversation)
    {
        $conversation->update(['status' => 'closed']);

        return back()->with('success', 'Conversation closed!');
    }

    /**
     * WhatsApp Orders
     */
    public function orders(Request $request)
    {
        $query = WhatsAppOrder::with(['user', 'order']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.whatsapp.orders.index', compact('orders'));
    }

    /**
     * View WhatsApp order details
     */
    public function showOrder(WhatsAppOrder $whatsappOrder)
    {
        $whatsappOrder->load(['user', 'order']);
        
        return view('admin.whatsapp.orders.show', compact('whatsappOrder'));
    }

    /**
     * Confirm WhatsApp order and create in system
     */
    public function confirmOrder(Request $request, WhatsAppOrder $whatsappOrder)
    {
        // This will be implemented to create actual order
        // For now, just mark as confirmed
        $whatsappOrder->confirm();

        return back()->with('success', 'Order confirmed!');
    }

    /**
     * Catalog Products
     */
    public function catalog(Request $request)
    {
        $query = WhatsAppCatalogProduct::with('product');

        if ($request->filled('sync_status')) {
            $query->where('sync_status', $request->sync_status);
        }

        $catalogProducts = $query->latest()->paginate(50);

        // Products not in catalog
        $unsyncedProducts = Product::whereNotIn('id', function($query) {
            $query->select('product_id')->from('whatsapp_catalog_products');
        })->count();

        return view('admin.whatsapp.catalog.index', compact('catalogProducts', 'unsyncedProducts'));
    }

    /**
     * Sync product to catalog
     */
    public function syncProduct(Product $product)
    {
        try {
            // Create or get catalog product record
            $catalogProduct = WhatsAppCatalogProduct::firstOrCreate(
                ['product_id' => $product->id],
                ['retailer_id' => $product->sku, 'sync_status' => 'pending']
            );

            // Sync to Meta (this will be implemented)
            // For now, just mark as synced
            $catalogProduct->markAsSynced('META_' . $product->id);

            return back()->with('success', 'Product synced to catalog!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to sync product: ' . $e->getMessage());
        }
    }

    /**
     * Sync all products to catalog
     */
    public function syncAllProducts()
    {
        $products = Product::whereNotIn('id', function($query) {
            $query->select('product_id')->from('whatsapp_catalog_products');
        })->get();

        $synced = 0;
        foreach ($products as $product) {
            try {
                WhatsAppCatalogProduct::create([
                    'product_id' => $product->id,
                    'retailer_id' => $product->sku,
                    'sync_status' => 'pending',
                ]);
                $synced++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return back()->with('success', "$synced products queued for sync!");
    }

    /**
     * Sync messages from Meta API (backfill historical messages)
     */
    public function syncMessagesFromMeta(Request $request)
    {
        try {
            $accessToken = config('services.whatsapp.access_token');
            $phoneNumberId = config('services.whatsapp.phone_number_id');
            $baseUrl = config('services.whatsapp.base_url', 'https://graph.facebook.com/v18.0');

            if (!$accessToken || !$phoneNumberId) {
                return back()->with('error', 'WhatsApp API credentials not configured');
            }

            // Get date range from request (default: last 7 days)
            $daysBack = $request->input('days', 7);
            $limit = $request->input('limit', 100);

            Log::info('Starting WhatsApp message sync from Meta', [
                'days_back' => $daysBack,
                'limit' => $limit
            ]);

            // Note: Meta's WhatsApp Business API doesn't provide a direct endpoint to fetch sent messages
            // Messages are only available through webhooks in real-time
            // However, we can check for any messages in the webhook logs

            // Alternative approach: Sync from application logs
            $synced = $this->syncFromApplicationLogs($daysBack);

            if ($synced > 0) {
                return back()->with('success', "Successfully synced {$synced} messages from logs!");
            } else {
                return back()->with('info', 'No new messages found to sync. Note: Meta WhatsApp API only provides real-time message data via webhooks. Historical messages sent before the logging system was enabled cannot be retrieved.');
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp message sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Sync messages from Laravel application logs
     */
    private function syncFromApplicationLogs($daysBack = 7)
    {
        $synced = 0;
        $logFile = storage_path('logs/laravel.log');

        if (!file_exists($logFile)) {
            return 0;
        }

        try {
            // Read log file and look for WhatsApp send patterns
            $logs = file($logFile);
            $cutoffDate = now()->subDays($daysBack);

            foreach ($logs as $line) {
                // Look for WhatsApp API success responses in logs
                if (strpos($line, 'WhatsApp') !== false && strpos($line, 'sent successfully') !== false) {
                    // Try to extract phone number and message details from log
                    // This is a basic implementation - adjust based on your actual log format

                    if (preg_match('/phone["\s:]+([0-9]+)/', $line, $phoneMatch)) {
                        $phone = $phoneMatch[1];

                        // Check if message already exists
                        $exists = WhatsAppMessage::where('phone_number', $phone)
                            ->where('created_at', '>=', $cutoffDate)
                            ->exists();

                        if (!$exists) {
                            // Create basic message record
                            $user = User::where('phone', $phone)->first();

                            WhatsAppMessage::create([
                                'direction' => 'outbound',
                                'type' => 'template',
                                'status' => 'sent',
                                'phone_number' => $phone,
                                'user_id' => $user?->id,
                                'category' => 'notification',
                                'content' => 'Message sent (synced from logs)',
                                'sent_at' => now(),
                            ]);

                            $synced++;
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            Log::error('Failed to sync from logs', ['error' => $e->getMessage()]);
        }

        return $synced;
    }

    /**
     * Manual message entry (for backfilling)
     */
    public function createManualMessage(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|in:marketing,otp,notification,support,order',
            'status' => 'required|in:sent,delivered,read,failed',
            'sent_at' => 'nullable|date',
        ]);

        $user = User::where('phone', $validated['phone_number'])->first();

        $message = WhatsAppMessage::create([
            'direction' => 'outbound',
            'type' => 'template',
            'status' => $validated['status'],
            'phone_number' => $validated['phone_number'],
            'user_id' => $user?->id,
            'category' => $validated['category'],
            'content' => $validated['content'],
            'sent_at' => $validated['sent_at'] ?? now(),
            'delivered_at' => in_array($validated['status'], ['delivered', 'read']) ? now() : null,
            'read_at' => $validated['status'] === 'read' ? now() : null,
        ]);

        // Create/update conversation
        $conversation = WhatsAppConversation::firstOrCreate(
            ['phone_number' => $validated['phone_number']],
            ['status' => 'open', 'last_message_at' => now()]
        );

        $conversation->updateLastMessage($message);

        return back()->with('success', 'Message added successfully!');
    }
}

