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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            // Discount Configuration
            $table->enum('type', ['percentage', 'fixed_amount', 'free_shipping']);
            $table->decimal('value', 10, 2); // Percentage or fixed amount
            $table->decimal('minimum_amount', 10, 2)->nullable(); // Minimum order amount
            $table->decimal('maximum_discount', 10, 2)->nullable(); // Maximum discount cap

            // Usage Limits
            $table->integer('usage_limit')->nullable(); // Total usage limit
            $table->integer('usage_limit_per_customer')->nullable(); // Per customer limit
            $table->integer('used_count')->default(0); // Current usage count

            // Date Restrictions
            $table->datetime('starts_at')->nullable();
            $table->datetime('expires_at')->nullable();

            // Product/Category Restrictions
            $table->json('applicable_products')->nullable(); // Specific product IDs
            $table->json('applicable_categories')->nullable(); // Specific category IDs
            $table->json('excluded_products')->nullable(); // Excluded product IDs
            $table->json('excluded_categories')->nullable(); // Excluded category IDs

            // Customer Restrictions
            $table->json('applicable_customers')->nullable(); // Specific customer IDs
            $table->boolean('first_order_only')->default(false); // First-time customers only

            // Status and Settings
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true); // Public or private coupon
            $table->integer('priority')->default(0); // For stacking order
            $table->boolean('stackable')->default(false); // Can be combined with other coupons

            // Tracking
            $table->string('created_by')->nullable(); // Admin who created
            $table->timestamp('last_used_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['code', 'is_active']);
            $table->index(['starts_at', 'expires_at']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
