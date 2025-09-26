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
        Schema::create('google_sheets_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('google_sheets_setting_id')->constrained()->onDelete('cascade');
            $table->string('sync_type'); // manual, auto, real_time
            $table->string('operation'); // create, update, delete, bulk_sync
            $table->string('status'); // pending, success, failed, partial
            $table->integer('records_processed')->default(0);
            $table->integer('records_success')->default(0);
            $table->integer('records_failed')->default(0);
            $table->json('sync_data')->nullable(); // Data that was synced
            $table->text('error_message')->nullable();
            $table->json('error_details')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->string('triggered_by')->nullable(); // user_id or 'system'
            $table->string('batch_id')->nullable(); // For grouping related syncs
            $table->json('response_data')->nullable(); // Response from Google Sheets
            $table->timestamps();

            $table->index(['google_sheets_setting_id', 'status']);
            $table->index(['sync_type', 'started_at']);
            $table->index('batch_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_sheets_sync_logs');
    }
};
