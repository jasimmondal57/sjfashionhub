<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique()->nullable(); // WhatsApp message ID
            $table->string('wamid')->nullable(); // WhatsApp message ID from Meta
            $table->string('direction')->default('outbound'); // outbound, inbound
            $table->string('type'); // text, template, image, video, document, order, etc.
            $table->string('status')->default('pending'); // pending, sent, delivered, read, failed
            $table->string('phone_number'); // Customer phone number
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Link to user if exists
            $table->string('category')->nullable(); // marketing, otp, notification, support, order
            $table->string('template_name')->nullable(); // Template name if template message
            $table->text('content'); // Message content
            $table->json('media')->nullable(); // Media URLs if any
            $table->json('parameters')->nullable(); // Template parameters
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // Related order
            $table->foreignId('return_order_id')->nullable()->constrained()->onDelete('set null'); // Related return
            $table->timestamps();
            
            $table->index(['phone_number', 'created_at']);
            $table->index(['category', 'created_at']);
            $table->index(['status', 'created_at']);
            $table->index('user_id');
        });

        Schema::create('whatsapp_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_name')->nullable();
            $table->string('status')->default('open'); // open, closed, archived
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // Admin user
            $table->timestamp('last_message_at')->nullable();
            $table->string('last_message_type')->nullable();
            $table->text('last_message_preview')->nullable();
            $table->integer('unread_count')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'last_message_at']);
            $table->index('assigned_to');
        });

        Schema::create('whatsapp_catalog_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('meta_product_id')->unique()->nullable(); // Meta catalog product ID
            $table->string('retailer_id'); // Your product SKU
            $table->string('sync_status')->default('pending'); // pending, synced, failed
            $table->timestamp('last_synced_at')->nullable();
            $table->text('sync_error')->nullable();
            $table->json('meta_data')->nullable(); // Data sent to Meta
            $table->timestamps();
            
            $table->index('sync_status');
        });

        Schema::create('whatsapp_orders', function (Blueprint $table) {
            $table->id();
            $table->string('whatsapp_order_id')->unique(); // From WhatsApp
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // Created order
            $table->string('phone_number');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->json('items'); // Order items from WhatsApp
            $table->decimal('total_amount', 10, 2);
            $table->json('customer_details')->nullable(); // Name, address, etc.
            $table->text('customer_message')->nullable();
            $table->timestamp('received_at');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_orders');
        Schema::dropIfExists('whatsapp_catalog_products');
        Schema::dropIfExists('whatsapp_conversations');
        Schema::dropIfExists('whatsapp_messages');
    }
};

