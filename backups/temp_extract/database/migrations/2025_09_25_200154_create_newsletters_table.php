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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('placeholder_text')->default('Enter your email address');
            $table->string('button_text')->default('Subscribe');
            $table->string('background_color')->default('#f9fafb');
            $table->string('text_color')->default('#000000');
            $table->string('button_color')->default('#000000');
            $table->string('button_text_color')->default('#ffffff');
            $table->boolean('show_social_links')->default(false);
            $table->json('social_links')->nullable();
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
        Schema::dropIfExists('newsletters');
    }
};
