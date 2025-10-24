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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // razorpay, cashfree, payu, etc.
            $table->string('display_name'); // Razorpay, Cashfree, PayU, etc.
            $table->string('type'); // online, offline
            $table->text('description')->nullable();
            $table->json('credentials')->nullable(); // encrypted credentials
            $table->json('settings')->nullable(); // additional settings
            $table->boolean('is_active')->default(false);
            $table->boolean('is_test_mode')->default(true);
            $table->decimal('min_amount', 10, 2)->default(0);
            $table->decimal('max_amount', 10, 2)->nullable();
            $table->decimal('transaction_fee', 8, 4)->default(0); // percentage
            $table->decimal('fixed_fee', 8, 2)->default(0); // fixed amount
            $table->string('currency', 3)->default('INR');
            $table->json('supported_currencies')->nullable();
            $table->string('logo_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique('name');
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
