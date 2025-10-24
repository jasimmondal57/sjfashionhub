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
        Schema::create('social_media_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin who posted
            $table->string('platform'); // instagram, facebook, twitter, linkedin, etc.
            $table->string('post_id')->nullable(); // Platform-specific post ID
            $table->text('content'); // Generated content
            $table->json('hashtags')->nullable(); // Array of hashtags
            $table->json('images')->nullable(); // Array of image URLs
            $table->enum('status', ['pending', 'posted', 'failed', 'scheduled'])->default('pending');
            $table->text('error_message')->nullable(); // Error details if failed
            $table->json('platform_response')->nullable(); // Response from social media API
            $table->timestamp('scheduled_at')->nullable(); // For scheduled posts
            $table->timestamp('posted_at')->nullable(); // When actually posted
            $table->json('engagement_stats')->nullable(); // Likes, shares, comments, etc.
            $table->boolean('is_ai_generated')->default(true); // Whether content was AI generated
            $table->text('ai_prompt')->nullable(); // The prompt used for AI generation
            $table->timestamps();

            $table->index(['product_id', 'platform']);
            $table->index(['status', 'scheduled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_posts');
    }
};
