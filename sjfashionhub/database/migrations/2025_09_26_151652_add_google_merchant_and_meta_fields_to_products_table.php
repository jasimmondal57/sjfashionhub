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
            // Only add fields that don't exist yet
            if (!Schema::hasColumn('products', 'additional_images')) {
                $table->json('additional_images')->nullable()->after('images');
            }
            if (!Schema::hasColumn('products', 'product_type')) {
                $table->string('product_type')->nullable()->after('google_product_category');
            }
            if (!Schema::hasColumn('products', 'custom_labels')) {
                $table->json('custom_labels')->nullable()->after('product_type');
            }
            if (!Schema::hasColumn('products', 'facebook_product_id')) {
                $table->string('facebook_product_id')->nullable()->after('custom_labels');
            }
            if (!Schema::hasColumn('products', 'cost_of_goods')) {
                $table->decimal('cost_of_goods', 10, 2)->nullable()->after('facebook_product_id');
            }
            if (!Schema::hasColumn('products', 'seo_description')) {
                $table->string('seo_description')->nullable()->after('meta_description');
            }
            if (!Schema::hasColumn('products', 'seo_keywords')) {
                $table->string('seo_keywords')->nullable()->after('seo_description');
            }
            if (!Schema::hasColumn('products', 'tags')) {
                $table->json('tags')->nullable()->after('seo_keywords');
            }
            if (!Schema::hasColumn('products', 'has_warranty')) {
                $table->boolean('has_warranty')->default(false)->after('tags');
            }
            if (!Schema::hasColumn('products', 'warranty_period')) {
                $table->string('warranty_period')->nullable()->after('has_warranty');
            }
            if (!Schema::hasColumn('products', 'has_return_policy')) {
                $table->boolean('has_return_policy')->default(true)->after('warranty_period');
            }
            if (!Schema::hasColumn('products', 'return_days')) {
                $table->integer('return_days')->default(30)->after('has_return_policy');
            }
            if (!Schema::hasColumn('products', 'rating')) {
                $table->decimal('rating', 3, 2)->nullable()->after('return_days');
            }
            if (!Schema::hasColumn('products', 'review_count')) {
                $table->integer('review_count')->default(0)->after('rating');
            }
            if (!Schema::hasColumn('products', 'low_stock_threshold')) {
                $table->integer('low_stock_threshold')->default(5)->after('stock_quantity');
            }
            if (!Schema::hasColumn('products', 'track_quantity')) {
                $table->boolean('track_quantity')->default(true)->after('low_stock_threshold');
            }
            if (!Schema::hasColumn('products', 'stock_status')) {
                $table->string('stock_status')->default('in_stock')->after('track_quantity');
            }
            if (!Schema::hasColumn('products', 'compare_at_price')) {
                $table->decimal('compare_at_price', 10, 2)->nullable()->after('sale_price');
            }
            if (!Schema::hasColumn('products', 'cost_price')) {
                $table->decimal('cost_price', 10, 2)->nullable()->after('compare_at_price');
            }
            if (!Schema::hasColumn('products', 'price_includes_tax')) {
                $table->boolean('price_includes_tax')->default(true)->after('cost_price');
            }
            if (!Schema::hasColumn('products', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->nullable()->after('price_includes_tax');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'brand', 'gtin', 'mpn', 'identifier_exists', 'google_product_category',
                'condition', 'availability', 'age_group', 'gender', 'size', 'color',
                'material', 'pattern', 'item_group_id', 'shipping_weight',
                'shipping_dimensions', 'shipping_cost', 'shipping_service',
                'additional_images', 'product_type',
                'custom_labels', 'facebook_product_id', 'cost_of_goods',
                'seo_description', 'seo_keywords', 'tags', 'has_warranty',
                'warranty_period', 'has_return_policy', 'return_days',
                'rating', 'review_count', 'low_stock_threshold', 'track_quantity',
                'stock_status', 'compare_at_price', 'cost_price',
                'price_includes_tax', 'tax_rate'
            ]);
        });
    }
};
