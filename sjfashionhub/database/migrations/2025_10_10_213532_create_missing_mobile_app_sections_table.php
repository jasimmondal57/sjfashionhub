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
        Schema::create('mobile_app_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type'); // banner, category, product_grid, product_carousel, featured, deals, custom, body, category_products
            $table->text('description')->nullable();
            $table->json('config')->nullable(); // Section-specific configuration
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_app_sections');
    }
};
