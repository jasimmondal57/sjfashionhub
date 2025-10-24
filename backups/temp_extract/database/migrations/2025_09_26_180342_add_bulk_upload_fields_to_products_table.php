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
        Schema::table('products', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('products', 'material')) {
                $table->string('material')->nullable();
            }
            if (!Schema::hasColumn('products', 'pattern')) {
                $table->string('pattern')->nullable();
            }
            if (!Schema::hasColumn('products', 'facebook_product_id')) {
                $table->string('facebook_product_id')->nullable();
            }
            if (!Schema::hasColumn('products', 'cost_of_goods')) {
                $table->decimal('cost_of_goods', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('products', 'has_warranty')) {
                $table->boolean('has_warranty')->default(false);
            }
            if (!Schema::hasColumn('products', 'has_return_policy')) {
                $table->boolean('has_return_policy')->default(true);
            }
            if (!Schema::hasColumn('products', 'warranty_period')) {
                $table->string('warranty_period')->nullable();
            }
            if (!Schema::hasColumn('products', 'return_days')) {
                $table->integer('return_days')->default(30);
            }
            if (!Schema::hasColumn('products', 'identifier_exists')) {
                $table->boolean('identifier_exists')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'facebook_product_id', 'cost_of_goods', 'has_warranty', 'has_return_policy',
                'warranty_period', 'return_days', 'material', 'pattern', 'identifier_exists'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
