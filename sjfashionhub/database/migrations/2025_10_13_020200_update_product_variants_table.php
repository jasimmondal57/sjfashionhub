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
        Schema::table('product_variants', function (Blueprint $table) {
            // Add new option fields (replacing size/color with flexible options)
            $table->string('option1_name')->nullable()->after('product_id'); // e.g., "Size"
            $table->string('option1_value')->nullable()->after('option1_name'); // e.g., "M"
            $table->string('option2_name')->nullable()->after('option1_value'); // e.g., "Color"
            $table->string('option2_value')->nullable()->after('option2_name'); // e.g., "Red"
            $table->string('option3_name')->nullable()->after('option2_value'); // e.g., "Material"
            $table->string('option3_value')->nullable()->after('option3_name'); // e.g., "Cotton"
            
            // Add missing pricing fields
            $table->decimal('compare_at_price', 10, 2)->nullable()->after('price');
            $table->decimal('cost_price', 10, 2)->nullable()->after('compare_at_price');
            
            // Add inventory fields
            $table->integer('low_stock_threshold')->default(5)->after('stock_quantity');
            $table->boolean('track_inventory')->default(true)->after('low_stock_threshold');
            $table->string('stock_location')->nullable()->after('track_inventory');
            
            // Add physical properties
            $table->decimal('weight', 8, 2)->nullable()->after('stock_location');
            $table->decimal('length_cm', 8, 2)->nullable()->after('weight');
            $table->decimal('width_cm', 8, 2)->nullable()->after('length_cm');
            $table->decimal('height_cm', 8, 2)->nullable()->after('width_cm');
            
            // Add media fields
            $table->string('image_url', 500)->nullable()->after('height_cm');
            $table->json('additional_images')->nullable()->after('image_url');
            
            // Add status fields
            $table->boolean('is_default')->default(false)->after('is_active');
            $table->integer('sort_order')->default(0)->after('is_default');
            
            // Add metadata
            $table->json('metadata')->nullable()->after('sort_order');
            
            // Make barcode nullable and add it if it doesn't exist
            if (!Schema::hasColumn('product_variants', 'barcode')) {
                $table->string('barcode')->nullable()->after('sku');
            }
            
            // Add indexes
            $table->index('barcode');
            $table->index(['option1_name', 'option1_value']);
            $table->index(['option2_name', 'option2_value']);
            $table->index(['option3_name', 'option3_value']);
            $table->index('sort_order');
        });
        
        // Update SKU to be nullable and unique
        DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS product_variants_sku_unique ON product_variants(sku)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn([
                'option1_name', 'option1_value', 'option2_name', 'option2_value', 
                'option3_name', 'option3_value', 'compare_at_price', 'cost_price',
                'low_stock_threshold', 'track_inventory', 'stock_location',
                'weight', 'length_cm', 'width_cm', 'height_cm',
                'image_url', 'additional_images', 'is_default', 'sort_order', 'metadata'
            ]);
            
            if (Schema::hasColumn('product_variants', 'barcode')) {
                $table->dropColumn('barcode');
            }
        });
    }
};

