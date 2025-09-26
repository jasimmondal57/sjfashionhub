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
        Schema::create('announcement_bars', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->string('background_color')->default('#000000');
            $table->string('text_color')->default('#ffffff');
            $table->json('links')->nullable(); // Store links as JSON
            $table->boolean('is_active')->default(true);
            $table->boolean('is_scrolling')->default(false);
            $table->integer('scroll_speed')->default(50); // pixels per second
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcement_bars');
    }
};
