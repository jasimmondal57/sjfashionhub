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
        Schema::create('social_login_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // google, facebook, etc.
            $table->boolean('enabled')->default(false);
            $table->text('client_id')->nullable();
            $table->text('client_secret')->nullable();
            $table->text('redirect_uri')->nullable();
            $table->json('additional_settings')->nullable(); // For extra provider-specific settings
            $table->timestamps();

            $table->unique('provider');
        });

        // Insert default providers
        DB::table('social_login_settings')->insert([
            [
                'provider' => 'google',
                'enabled' => false,
                'client_id' => null,
                'client_secret' => null,
                'redirect_uri' => env('APP_URL') . '/auth/google/callback',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provider' => 'facebook',
                'enabled' => false,
                'client_id' => null,
                'client_secret' => null,
                'redirect_uri' => env('APP_URL') . '/auth/facebook/callback',
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
        Schema::dropIfExists('social_login_settings');
    }
};
