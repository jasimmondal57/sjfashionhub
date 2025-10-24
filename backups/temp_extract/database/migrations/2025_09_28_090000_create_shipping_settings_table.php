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
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            
            // Basic shipping configuration
            $table->enum('shipping_method', ['flat_rate', 'weight_based', 'location_based', 'free'])->default('flat_rate');
            $table->boolean('is_enabled')->default(true);
            $table->decimal('flat_rate', 10, 2)->default(99.00);
            
            // Free shipping settings
            $table->boolean('free_shipping_enabled')->default(false);
            $table->decimal('free_shipping_threshold', 10, 2)->default(500.00);
            
            // Weight-based shipping
            $table->boolean('weight_based_enabled')->default(false);
            $table->json('weight_rates')->nullable(); // Array of weight ranges and rates
            
            // Location-based shipping
            $table->boolean('location_based_enabled')->default(false);
            $table->json('location_rates')->nullable(); // Array of zones and rates
            
            // Express shipping
            $table->boolean('express_shipping_enabled')->default(false);
            $table->decimal('express_shipping_rate', 10, 2)->default(199.00);
            $table->integer('express_shipping_days')->default(1);
            $table->integer('standard_shipping_days')->default(5);
            
            // Tax and fees
            $table->boolean('shipping_tax_enabled')->default(false);
            $table->decimal('shipping_tax_rate', 5, 2)->default(18.00);
            $table->decimal('handling_fee', 10, 2)->default(0.00);
            $table->decimal('packaging_fee', 10, 2)->default(0.00);
            
            // COD settings
            $table->decimal('cod_charges', 10, 2)->default(0.00);
            $table->boolean('cod_enabled')->default(true);
            
            // International shipping
            $table->boolean('international_shipping_enabled')->default(false);
            $table->decimal('international_shipping_rate', 10, 2)->default(999.00);
            
            // Shipping zones and defaults
            $table->json('shipping_zones')->nullable();
            $table->decimal('default_weight', 8, 2)->default(0.5);
            $table->enum('weight_unit', ['kg', 'g', 'lb', 'oz'])->default('kg');
            $table->enum('dimension_unit', ['cm', 'm', 'in', 'ft'])->default('cm');
            $table->enum('calculation_method', ['highest_rate', 'sum_rates', 'average_rate'])->default('highest_rate');
            
            // Additional settings as JSON
            $table->json('settings_data')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};
