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
        Schema::create('user_otps', function (Blueprint $table) {
            $table->id();
            $table->string('identifier'); // email or phone
            $table->enum('type', ['email', 'phone']); // verification type
            $table->string('otp', 6); // 6-digit OTP
            $table->enum('purpose', ['registration', 'login', 'password_reset']); // OTP purpose
            $table->enum('method', ['sms', 'whatsapp', 'email']); // delivery method
            $table->timestamp('expires_at'); // OTP expiration
            $table->boolean('verified')->default(false); // verification status
            $table->timestamp('verified_at')->nullable(); // verification timestamp
            $table->integer('attempts')->default(0); // verification attempts
            $table->json('metadata')->nullable(); // additional data (user info for registration)
            $table->timestamps();

            $table->index(['identifier', 'type', 'purpose']);
            $table->index(['otp', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_otps');
    }
};
