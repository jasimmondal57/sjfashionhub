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
            // Inventory & Stock Management
            $table->string('barcode')->nullable()->after('sku');
            $table->string('supplier_name')->nullable();
            $table->string('supplier_sku')->nullable();
            $table->decimal('supplier_cost', 10, 2)->nullable();
            $table->integer('supplier_lead_time_days')->nullable();
            $table->integer('reorder_point')->default(0);
            $table->integer('reorder_quantity')->default(0);
            $table->string('stock_location')->nullable();
            $table->enum('backorder_status', ['no', 'notify', 'yes'])->default('no');
            $table->boolean('allow_preorder')->default(false);
            $table->date('preorder_release_date')->nullable();
            
            // Product Attributes (Fashion-Specific)
            $table->text('fabric_composition')->nullable();
            $table->text('care_instructions')->nullable();
            $table->string('fit_type')->nullable(); // Regular, Slim, Loose, Oversized
            $table->string('occasion')->nullable(); // Casual, Formal, Party, Wedding, Festive
            $table->string('sleeve_type')->nullable(); // Full, Half, Sleeveless, 3/4
            $table->string('neck_type')->nullable(); // Round, V-neck, Collar, Boat neck
            $table->string('length_type')->nullable(); // Knee-length, Ankle-length, etc.
            $table->string('closure_type')->nullable(); // Zipper, Button, Hook, Drawstring
            $table->string('pocket_details')->nullable();
            $table->boolean('has_lining')->default(false);
            $table->enum('transparency', ['opaque', 'semi-transparent', 'sheer'])->nullable();
            $table->boolean('is_stretchable')->default(false);
            $table->string('season')->nullable(); // Summer, Winter, All-season, Monsoon
            $table->string('style_code')->nullable();
            $table->string('collection_name')->nullable();
            
            // Shipping & Dimensions (Detailed)
            $table->decimal('length_cm', 8, 2)->nullable();
            $table->decimal('width_cm', 8, 2)->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            $table->decimal('volumetric_weight', 8, 2)->nullable();
            $table->string('package_type')->nullable(); // Box, Poly bag, Envelope
            $table->boolean('is_fragile')->default(false);
            $table->boolean('requires_signature')->default(false);
            $table->string('shipping_class')->nullable(); // Standard, Express, Heavy, Oversized
            
            // Pricing & Promotions
            $table->decimal('bulk_price_tier1_qty', 10, 2)->nullable();
            $table->decimal('bulk_price_tier1_price', 10, 2)->nullable();
            $table->decimal('bulk_price_tier2_qty', 10, 2)->nullable();
            $table->decimal('bulk_price_tier2_price', 10, 2)->nullable();
            $table->decimal('bulk_price_tier3_qty', 10, 2)->nullable();
            $table->decimal('bulk_price_tier3_price', 10, 2)->nullable();
            $table->decimal('member_price', 10, 2)->nullable();
            $table->dateTime('sale_start_date')->nullable();
            $table->dateTime('sale_end_date')->nullable();
            $table->integer('min_order_quantity')->default(1);
            $table->integer('max_order_quantity')->nullable();
            $table->integer('quantity_increment')->default(1);
            $table->decimal('wholesale_price', 10, 2)->nullable();
            $table->decimal('margin_percentage', 5, 2)->nullable();
            
            // Media & Content
            $table->string('video_url', 500)->nullable();
            $table->text('model_info')->nullable(); // "Model is 5'6" wearing size M"
            $table->json('lifestyle_images')->nullable();
            $table->json('image_360_urls')->nullable();
            $table->json('product_documents')->nullable(); // PDFs, guides
            
            // SEO & Marketing
            $table->string('url_slug')->nullable()->unique();
            $table->string('canonical_url', 500)->nullable();
            $table->string('meta_robots')->nullable(); // index,follow
            $table->string('og_image_url', 500)->nullable();
            $table->string('twitter_card_type')->nullable();
            $table->string('schema_type')->default('Product');
            $table->json('product_badges')->nullable(); // New, Sale, Hot, Limited
            $table->json('product_labels')->nullable();
            $table->date('launch_date')->nullable();
            $table->date('discontinue_date')->nullable();
            
            // Additional Features
            $table->boolean('enable_reviews')->default(true);
            $table->boolean('enable_questions')->default(true);
            $table->boolean('allow_personalization')->default(false);
            $table->text('personalization_instructions')->nullable();
            $table->boolean('gift_wrap_available')->default(false);
            $table->decimal('gift_wrap_price', 10, 2)->nullable();
            $table->boolean('allow_gift_message')->default(false);
            $table->boolean('assembly_required')->default(false);
            $table->json('certifications')->nullable(); // Organic, Fair Trade, etc.
            $table->text('sustainability_info')->nullable();
            $table->boolean('made_to_order')->default(false);
            $table->integer('production_time_days')->nullable();
            
            // Additional Info
            $table->text('wash_care_symbols')->nullable();
            $table->string('country_of_manufacture')->nullable();
            $table->boolean('is_eco_friendly')->default(false);
            $table->boolean('is_handmade')->default(false);
            $table->text('special_features')->nullable();
            
            // Add indexes for commonly queried fields
            $table->index('barcode');
            $table->index('supplier_name');
            $table->index('fit_type');
            $table->index('occasion');
            $table->index('season');
            $table->index('url_slug');
            $table->index('sale_start_date');
            $table->index('sale_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Inventory & Stock Management
            $table->dropColumn([
                'barcode', 'supplier_name', 'supplier_sku', 'supplier_cost', 'supplier_lead_time_days',
                'reorder_point', 'reorder_quantity', 'stock_location', 'backorder_status',
                'allow_preorder', 'preorder_release_date'
            ]);
            
            // Product Attributes
            $table->dropColumn([
                'fabric_composition', 'care_instructions', 'fit_type', 'occasion', 'sleeve_type',
                'neck_type', 'length_type', 'closure_type', 'pocket_details', 'has_lining',
                'transparency', 'is_stretchable', 'season', 'style_code', 'collection_name'
            ]);
            
            // Shipping & Dimensions
            $table->dropColumn([
                'length_cm', 'width_cm', 'height_cm', 'volumetric_weight', 'package_type',
                'is_fragile', 'requires_signature', 'shipping_class'
            ]);
            
            // Pricing & Promotions
            $table->dropColumn([
                'bulk_price_tier1_qty', 'bulk_price_tier1_price', 'bulk_price_tier2_qty',
                'bulk_price_tier2_price', 'bulk_price_tier3_qty', 'bulk_price_tier3_price',
                'member_price', 'sale_start_date', 'sale_end_date', 'min_order_quantity',
                'max_order_quantity', 'quantity_increment', 'wholesale_price', 'margin_percentage'
            ]);
            
            // Media & Content
            $table->dropColumn([
                'video_url', 'model_info', 'lifestyle_images', 'image_360_urls', 'product_documents'
            ]);
            
            // SEO & Marketing
            $table->dropColumn([
                'url_slug', 'canonical_url', 'meta_robots', 'og_image_url', 'twitter_card_type',
                'schema_type', 'product_badges', 'product_labels', 'launch_date', 'discontinue_date'
            ]);
            
            // Additional Features
            $table->dropColumn([
                'enable_reviews', 'enable_questions', 'allow_personalization', 'personalization_instructions',
                'gift_wrap_available', 'gift_wrap_price', 'allow_gift_message', 'assembly_required',
                'certifications', 'sustainability_info', 'made_to_order', 'production_time_days'
            ]);
            
            // Additional Info
            $table->dropColumn([
                'wash_care_symbols', 'country_of_manufacture', 'is_eco_friendly', 'is_handmade', 'special_features'
            ]);
        });
    }
};

