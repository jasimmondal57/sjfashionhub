<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all products to have stock quantity of 50 if they have 0 or null
        DB::table('products')
            ->where(function($query) {
                $query->where('stock_quantity', 0)
                      ->orWhereNull('stock_quantity');
            })
            ->update(['stock_quantity' => 50]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert back to 0
        DB::table('products')->update(['stock_quantity' => 0]);
    }
};
