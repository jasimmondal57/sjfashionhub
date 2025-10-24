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
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('otp');
            $table->string('type')->default('sms'); // sms, whatsapp
            $table->string('purpose')->default('login'); // login, register, password_reset
            $table->boolean('is_verified')->default(false);
            $table->timestamp('expires_at');
            $table->integer('attempts')->default(0);
            $table->timestamps();
            
            $table->index(['phone', 'otp']);
            $table->index(['phone', 'is_verified']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
