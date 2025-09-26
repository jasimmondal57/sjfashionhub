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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon_type')->default('svg'); // svg, image, or icon_class
            $table->text('icon_svg')->nullable(); // SVG code for custom icons
            $table->string('icon_image')->nullable(); // Image path for uploaded icons
            $table->string('icon_class')->nullable(); // CSS class for icon fonts
            $table->string('background_color')->default('#000000'); // Icon background color
            $table->string('icon_color')->default('#ffffff'); // Icon color
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
