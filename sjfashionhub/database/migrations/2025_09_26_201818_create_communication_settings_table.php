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
        Schema::create('communication_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // email, sms, whatsapp
            $table->string('service'); // smtp, twilio, msg91, whatsapp_business, etc.
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, json, encrypted
            $table->string('category')->default('general'); // general, api, webhook, template
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_encrypted')->default(false);
            $table->json('metadata')->nullable(); // Additional configuration data
            $table->timestamps();

            $table->unique(['provider', 'service', 'key']);
            $table->index(['provider', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_settings');
    }
};
