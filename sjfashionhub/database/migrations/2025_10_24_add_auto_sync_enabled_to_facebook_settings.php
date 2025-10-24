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
        Schema::table('facebook_settings', function (Blueprint $table) {
            // Add auto_sync_enabled column if it doesn't exist
            if (!Schema::hasColumn('facebook_settings', 'auto_sync_enabled')) {
                $table->boolean('auto_sync_enabled')->default(true)->after('catalog_sync_enabled');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facebook_settings', function (Blueprint $table) {
            if (Schema::hasColumn('facebook_settings', 'auto_sync_enabled')) {
                $table->dropColumn('auto_sync_enabled');
            }
        });
    }
};

