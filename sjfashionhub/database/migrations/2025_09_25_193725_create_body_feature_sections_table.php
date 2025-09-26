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
        Schema::create('body_feature_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Trending Now", "New Collections 2025"
            $table->string('subtitle')->nullable(); // e.g., "Discover our most popular items"
            $table->string('section_type'); // 'products', 'categories', 'mixed'
            $table->string('display_style'); // 'grid', 'carousel', 'list'
            $table->integer('items_limit')->default(8); // How many items to show
            $table->string('background_color')->default('#ffffff');
            $table->string('text_color')->default('#000000');
            $table->string('button_text')->nullable(); // e.g., "View All", "Shop Now"
            $table->string('button_url')->nullable(); // Where button links to
            $table->boolean('show_button')->default(true);
            $table->json('content_settings')->nullable(); // Specific products/categories IDs, filters, etc.
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_feature_sections');
    }
};
