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
        Schema::create('communication_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // email, sms, whatsapp
            $table->string('provider'); // smtp, twilio, whatsapp_business, etc.
            $table->string('recipient'); // email address or phone number
            $table->string('sender')->nullable();
            $table->string('subject')->nullable(); // For emails
            $table->text('content');
            $table->string('template_id')->nullable();
            $table->string('event')->nullable(); // What triggered this communication
            $table->string('status'); // pending, sent, delivered, failed, read
            $table->string('message_id')->nullable(); // Provider's message ID
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable(); // Additional data like tracking info
            $table->json('variables')->nullable(); // Template variables used
            $table->decimal('cost', 8, 4)->nullable(); // Cost of sending (for SMS/WhatsApp)
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('next_retry_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('reference_type')->nullable(); // Model type that triggered this
            $table->unsignedBigInteger('reference_id')->nullable(); // Model ID that triggered this
            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index(['recipient', 'type']);
            $table->index(['event', 'created_at']);
            $table->index(['user_id', 'type']);
            $table->index(['order_id', 'type']);
            $table->index(['reference_type', 'reference_id']);
            $table->index(['status', 'next_retry_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_logs');
    }
};
