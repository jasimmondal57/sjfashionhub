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
        Schema::create('recaptcha_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(false);
            $table->string('site_key')->nullable();
            $table->string('secret_key')->nullable();
            $table->decimal('threshold', 3, 2)->default(0.5)->comment('Score threshold for reCAPTCHA v3 (0.0-1.0)');
            $table->timestamps();
        });

        // Insert default record
        \DB::table('recaptcha_settings')->insert([
            'enabled' => false,
            'site_key' => null,
            'secret_key' => null,
            'threshold' => 0.5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recaptcha_settings');
    }
};

