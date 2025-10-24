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
        Schema::create('google_sheets_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sheet_type'); // orders, returns, users
            $table->string('sheet_name');
            $table->string('spreadsheet_id');
            $table->string('sheet_id')->nullable();
            $table->string('web_app_url'); // Google Apps Script Web App URL
            $table->text('service_account_json')->nullable(); // Service account credentials
            $table->json('column_mapping'); // Field to column mapping
            $table->boolean('auto_sync')->default(true);
            $table->boolean('real_time_sync')->default(false);
            $table->string('sync_frequency')->default('hourly'); // hourly, daily, weekly
            $table->timestamp('last_sync_at')->nullable();
            $table->integer('total_synced')->default(0);
            $table->integer('sync_errors')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('sync_filters')->nullable(); // Filters for what data to sync
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['sheet_type', 'spreadsheet_id']);
            $table->index(['sheet_type', 'is_active']);
            $table->index('last_sync_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_sheets_settings');
    }
};
