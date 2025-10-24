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
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Template name (lowercase, no spaces)
            $table->string('display_name'); // Display name for admin
            $table->string('category'); // MARKETING, UTILITY, AUTHENTICATION
            $table->string('language')->default('en'); // Language code
            $table->text('header_text')->nullable(); // Header text
            $table->string('header_type')->nullable(); // TEXT, IMAGE, VIDEO, DOCUMENT
            $table->text('body_text'); // Body text with variables {{1}}, {{2}}
            $table->text('footer_text')->nullable(); // Footer text
            $table->json('buttons')->nullable(); // Call-to-action buttons
            $table->json('variables')->nullable(); // Variable placeholders
            $table->string('status')->default('draft'); // draft, pending, approved, rejected
            $table->string('whatsapp_template_id')->nullable(); // WhatsApp template ID
            $table->text('rejection_reason')->nullable(); // Reason if rejected
            $table->timestamp('submitted_at')->nullable(); // When submitted to WhatsApp
            $table->timestamp('approved_at')->nullable(); // When approved by WhatsApp
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('whatsapp_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Campaign name
            $table->text('description')->nullable();
            $table->foreignId('template_id')->constrained('whatsapp_templates')->onDelete('cascade');
            $table->string('status')->default('draft'); // draft, scheduled, running, completed, paused
            $table->json('target_audience')->nullable(); // Filter criteria
            $table->json('variable_values')->nullable(); // Values for template variables
            $table->timestamp('scheduled_at')->nullable(); // When to send
            $table->timestamp('started_at')->nullable(); // When campaign started
            $table->timestamp('completed_at')->nullable(); // When campaign completed
            $table->integer('total_recipients')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('delivered_count')->default(0);
            $table->integer('read_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('whatsapp_campaign_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('whatsapp_campaigns')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone_number');
            $table->string('status')->default('pending'); // pending, sent, delivered, read, failed
            $table->string('whatsapp_message_id')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['campaign_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_campaign_recipients');
        Schema::dropIfExists('whatsapp_campaigns');
        Schema::dropIfExists('whatsapp_templates');
    }
};

