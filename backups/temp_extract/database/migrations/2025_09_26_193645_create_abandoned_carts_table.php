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
        Schema::create('abandoned_carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->json('cart_items'); // Store cart items as JSON
            $table->decimal('cart_total', 10, 2)->default(0);
            $table->decimal('cart_subtotal', 10, 2)->default(0);
            $table->decimal('cart_tax', 10, 2)->default(0);
            $table->decimal('cart_shipping', 10, 2)->default(0);
            $table->integer('items_count')->default(0);
            $table->string('currency', 3)->default('INR');
            $table->string('status')->default('abandoned'); // abandoned, recovered, expired
            $table->timestamp('abandoned_at');
            $table->timestamp('last_activity_at');
            $table->timestamp('recovered_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('recovery_token')->unique()->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->json('browser_info')->nullable(); // Browser, OS, Device info
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->boolean('is_guest')->default(true);
            $table->boolean('email_sent')->default(false);
            $table->integer('email_count')->default(0);
            $table->timestamp('last_email_sent_at')->nullable();
            $table->json('coupon_codes')->nullable(); // Applied coupon codes
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'abandoned_at']);
            $table->index(['email', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('recovery_token');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abandoned_carts');
    }
};
