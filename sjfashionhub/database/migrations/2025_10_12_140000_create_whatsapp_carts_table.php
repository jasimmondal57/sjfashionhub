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
        Schema::create('whatsapp_carts', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 20)->index();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Unique constraint to prevent duplicate items
            $table->unique(['phone_number', 'product_id', 'variant_id']);
        });

        Schema::create('whatsapp_commerce_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 20)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('current_step')->default('browse'); // browse, cart, checkout, address, payment
            $table->json('session_data')->nullable(); // Store temporary data like selected category, etc.
            $table->string('last_message_id')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_carts');
        Schema::dropIfExists('whatsapp_commerce_sessions');
    }
};

