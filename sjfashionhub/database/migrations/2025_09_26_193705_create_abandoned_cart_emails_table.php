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
        Schema::create('abandoned_cart_emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('abandoned_cart_id')->constrained()->onDelete('cascade');
            $table->string('email_type'); // reminder_1, reminder_2, reminder_3, final_reminder
            $table->string('subject');
            $table->text('content');
            $table->string('template')->nullable();
            $table->string('status')->default('pending'); // pending, sent, failed, opened, clicked
            $table->timestamp('scheduled_at');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->string('email_provider')->nullable(); // smtp, mailgun, sendgrid, etc.
            $table->string('message_id')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->json('tracking_data')->nullable(); // Open/click tracking data
            $table->string('coupon_code')->nullable(); // Discount coupon included in email
            $table->decimal('discount_amount', 8, 2)->nullable();
            $table->string('discount_type')->nullable(); // percentage, fixed
            $table->boolean('is_personalized')->default(false);
            $table->json('personalization_data')->nullable(); // Customer name, product recommendations
            $table->timestamps();

            $table->index(['abandoned_cart_id', 'email_type']);
            $table->index(['status', 'scheduled_at']);
            $table->index('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abandoned_cart_emails');
    }
};
