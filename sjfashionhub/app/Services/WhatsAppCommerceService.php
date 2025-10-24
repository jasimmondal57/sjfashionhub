<?php

namespace App\Services;

use App\Models\WhatsAppCart;
use App\Models\WhatsAppCommerceSession;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppConversation;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CommunicationSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WhatsAppCommerceService
{
    protected $whatsappService;
    protected $phoneNumberId;
    protected $accessToken;

    public function __construct()
    {
        $this->whatsappService = new WhatsAppService();

        // Get WhatsApp credentials from database
        $settings = CommunicationSetting::where('provider', 'whatsapp')
            ->where('service', 'whatsapp_business')
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->decrypted_value];
            });

        $this->phoneNumberId = $settings['phone_number'] ?? config('services.whatsapp.phone_number_id');
        $this->accessToken = $settings['api_key'] ?? config('services.whatsapp.access_token');
    }

    /**
     * Get user by phone number - prefer user with real email over temp email
     * This ensures we always get the correct user account
     */
    protected function getUserByPhone($phoneNumber)
    {
        $users = User::where('phone', $phoneNumber)->get();

        if ($users->isEmpty()) {
            return null;
        }

        // Prefer user with real email (not temp email)
        return $users->first(function ($u) {
            return !str_contains($u->email, '@whatsapp.temp') && !str_contains($u->email, '@mobile.local');
        }) ?? $users->first();
    }

    /**
     * Handle incoming text message
     */
    public function handleTextMessage($from, $text, $contactName, $messageId)
    {
        try {
            // Log incoming message
            $this->logMessage($from, $text, 'inbound', $contactName, $messageId);

            // Get or create session
            $session = WhatsAppCommerceSession::getSession($from);

            // Parse command
            $command = strtolower(trim($text));

            // Check if user is in a specific flow (collecting data)
            if (in_array($session->current_step, ['awaiting_name', 'awaiting_email', 'awaiting_address', 'awaiting_city', 'awaiting_pincode'])) {
                $this->handleContextualMessage($from, $text, $session);
                return;
            }

            // Handle commands - ANY message triggers auto-reply
            if (str_contains($command, 'hi') || str_contains($command, 'hello') || str_contains($command, 'start')) {
                $this->sendAutoReplyWithBrowseButton($from, $contactName);
            } elseif (str_contains($command, 'menu') || str_contains($command, 'browse') || str_contains($command, 'shop')) {
                $this->sendMainMenu($from);
            } elseif (str_contains($command, 'cart')) {
                $this->sendCart($from);
            } elseif (str_contains($command, 'checkout')) {
                $this->startCheckout($from);
            } elseif (str_contains($command, 'help')) {
                $this->sendHelpMessage($from);
            } elseif (str_contains($command, 'track') || str_contains($command, 'order')) {
                $this->sendOrderTracking($from);
            } else {
                // ANY other message → Auto-reply with browse button
                $this->sendAutoReplyWithBrowseButton($from, $contactName);
            }

        } catch (\Exception $e) {
            Log::error('Error handling WhatsApp text message', [
                'from' => $from,
                'error' => $e->getMessage()
            ]);

            $this->sendTextMessage($from, "Sorry, something went wrong. Please try again or type 'help' for assistance.");
        }
    }

    /**
     * Handle contextual message based on current session step
     */
    protected function handleContextualMessage($from, $text, $session)
    {
        switch ($session->current_step) {
            case 'awaiting_name':
                $this->handleNameInput($from, $text, $session);
                break;

            case 'awaiting_email':
                $this->handleEmailInput($from, $text, $session);
                break;

            case 'awaiting_address':
                $this->handleAddressInput($from, $text, $session);
                break;

            case 'awaiting_city':
                $this->handleCityInput($from, $text, $session);
                break;

            case 'awaiting_pincode':
                $this->handlePincodeInput($from, $text, $session);
                break;

            default:
                // Default response - send auto-reply
                $this->sendAutoReplyWithBrowseButton($from, null);
        }
    }

    /**
     * Send auto-reply with browse products button
     */
    protected function sendAutoReplyWithBrowseButton($from, $contactName)
    {
        // Check if user exists
        $user = $this->getUserByPhone($from);

        if ($user) {
            // EXISTING USER - Personalized welcome with saved details
            $name = $user->name ?? $contactName ?? 'there';

            $message = "👋 Welcome back, *{$name}*! 🎉\n\n";
            $message .= "Great to see you again at *SJ Fashion Hub*!\n\n";

            // Show saved address if available
            if ($user->address && $user->city && $user->pincode) {
                $message .= "📍 *Your Saved Address:*\n";
                $message .= "{$user->address}\n";
                $message .= "{$user->city}";
                if ($user->state) {
                    $message .= ", {$user->state}";
                }
                $message .= " - {$user->pincode}\n\n";
            }

            $message .= "🛍️ Ready to shop? Browse our latest collection!";
        } else {
            // NEW USER - Regular welcome
            $name = $contactName ?? 'there';

            $message = "👋 Hi {$name}! Welcome to *SJ Fashion Hub*!\n\n";
            $message .= "🛍️ Discover the latest fashion trends!\n\n";
            $message .= "Click the button below to browse our products:";
        }

        $this->sendButtons($from, $message, [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'browse_products',
                    'title' => '🛍️ Browse Products'
                ]
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'view_cart',
                    'title' => '🛒 View Cart'
                ]
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'my_orders',
                    'title' => '📦 My Orders'
                ]
            ]
        ]);
    }

    /**
     * Send welcome message
     */
    protected function sendWelcomeMessage($from, $contactName)
    {
        $name = $contactName ?? 'there';
        
        $message = "👋 Hi {$name}! Welcome to *SJ Fashion Hub*!\n\n";
        $message .= "🛍️ Shop the latest fashion trends directly on WhatsApp!\n\n";
        $message .= "Here's what you can do:\n";
        $message .= "• Type *menu* to browse products\n";
        $message .= "• Type *cart* to view your cart\n";
        $message .= "• Type *help* for more options\n\n";
        $message .= "Let's get started! 🎉";

        $this->sendTextMessage($from, $message);
    }

    /**
     * Send main menu with categories
     */
    protected function sendMainMenu($from)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->limit(10)
            ->get();

        if ($categories->isEmpty()) {
            $this->sendTextMessage($from, "Sorry, no categories available at the moment.");
            return;
        }

        // Build interactive list message
        $sections = [[
            'title' => 'Shop by Category',
            'rows' => []
        ]];

        foreach ($categories as $category) {
            $productCount = $category->products()->where('status', 'active')->count();
            
            $sections[0]['rows'][] = [
                'id' => 'cat_' . $category->id,
                'title' => $category->name,
                'description' => "{$productCount} products"
            ];
        }

        // Add special options
        $sections[] = [
            'title' => 'Quick Actions',
            'rows' => [
                [
                    'id' => 'view_cart',
                    'title' => '🛒 View Cart',
                    'description' => 'See items in your cart'
                ],
                [
                    'id' => 'my_orders',
                    'title' => '📦 My Orders',
                    'description' => 'Track your orders'
                ]
            ]
        ];

        $this->sendInteractiveList($from, 'Browse Products', 'Select a category to view products', 'View Categories', $sections);
    }

    /**
     * Handle list reply (category selection, product selection, etc.)
     */
    public function handleListReply($from, $selectedId, $contactName, $messageId)
    {
        try {
            Log::info('List reply received', ['from' => $from, 'selected_id' => $selectedId]);

            if (str_starts_with($selectedId, 'cat_')) {
                // Category selected
                $categoryId = str_replace('cat_', '', $selectedId);
                $this->sendCategoryProducts($from, $categoryId);
            } elseif (str_starts_with($selectedId, 'prod_')) {
                // Product selected
                $productId = str_replace('prod_', '', $selectedId);
                $this->sendProductDetails($from, $productId);
            } elseif ($selectedId === 'view_cart') {
                $this->sendCart($from);
            } elseif ($selectedId === 'my_orders') {
                $this->sendOrderTracking($from);
            }

        } catch (\Exception $e) {
            Log::error('Error handling list reply', ['error' => $e->getMessage()]);
            $this->sendTextMessage($from, "Sorry, something went wrong. Please try again.");
        }
    }

    /**
     * Handle button reply (add to cart, checkout, etc.)
     */
    public function handleButtonReply($from, $selectedId, $contactName, $messageId)
    {
        try {
            Log::info('Button reply received', ['from' => $from, 'selected_id' => $selectedId]);

            if (str_starts_with($selectedId, 'add_')) {
                // Add to cart
                $productId = str_replace('add_', '', $selectedId);
                $this->addToCart($from, $productId);
            } elseif (str_starts_with($selectedId, 'remove_')) {
                // Remove from cart
                $productId = str_replace('remove_', '', $selectedId);
                $this->removeFromCart($from, $productId);
            } elseif ($selectedId === 'browse_products') {
                $this->sendMainMenu($from);
            } elseif ($selectedId === 'view_cart') {
                $this->sendCart($from);
            } elseif ($selectedId === 'my_orders') {
                $this->sendOrderTracking($from);
            } elseif ($selectedId === 'checkout') {
                $this->startCheckout($from);
            } elseif ($selectedId === 'continue_shopping') {
                $this->sendMainMenu($from);
            } elseif ($selectedId === 'confirm_details') {
                // User confirmed their details, show payment options
                $session = WhatsAppCommerceSession::getSession($from);
                $this->showPaymentOptions($from, $session);
            } elseif ($selectedId === 'edit_details') {
                // User wants to edit details, restart registration
                $this->sendTextMessage($from, "Let's start over.\n\n📝 Please send your full name:");
                $session = WhatsAppCommerceSession::getSession($from);
                $session->updateStep('awaiting_name');
            } elseif ($selectedId === 'payment_cod') {
                // Show order confirmation for COD
                $this->showOrderConfirmation($from, 'cod');
            } elseif ($selectedId === 'payment_online') {
                // Show order confirmation for online payment
                $this->showOrderConfirmation($from, 'online');
            } elseif (str_starts_with($selectedId, 'confirm_order_')) {
                // Final order confirmation
                $paymentMethod = str_replace('confirm_order_', '', $selectedId);
                $this->confirmOrder($from, $paymentMethod);
            } elseif ($selectedId === 'cancel_order') {
                $this->cancelCheckout($from);
            } elseif ($selectedId === 'confirm_address') {
                // Registered user confirmed saved address
                $this->showPaymentOptions($from, WhatsAppCommerceSession::getSession($from));
            } elseif ($selectedId === 'change_address') {
                // Registered user wants to change address
                $this->sendTextMessage($from, "📍 Please send your new delivery address:");
                $session = WhatsAppCommerceSession::getSession($from);
                $session->updateStep('awaiting_address');
            }

        } catch (\Exception $e) {
            Log::error('Error handling button reply', ['error' => $e->getMessage()]);
            $this->sendTextMessage($from, "Sorry, something went wrong. Please try again.");
        }
    }

    /**
     * Handle button click
     */
    public function handleButtonClick($from, $payload, $contactName, $messageId)
    {
        $this->handleButtonReply($from, $payload, $contactName, $messageId);
    }

    /**
     * Handle catalog order (when customer orders from WhatsApp catalog)
     */
    public function handleCatalogOrder($from, $productItems, $contactName, $messageId)
    {
        try {
            Log::info('Processing catalog order', [
                'from' => $from,
                'items' => $productItems
            ]);

            // Clear existing cart
            WhatsAppCart::clearCart($from);

            // Add items to cart
            foreach ($productItems as $item) {
                $productRetailerId = $item['product_retailer_id'] ?? null;
                $quantity = $item['quantity'] ?? 1;

                // Find product by retailer_id (which is our product ID)
                if ($productRetailerId) {
                    WhatsAppCart::addItem($from, $productRetailerId, $quantity);
                }
            }

            // Send cart and ask for checkout
            $this->sendCart($from, true);

        } catch (\Exception $e) {
            Log::error('Error handling catalog order', ['error' => $e->getMessage()]);
            $this->sendTextMessage($from, "Sorry, we couldn't process your order. Please try again.");
        }
    }

    /**
     * Send help message
     */
    protected function sendHelpMessage($from)
    {
        $message = "📱 *SJ Fashion Hub - Help*\n\n";
        $message .= "Here are the commands you can use:\n\n";
        $message .= "🛍️ *menu* - Browse products by category\n";
        $message .= "🛒 *cart* - View your shopping cart\n";
        $message .= "💳 *checkout* - Proceed to checkout\n";
        $message .= "📦 *orders* - Track your orders\n";
        $message .= "❓ *help* - Show this help message\n\n";
        $message .= "Need assistance? Call us at +91-XXXXXXXXXX";

        $this->sendTextMessage($from, $message);
    }

    /**
     * Log message to database
     */
    protected function logMessage($from, $content, $direction, $contactName = null, $messageId = null)
    {
        try {
            // Find or create user
            $user = User::where('phone', $from)->first();

            WhatsAppMessage::create([
                'direction' => $direction,
                'type' => 'text',
                'status' => $direction === 'outbound' ? 'sent' : 'received',
                'phone_number' => $from,
                'user_id' => $user?->id,
                'category' => 'commerce',
                'content' => $content,
                'sent_at' => $direction === 'outbound' ? now() : null,
                'delivered_at' => $direction === 'inbound' ? now() : null,
            ]);

            // Update or create conversation
            WhatsAppConversation::updateOrCreate(
                ['phone_number' => $from],
                [
                    'user_id' => $user?->id,
                    'customer_name' => $contactName ?? $user?->name,
                    'last_message_at' => now(),
                    'status' => 'open'
                ]
            );

        } catch (\Exception $e) {
            Log::error('Failed to log WhatsApp message', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Send category products
     */
    protected function sendCategoryProducts($from, $categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            $this->sendTextMessage($from, "Category not found.");
            return;
        }

        $products = $category->products()
            ->where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->limit(10)
            ->get();

        if ($products->isEmpty()) {
            $this->sendTextMessage($from, "No products available in this category.");
            return;
        }

        $sections = [[
            'title' => $category->name,
            'rows' => []
        ]];

        foreach ($products as $product) {
            $price = $product->sale_price ?? $product->price;

            $sections[0]['rows'][] = [
                'id' => 'prod_' . $product->id,
                'title' => substr($product->name, 0, 24),
                'description' => '₹' . number_format($price, 0)
            ];
        }

        $this->sendInteractiveList($from, $category->name, 'Select a product to view details', 'View Products', $sections);
    }

    /**
     * Send product details
     */
    protected function sendProductDetails($from, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            $this->sendTextMessage($from, "Product not found.");
            return;
        }

        $price = $product->sale_price ?? $product->price;
        $stock = $product->stock_quantity;

        $message = "*{$product->name}*\n\n";
        $message .= "💰 Price: ₹" . number_format($price, 0) . "\n";

        if ($product->sale_price) {
            $message .= "~~₹" . number_format($product->price, 0) . "~~\n";
        }

        $message .= "📦 Stock: " . ($stock > 0 ? "In Stock ({$stock} available)" : "Out of Stock") . "\n\n";

        if ($product->short_description) {
            $message .= strip_tags($product->short_description) . "\n\n";
        }

        // Send product image if available
        if ($product->images && is_array($product->images) && !empty($product->images)) {
            $imageUrl = url('storage/' . $product->images[0]);
            $this->sendImageMessage($from, $imageUrl, $message);
        } else {
            $this->sendTextMessage($from, $message);
        }

        // Send add to cart button
        if ($stock > 0) {
            $this->sendButtons($from, 'Add this product to your cart?', [
                [
                    'type' => 'reply',
                    'reply' => [
                        'id' => 'add_' . $product->id,
                        'title' => '🛒 Add to Cart'
                    ]
                ],
                [
                    'type' => 'reply',
                    'reply' => [
                        'id' => 'continue_shopping',
                        'title' => '◀️ Back to Menu'
                    ]
                ]
            ]);
        }
    }

    /**
     * Add product to cart
     */
    protected function addToCart($from, $productId, $quantity = 1)
    {
        try {
            $product = Product::find($productId);

            if (!$product) {
                $this->sendTextMessage($from, "Product not found.");
                return;
            }

            if ($product->stock_quantity < $quantity) {
                $this->sendTextMessage($from, "Sorry, insufficient stock available.");
                return;
            }

            WhatsAppCart::addItem($from, $productId, $quantity);

            $cartCount = WhatsAppCart::getCartCount($from);

            $message = "✅ *{$product->name}* added to cart!\n\n";
            $message .= "🛒 Cart: {$cartCount} item(s)\n\n";
            $message .= "What would you like to do next?";

            $this->sendButtons($from, $message, [
                [
                    'type' => 'reply',
                    'reply' => [
                        'id' => 'view_cart',
                        'title' => '🛒 View Cart'
                    ]
                ],
                [
                    'type' => 'reply',
                    'reply' => [
                        'id' => 'continue_shopping',
                        'title' => '🛍️ Keep Shopping'
                    ]
                ],
                [
                    'type' => 'reply',
                    'reply' => [
                        'id' => 'checkout',
                        'title' => '💳 Checkout'
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error adding to cart', ['error' => $e->getMessage()]);
            $this->sendTextMessage($from, "Sorry, couldn't add product to cart. Please try again.");
        }
    }

    /**
     * Remove product from cart
     */
    protected function removeFromCart($from, $productId)
    {
        WhatsAppCart::removeItem($from, $productId);
        $this->sendTextMessage($from, "✅ Item removed from cart.");
        $this->sendCart($from);
    }

    /**
     * Send cart details
     */
    protected function sendCart($from, $fromCatalogOrder = false)
    {
        $cartItems = WhatsAppCart::getCartItems($from);

        if ($cartItems->isEmpty()) {
            $this->sendTextMessage($from, "🛒 Your cart is empty.\n\nType 'menu' to start shopping!");
            return;
        }

        $message = "🛒 *Your Shopping Cart*\n\n";

        $total = 0;
        foreach ($cartItems as $item) {
            $subtotal = $item->price * $item->quantity;
            $total += $subtotal;

            $message .= "• {$item->product->name}\n";
            $message .= "  Qty: {$item->quantity} × ₹" . number_format($item->price, 0) . " = ₹" . number_format($subtotal, 0) . "\n\n";
        }

        $message .= "━━━━━━━━━━━━━━━━\n";
        $message .= "*Total: ₹" . number_format($total, 0) . "*\n\n";

        if ($fromCatalogOrder) {
            $message .= "Ready to checkout?";
        } else {
            $message .= "What would you like to do?";
        }

        $this->sendButtons($from, $message, [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'checkout',
                    'title' => '💳 Checkout'
                ]
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'continue_shopping',
                    'title' => '🛍️ Keep Shopping'
                ]
            ]
        ]);
    }

    /**
     * Start checkout process
     */
    protected function startCheckout($from)
    {
        $cartItems = WhatsAppCart::getCartItems($from);

        if ($cartItems->isEmpty()) {
            $this->sendTextMessage($from, "Your cart is empty. Add some products first!");
            return;
        }

        // Check if user exists
        $user = $this->getUserByPhone($from);

        if (!$user) {
            // NEW USER - Ask for registration
            $this->sendTextMessage($from, "To complete your order, please provide your details:\n\n📝 Send your full name:");

            $session = WhatsAppCommerceSession::getSession($from);
            $session->updateStep('awaiting_name');
            return;
        }

        // EXISTING USER - Check if address is saved
        if ($user->address && $user->city && $user->pincode) {
            // Show saved address for confirmation
            $this->showSavedAddress($from, $user);
        } else {
            // User exists but no address saved - ask for address
            $this->sendTextMessage($from, "Hi {$user->name}! 👋\n\nTo complete your order, please send your delivery address:");
            $session = WhatsAppCommerceSession::getSession($from);
            $session->updateStep('awaiting_address');
        }
    }

    /**
     * Show saved address and confirm
     */
    protected function showSavedAddress($from, $user)
    {
        $message = "📍 *Confirm Delivery Address*\n\n";
        $message .= "👤 {$user->name}\n";
        $message .= "📍 {$user->address}\n";
        $message .= "🏙️ {$user->city}";
        if ($user->state) {
            $message .= ", {$user->state}";
        }
        $message .= "\n📮 {$user->pincode}\n";
        $message .= "📱 {$user->phone}\n\n";
        $message .= "Deliver to this address?";

        $this->sendButtons($from, $message, [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'confirm_address',
                    'title' => '✅ Yes, Proceed'
                ]
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'change_address',
                    'title' => '📝 Change Address'
                ]
            ]
        ]);

        $session = WhatsAppCommerceSession::getSession($from);
        $session->updateStep('address_confirmation');
    }

    /**
     * Ask for delivery address
     */
    protected function askForAddress($from)
    {
        $this->sendTextMessage($from, "📍 Please send your complete delivery address:");

        $session = WhatsAppCommerceSession::getSession($from);
        $session->updateStep('awaiting_address');
    }

    /**
     * Handle name input (NEW USER FLOW - Step 1)
     */
    protected function handleNameInput($from, $text, $session)
    {
        $name = trim($text);

        if (strlen($name) < 2) {
            $this->sendTextMessage($from, "Please enter a valid name:");
            return;
        }

        $session->setData('name', $name);

        // Ask for email
        $this->sendTextMessage($from, "✅ Thanks {$name}!\n\n📧 Please send your email address:");
        $session->updateStep('awaiting_email');
    }

    /**
     * Handle email input (NEW USER FLOW - Step 2)
     */
    protected function handleEmailInput($from, $text, $session)
    {
        $email = trim($text);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->sendTextMessage($from, "Please enter a valid email address:");
            return;
        }

        $session->setData('email', $email);

        // Ask for address
        $this->sendTextMessage($from, "✅ Email saved!\n\n📍 Please send your complete delivery address:");
        $session->updateStep('awaiting_address');
    }

    /**
     * Handle address input (NEW USER FLOW - Step 3)
     */
    protected function handleAddressInput($from, $text, $session)
    {
        $address = trim($text);

        if (strlen($address) < 10) {
            $this->sendTextMessage($from, "Please provide a complete address:");
            return;
        }

        $session->setData('address', $address);

        // Ask for city
        $this->sendTextMessage($from, "✅ Address saved!\n\n🏙️ Please send your city name:");
        $session->updateStep('awaiting_city');
    }

    /**
     * Handle city input (NEW USER FLOW - Step 4)
     */
    protected function handleCityInput($from, $text, $session)
    {
        $city = trim($text);

        if (strlen($city) < 2) {
            $this->sendTextMessage($from, "Please enter a valid city name:");
            return;
        }

        $session->setData('city', $city);

        // Ask for pincode
        $this->sendTextMessage($from, "✅ City saved!\n\n📮 Please send your 6-digit pincode:");
        $session->updateStep('awaiting_pincode');
    }

    /**
     * Handle pincode input (NEW USER FLOW - Step 5)
     */
    protected function handlePincodeInput($from, $text, $session)
    {
        $pincode = trim($text);

        if (!preg_match('/^\d{6}$/', $pincode)) {
            $this->sendTextMessage($from, "Please enter a valid 6-digit pincode:");
            return;
        }

        $session->setData('pincode', $pincode);

        // Show address confirmation
        $this->showAddressConfirmation($from, $session);
    }

    /**
     * Show address confirmation (NEW USER FLOW - Step 6)
     */
    protected function showAddressConfirmation($from, $session)
    {
        $name = $session->getData('name', 'Customer');
        $email = $session->getData('email', '');
        $address = $session->getData('address', '');
        $city = $session->getData('city', '');
        $pincode = $session->getData('pincode', '');

        $message = "📋 *Please confirm your details:*\n\n";
        $message .= "👤 Name: {$name}\n";
        $message .= "📧 Email: {$email}\n";
        $message .= "📍 Address: {$address}\n";
        $message .= "🏙️ City: {$city}\n";
        $message .= "📮 Pincode: {$pincode}\n\n";
        $message .= "Is this information correct?";

        $this->sendButtons($from, $message, [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'confirm_details',
                    'title' => '✅ Confirm'
                ]
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'edit_details',
                    'title' => '✏️ Edit'
                ]
            ]
        ]);

        $session->updateStep('address_confirmation');
    }

    /**
     * Show payment options
     */
    protected function showPaymentOptions($from, $session)
    {
        $cartTotal = WhatsAppCart::getCartTotal($from);

        $message = "💳 *Select Payment Method*\n\n";
        $message .= "Order Total: ₹" . number_format($cartTotal, 0) . "\n\n";
        $message .= "Choose your payment method:";

        $this->sendButtons($from, $message, [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'payment_cod',
                    'title' => '💵 COD'
                ]
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'payment_online',
                    'title' => '💳 WhatsApp Pay'
                ]
            ]
        ]);

        $session->updateStep('payment_selection');
    }

    /**
     * Show order confirmation before placing order
     */
    protected function showOrderConfirmation($from, $paymentMethod = 'cod')
    {
        $cartItems = WhatsAppCart::getCartItems($from);
        $cartTotal = WhatsAppCart::getCartTotal($from);
        $session = WhatsAppCommerceSession::getSession($from);

        // Build order summary
        $message = "📦 *Order Summary*\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $itemTotal = $item->price * $item->quantity;
                $subtotal += $itemTotal;
                $message .= "• {$product->name}\n";
                $message .= "  Qty: {$item->quantity} × ₹" . number_format($item->price, 0) . " = ₹" . number_format($itemTotal, 0) . "\n\n";
            }
        }

        $shipping = 50; // Fixed shipping
        $total = $subtotal + $shipping;

        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
        $message .= "Subtotal: ₹" . number_format($subtotal, 0) . "\n";
        $message .= "Shipping: ₹" . number_format($shipping, 0) . "\n";
        $message .= "*Total: ₹" . number_format($total, 0) . "*\n\n";

        $paymentLabel = $paymentMethod === 'cod' ? 'Cash on Delivery' : 'Online Payment';
        $message .= "💳 Payment: {$paymentLabel}\n\n";

        // Show delivery address
        $user = User::where('phone', $from)->first();
        if ($user) {
            $message .= "📍 Delivery to:\n";
            $message .= "{$user->name}\n";
            $message .= "{$user->address}\n";
            $message .= "{$user->city} - {$user->pincode}\n\n";
        } else {
            $name = $session->getData('name', 'Customer');
            $address = $session->getData('address', '');
            $city = $session->getData('city', '');
            $pincode = $session->getData('pincode', '');

            $message .= "📍 Delivery to:\n";
            $message .= "{$name}\n";
            $message .= "{$address}\n";
            $message .= "{$city} - {$pincode}\n\n";
        }

        $message .= "━━━━━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "Confirm your order?";

        $this->sendButtons($from, $message, [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'confirm_order_' . $paymentMethod,
                    'title' => '✅ Confirm Order'
                ]
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => 'cancel_order',
                    'title' => '❌ Cancel'
                ]
            ]
        ]);

        $session->updateStep('order_confirmation');
        $session->setData('payment_method', $paymentMethod);
    }

    /**
     * Confirm and create order
     */
    protected function confirmOrder($from, $paymentMethod = 'cod')
    {
        try {
            DB::beginTransaction();

            $cartItems = WhatsAppCart::getCartItems($from);

            if ($cartItems->isEmpty()) {
                $this->sendTextMessage($from, "Your cart is empty!");
                DB::rollBack();
                return;
            }

            $session = WhatsAppCommerceSession::getSession($from);

            // Get or create user - check by phone first, then by email
            $user = $this->getUserByPhone($from);

            if (!$user) {
                // Check if user exists by email
                $email = $session->getData('email');
                if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $user = User::where('email', $email)->first();
                }
            }

            if (!$user) {
                // Create new user with session data
                $email = $session->getData('email');
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $email = $from . '@whatsapp.temp';
                }

                // Check if email already exists (in case of temp email collision)
                $existingUser = User::where('email', $email)->first();
                if ($existingUser) {
                    // Use existing user and update phone
                    $user = $existingUser;
                    $user->update(['phone' => $from]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $session->getData('name', 'WhatsApp Customer'),
                        'phone' => $from,
                        'email' => $email,
                        'password' => bcrypt(str()->random(16)),
                        'address' => $session->getData('address'),
                        'city' => $session->getData('city'),
                        'state' => $session->getData('state') ?? $session->getData('city'), // Use city as state if not provided
                        'pincode' => $session->getData('pincode'),
                    ]);
                }
            } else {
                // User exists - update address if provided in session
                $sessionAddress = $session->getData('address');
                if ($sessionAddress) {
                    $user->update([
                        'address' => $sessionAddress,
                        'city' => $session->getData('city'),
                        'state' => $session->getData('state') ?? $session->getData('city'), // Use city as state if not provided
                        'pincode' => $session->getData('pincode'),
                    ]);
                }
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $subtotal += $item->price * $item->quantity;
            }

            $shippingCharge = $subtotal >= 999 ? 0 : 50;
            $total = $subtotal + $shippingCharge;

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'WA' . strtoupper(uniqid()),
                'order_status' => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentMethod === 'cod' ? 'pending' : 'pending',
                'subtotal' => $subtotal,
                'shipping_charge' => $shippingCharge,
                'total_amount' => $total,
                'shipping_address' => $session->getData('address') ?? $user->address,
                'shipping_city' => $session->getData('city') ?? $user->city,
                'shipping_state' => $session->getData('state') ?? $user->state,
                'shipping_pincode' => $session->getData('pincode') ?? $user->pincode,
                'shipping_phone' => $from,
                'order_source' => 'whatsapp',
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'variant_id' => $cartItem->variant_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'subtotal' => $cartItem->price * $cartItem->quantity,
                ]);

                // Decrement stock
                if ($cartItem->variant) {
                    $cartItem->variant->decrement('stock_quantity', $cartItem->quantity);
                } else {
                    $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
                }
            }

            // Clear cart
            WhatsAppCart::clearCart($from);

            // Clear session
            $session->clearData();

            DB::commit();

            // Send confirmation
            if ($paymentMethod === 'online') {
                $this->sendPaymentLink($from, $order);
            } else {
                $this->sendOrderConfirmation($from, $order);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating WhatsApp order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->sendTextMessage($from, "Sorry, we couldn't process your order. Please try again or contact support.");
        }
    }

    /**
     * Send order confirmation
     */
    protected function sendOrderConfirmation($from, $order)
    {
        $message = "✅ *Order Confirmed!*\n\n";
        $message .= "📦 Order #: {$order->order_number}\n";
        $message .= "💰 Total: ₹" . number_format($order->total_amount, 0) . "\n";
        $message .= "💳 Payment: " . strtoupper($order->payment_method) . "\n\n";
        $message .= "We'll notify you once your order is confirmed and shipped.\n\n";
        $message .= "Track your order: " . url('/orders/' . $order->id) . "\n\n";
        $message .= "Thank you for shopping with SJ Fashion Hub! 🎉";

        $this->sendTextMessage($from, $message);
    }

    /**
     * Send payment link
     */
    protected function sendPaymentLink($from, $order)
    {
        // Generate payment link (integrate with Razorpay/PhonePe)
        $paymentUrl = url('/payment/' . $order->id);

        $message = "💳 *Complete Your Payment*\n\n";
        $message .= "📦 Order #: {$order->order_number}\n";
        $message .= "💰 Amount: ₹" . number_format($order->total_amount, 0) . "\n\n";
        $message .= "Click the link below to pay:\n";
        $message .= $paymentUrl . "\n\n";
        $message .= "⏰ Complete payment within 30 minutes to confirm your order.";

        $this->sendTextMessage($from, $message);
    }

    /**
     * Send order tracking info
     */
    protected function sendOrderTracking($from)
    {
        // Get user by phone
        $user = $this->getUserByPhone($from);

        if (!$user) {
            $this->sendTextMessage($from, "No orders found for this number.\n\nType 'menu' to start shopping!");
            return;
        }

        // Get all users with this phone number (in case of duplicates)
        $users = User::where('phone', $from)->get();
        $userIds = $users->pluck('id')->toArray();

        // Get orders from ALL users with this phone number
        $orders = Order::whereIn('user_id', $userIds)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        if ($orders->isEmpty()) {
            $this->sendTextMessage($from, "You don't have any orders yet.\n\nType 'menu' to start shopping!");
            return;
        }

        $message = "📦 *Your Recent Orders*\n\n";

        foreach ($orders as $order) {
            $statusEmoji = [
                'pending' => '⏳',
                'confirmed' => '✅',
                'processing' => '📦',
                'shipped' => '🚚',
                'delivered' => '✅',
                'cancelled' => '❌',
                'rto' => '🔄'
            ];

            $emoji = $statusEmoji[$order->order_status] ?? '📦';

            $message .= "{$emoji} *{$order->order_number}*\n";
            $message .= "Status: " . ucfirst($order->order_status) . "\n";
            $message .= "Amount: ₹" . number_format($order->total_amount, 0) . "\n";
            $message .= "Date: " . $order->created_at->format('d M Y') . "\n\n";
        }

        $message .= "Track your orders: " . url('/orders');

        $this->sendTextMessage($from, $message);
    }

    /**
     * Cancel checkout
     */
    protected function cancelCheckout($from)
    {
        $session = WhatsAppCommerceSession::getSession($from);
        $session->clearData();

        $this->sendTextMessage($from, "Checkout cancelled. Your items are still in the cart.\n\nType 'cart' to view or 'menu' to continue shopping.");
    }

    /**
     * Send text message via WhatsApp API
     */
    protected function sendTextMessage($to, $message)
    {
        try {
            if (!$this->phoneNumberId || !$this->accessToken) {
                Log::warning('WhatsApp credentials not configured');
                return false;
            }

            $response = Http::withToken($this->accessToken)
                ->post("https://graph.facebook.com/v18.0/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $to,
                    'type' => 'text',
                    'text' => [
                        'preview_url' => true,
                        'body' => $message
                    ]
                ]);

            if ($response->successful()) {
                $this->logMessage($to, $message, 'outbound');
                return true;
            }

            Log::error('Failed to send WhatsApp message', [
                'response' => $response->json()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Error sending WhatsApp text message', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send interactive list message
     */
    protected function sendInteractiveList($to, $header, $body, $buttonText, $sections)
    {
        try {
            $response = Http::withToken($this->accessToken)
                ->post("https://graph.facebook.com/v18.0/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $to,
                    'type' => 'interactive',
                    'interactive' => [
                        'type' => 'list',
                        'header' => [
                            'type' => 'text',
                            'text' => $header
                        ],
                        'body' => [
                            'text' => $body
                        ],
                        'action' => [
                            'button' => $buttonText,
                            'sections' => $sections
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $this->logMessage($to, "Interactive list: {$header}", 'outbound');
                return true;
            }

            Log::error('Failed to send interactive list', [
                'response' => $response->json()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Error sending interactive list', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send buttons message
     */
    protected function sendButtons($to, $body, $buttons)
    {
        try {
            $response = Http::withToken($this->accessToken)
                ->post("https://graph.facebook.com/v18.0/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $to,
                    'type' => 'interactive',
                    'interactive' => [
                        'type' => 'button',
                        'body' => [
                            'text' => $body
                        ],
                        'action' => [
                            'buttons' => $buttons
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $this->logMessage($to, "Button message: {$body}", 'outbound');
                return true;
            }

            Log::error('Failed to send buttons', [
                'response' => $response->json()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Error sending buttons', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send image message
     */
    protected function sendImageMessage($to, $imageUrl, $caption = null)
    {
        try {
            $data = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $to,
                'type' => 'image',
                'image' => [
                    'link' => $imageUrl
                ]
            ];

            if ($caption) {
                $data['image']['caption'] = $caption;
            }

            $response = Http::withToken($this->accessToken)
                ->post("https://graph.facebook.com/v18.0/{$this->phoneNumberId}/messages", $data);

            if ($response->successful()) {
                $this->logMessage($to, "Image: {$imageUrl}", 'outbound');
                return true;
            }

            Log::error('Failed to send image', [
                'response' => $response->json()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Error sending image', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}


