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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();

            // SEO fields
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_schema')->nullable();

            // AI generation fields
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('ai_generated')->default(false);
            $table->text('ai_prompt')->nullable();
            $table->json('ai_metadata')->nullable();

            // Blog organization
            $table->foreignId('blog_category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');

            // Publishing
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();

            // Analytics
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('shares_count')->default(0);

            // Settings
            $table->boolean('is_featured')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->integer('reading_time')->nullable(); // in minutes

            $table->timestamps();

            // Indexes
            $table->index(['status', 'published_at']);
            $table->index(['blog_category_id', 'status']);
            $table->index(['product_id']);
            $table->index(['ai_generated']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
