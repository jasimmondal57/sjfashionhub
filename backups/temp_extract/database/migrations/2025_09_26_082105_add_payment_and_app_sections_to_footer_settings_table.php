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
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->json('payment_icons')->nullable()->after('payment_methods');
            $table->boolean('show_payment_icons')->default(true)->after('payment_icons');
            $table->json('app_download_links')->nullable()->after('show_payment_icons');
            $table->boolean('show_app_downloads')->default(true)->after('app_download_links');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->dropColumn(['payment_icons', 'show_payment_icons', 'app_download_links', 'show_app_downloads']);
        });
    }
};
