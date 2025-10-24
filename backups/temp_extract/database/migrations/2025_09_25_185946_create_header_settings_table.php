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
        Schema::create('header_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('SJ Fashion Hub');
            $table->string('logo_text')->nullable();
            $table->string('logo_image')->nullable();
            $table->json('navigation_menu')->nullable(); // Store menu items as JSON
            $table->boolean('show_search')->default(true);
            $table->boolean('show_wishlist')->default(true);
            $table->boolean('show_cart')->default(true);
            $table->boolean('show_account')->default(true);
            $table->string('search_placeholder')->default('Search products...');
            $table->json('contact_info')->nullable(); // Phone, email, etc.
            $table->json('social_links')->nullable(); // Social media links
            $table->boolean('sticky_header')->default(false);
            $table->string('header_style')->default('default'); // default, minimal, modern
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_settings');
    }
};
