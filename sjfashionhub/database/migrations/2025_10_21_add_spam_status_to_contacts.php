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
        Schema::table('contacts', function (Blueprint $table) {
            // Change the enum to include 'spam' status
            $table->enum('status', ['new', 'in_progress', 'resolved', 'closed', 'spam'])
                  ->default('new')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Revert to original enum without 'spam'
            $table->enum('status', ['new', 'in_progress', 'resolved', 'closed'])
                  ->default('new')
                  ->change();
        });
    }
};

