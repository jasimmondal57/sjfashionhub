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
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Where Elegance');
            $table->string('subtitle')->default('Meets Comfort');
            $table->text('description')->default('Refined Style, Perfect Fit. Style Made Effortless. Elevate Your Style Everyday.');
            $table->string('primary_button_text')->default('Shop Now');
            $table->string('primary_button_url')->default('/products');
            $table->string('secondary_button_text')->default('Browse Categories');
            $table->string('secondary_button_url')->default('/categories');
            $table->string('background_color')->default('#f9fafb');
            $table->string('text_color')->default('#000000');
            $table->string('accent_color')->default('#000000'); // For gradient text
            $table->string('hero_image')->nullable();
            $table->json('decorative_elements')->nullable(); // For additional design elements
            $table->string('layout_style')->default('split'); // split, centered, full-width
            $table->boolean('show_buttons')->default(true);
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
        Schema::dropIfExists('hero_sections');
    }
};
