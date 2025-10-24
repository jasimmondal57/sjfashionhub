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
        Schema::table('payment_icons', function (Blueprint $table) {
            // Note: payment_icons is already a JSON field, we'll store image info within it
            // No new columns needed as we'll extend the JSON structure
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_icons', function (Blueprint $table) {
            // No columns to drop as we're using existing JSON field
        });
    }
};
