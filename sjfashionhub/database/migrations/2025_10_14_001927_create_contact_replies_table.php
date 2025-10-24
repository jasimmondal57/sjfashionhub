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
        Schema::create('contact_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Admin user who replied
            $table->text('message');
            $table->enum('sender_type', ['admin', 'user'])->default('admin');
            $table->string('sender_name')->nullable(); // For user replies
            $table->string('sender_email')->nullable(); // For user replies
            $table->boolean('is_internal_note')->default(false); // Admin-only notes
            $table->timestamp('read_at')->nullable(); // When the message was read
            $table->json('attachments')->nullable(); // For future file attachments
            $table->timestamps();

            $table->index(['contact_id', 'created_at']);
            $table->index(['sender_type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_replies');
    }
};
