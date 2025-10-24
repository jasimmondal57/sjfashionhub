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
        // Mobile App Settings
        Schema::create('mobile_app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, number, boolean, json, color, image
            $table->string('group')->default('general'); // general, api, theme, notification
            $table->string('label');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Mobile App Sections (Home screen sections)
        Schema::create('mobile_app_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // banner, category, product_grid, product_carousel, featured, deals, custom
            $table->text('description')->nullable();
            $table->json('config')->nullable(); // Section-specific configuration
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Mobile App Banners
        Schema::create('mobile_app_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('link_type')->default('none'); // none, product, category, url, screen
            $table->string('link_value')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });

        // Mobile App Navigation Menu
        Schema::create('mobile_app_menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('type'); // home, categories, cart, profile, orders, wishlist, custom, url
            $table->string('value')->nullable(); // For custom types
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_bottom_nav')->default(false);
            $table->boolean('show_in_drawer')->default(true);
            $table->timestamps();
        });

        // Mobile App Featured Categories
        Schema::create('mobile_app_featured_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Mobile App Featured Products
        Schema::create('mobile_app_featured_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('badge')->nullable(); // "New", "Sale", "Hot", etc.
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Mobile App Theme Settings
        Schema::create('mobile_app_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('primary_color')->default('#6200EE');
            $table->string('secondary_color')->default('#03DAC6');
            $table->string('background_color')->default('#FFFFFF');
            $table->string('text_color')->default('#000000');
            $table->string('card_color')->default('#F5F5F5');
            $table->string('app_bar_color')->default('#6200EE');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // Mobile App Push Notifications
        Schema::create('mobile_app_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('image')->nullable();
            $table->string('type')->default('general'); // general, order, promotion, announcement
            $table->json('data')->nullable(); // Additional data for deep linking
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->integer('sent_count')->default(0);
            $table->boolean('is_sent')->default(false);
            $table->timestamps();
        });

        // Mobile App User Devices (for push notifications)
        Schema::create('mobile_app_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('fcm_token')->unique();
            $table->string('platform'); // android, ios
            $table->string('device_id')->nullable();
            $table->string('app_version')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();
        });

        // Mobile App Analytics
        Schema::create('mobile_app_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('event_type'); // screen_view, product_view, add_to_cart, purchase, etc.
            $table->string('screen_name')->nullable();
            $table->json('event_data')->nullable();
            $table->string('platform'); // android, ios
            $table->string('app_version')->nullable();
            $table->timestamps();
            
            $table->index(['event_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_app_analytics');
        Schema::dropIfExists('mobile_app_devices');
        Schema::dropIfExists('mobile_app_notifications');
        Schema::dropIfExists('mobile_app_themes');
        Schema::dropIfExists('mobile_app_featured_products');
        Schema::dropIfExists('mobile_app_featured_categories');
        Schema::dropIfExists('mobile_app_menu_items');
        Schema::dropIfExists('mobile_app_banners');
        Schema::dropIfExists('mobile_app_sections');
        Schema::dropIfExists('mobile_app_settings');
    }
};

