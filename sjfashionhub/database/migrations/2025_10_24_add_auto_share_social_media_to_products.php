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
        Schema::table('products', function (Blueprint $table) {
            // Add auto-share to social media field
            if (!Schema::hasColumn('products', 'auto_share_social_media')) {
                $table->boolean('auto_share_social_media')->default(false)->after('is_active');
            }
            
            // Add field to track which platforms to auto-share to
            if (!Schema::hasColumn('products', 'auto_share_platforms')) {
                $table->json('auto_share_platforms')->nullable()->after('auto_share_social_media');
            }
            
            // Add field to track if already auto-shared
            if (!Schema::hasColumn('products', 'auto_shared_at')) {
                $table->timestamp('auto_shared_at')->nullable()->after('auto_share_platforms');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['auto_share_social_media', 'auto_share_platforms', 'auto_shared_at']);
        });
    }
};

