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
        Schema::create('maintenance_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(false);
            $table->string('password')->nullable(); // Hashed password
            $table->text('message')->nullable(); // Custom maintenance message
            $table->string('title')->default('Site Maintenance');
            $table->text('description')->default('We are currently performing maintenance. We will be back online shortly.');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expected_end_at')->nullable();
            $table->unsignedBigInteger('enabled_by')->nullable(); // Admin user who enabled it
            $table->timestamps();
        });

        // Insert default record
        \DB::table('maintenance_settings')->insert([
            'is_enabled' => false,
            'title' => 'Site Maintenance',
            'description' => 'We are currently performing maintenance. We will be back online shortly.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_settings');
    }
};

