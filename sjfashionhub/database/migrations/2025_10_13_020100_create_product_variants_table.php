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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Variant Options (up to 3 options like Shopify)
            $table->string('option1_name')->nullable(); // e.g., "Size"
            $table->string('option1_value')->nullable(); // e.g., "M"
            $table->string('option2_name')->nullable(); // e.g., "Color"
            $table->string('option2_value')->nullable(); // e.g., "Red"
            $table->string('option3_name')->nullable(); // e.g., "Material"
            $table->string('option3_value')->nullable(); // e.g., "Cotton"
            
            // Variant-Specific Fields
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            
            // Inventory
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->boolean('track_inventory')->default(true);
            $table->string('stock_location')->nullable();
            
            // Physical Properties
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length_cm', 8, 2)->nullable();
            $table->decimal('width_cm', 8, 2)->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            
            // Media
            $table->string('image_url', 500)->nullable();
            $table->json('additional_images')->nullable();
            
            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false); // Default variant for product
            $table->integer('sort_order')->default(0);
            
            // Metadata
            $table->json('metadata')->nullable(); // For any additional variant-specific data
            
            $table->timestamps();
            
            // Indexes
            $table->index('product_id');
            $table->index('sku');
            $table->index('barcode');
            $table->index(['option1_name', 'option1_value']);
            $table->index(['option2_name', 'option2_value']);
            $table->index(['option3_name', 'option3_value']);
            $table->index('is_active');
            $table->index('sort_order');
            
            // Unique constraint for variant combinations
            $table->unique(['product_id', 'option1_value', 'option2_value', 'option3_value'], 'unique_variant_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

