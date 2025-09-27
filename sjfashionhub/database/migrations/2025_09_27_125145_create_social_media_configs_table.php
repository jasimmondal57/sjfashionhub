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
        Schema::create('social_media_configs', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->unique(); // instagram, facebook, twitter, linkedin
            $table->string('name'); // Display name
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(false);
            $table->json('credentials')->nullable(); // Encrypted API keys, tokens, etc.
            $table->json('settings')->nullable(); // Platform-specific settings
            $table->string('webhook_url')->nullable(); // For receiving platform updates
            $table->timestamp('last_connected_at')->nullable();
            $table->text('connection_status')->nullable(); // Success, error message, etc.
            $table->json('rate_limits')->nullable(); // API rate limit info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_configs');
    }
};
