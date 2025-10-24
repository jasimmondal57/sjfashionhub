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
        Schema::create('communication_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // email, sms, whatsapp
            $table->string('category'); // verification, notification, promotion, order, return, etc.
            $table->string('event'); // user_registered, order_placed, order_shipped, etc.
            $table->string('subject')->nullable(); // For email templates
            $table->text('content'); // Template content with placeholders
            $table->text('html_content')->nullable(); // HTML version for emails
            $table->json('variables')->nullable(); // Available template variables
            $table->json('settings')->nullable(); // Template-specific settings
            $table->string('language')->default('en');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->integer('priority')->default(0); // For template ordering
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Additional template data
            $table->timestamps();

            $table->index(['type', 'category', 'is_active']);
            $table->index(['event', 'is_active']);
            $table->unique(['type', 'category', 'event', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_templates');
    }
};
