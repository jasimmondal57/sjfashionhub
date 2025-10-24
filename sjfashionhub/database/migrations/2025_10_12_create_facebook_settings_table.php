<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facebook_settings', function (Blueprint $table) {
            $table->id();
            $table->string('pixel_id')->nullable();
            $table->boolean('pixel_enabled')->default(false);
            $table->text('access_token')->nullable();
            $table->string('catalog_id')->nullable();
            $table->boolean('catalog_sync_enabled')->default(false);
            $table->string('business_id')->nullable();
            $table->string('app_id')->nullable();
            $table->text('app_secret')->nullable();
            $table->boolean('auto_sync_inventory')->default(true);
            $table->boolean('auto_sync_prices')->default(true);
            $table->integer('sync_frequency_hours')->default(6); // Sync every 6 hours
            $table->timestamp('last_sync_at')->nullable();
            $table->json('sync_settings')->nullable(); // Additional sync settings
            $table->json('event_tracking')->nullable(); // Which events to track
            $table->timestamps();
        });

        Schema::create('facebook_catalog_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('facebook_product_id')->nullable();
            $table->string('status')->default('pending'); // pending, synced, failed
            $table->string('availability')->default('in stock'); // in stock, out of stock, preorder
            $table->timestamp('last_synced_at')->nullable();
            $table->text('sync_error')->nullable();
            $table->json('facebook_data')->nullable(); // Store Facebook response
            $table->timestamps();
            
            $table->unique(['product_id']);
        });

        Schema::create('facebook_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sync_type'); // full, inventory, price, single_product
            $table->string('status'); // started, completed, failed
            $table->integer('products_synced')->default(0);
            $table->integer('products_failed')->default(0);
            $table->text('error_message')->nullable();
            $table->json('details')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // Insert default settings row
        DB::table('facebook_settings')->insert([
            'pixel_enabled' => false,
            'catalog_sync_enabled' => false,
            'auto_sync_inventory' => true,
            'auto_sync_prices' => true,
            'sync_frequency_hours' => 6,
            'event_tracking' => json_encode([
                'PageView' => true,
                'ViewContent' => true,
                'AddToCart' => true,
                'InitiateCheckout' => true,
                'Purchase' => true,
                'Search' => true,
                'AddToWishlist' => true,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_sync_logs');
        Schema::dropIfExists('facebook_catalog_products');
        Schema::dropIfExists('facebook_settings');
    }
};

