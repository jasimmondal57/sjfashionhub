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
        Schema::create('authentication_settings', function (Blueprint $table) {
            $table->id();
            $table->string('method'); // email, mobile_sms, mobile_whatsapp
            $table->boolean('enabled')->default(true);
            $table->json('settings')->nullable(); // Method-specific settings
            $table->timestamps();

            $table->unique('method');
        });

        // Insert default authentication methods
        DB::table('authentication_settings')->insert([
            [
                'method' => 'email',
                'enabled' => true,
                'settings' => json_encode([
                    'require_email_verification' => false,
                    'allow_password_reset' => true,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'method' => 'mobile_sms',
                'enabled' => false,
                'settings' => json_encode([
                    'api_key' => null,
                    'sender_id' => 'SJFASHION',
                    'base_url' => 'https://api.textlocal.in/send/',
                    'otp_length' => 6,
                    'otp_expiry_minutes' => 10,
                    'max_attempts_per_hour' => 3,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'method' => 'mobile_whatsapp',
                'enabled' => false,
                'settings' => json_encode([
                    'access_token' => null,
                    'phone_number_id' => null,
                    'base_url' => 'https://graph.facebook.com/v18.0',
                    'otp_length' => 6,
                    'otp_expiry_minutes' => 10,
                    'max_attempts_per_hour' => 3,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authentication_settings');
    }
};
