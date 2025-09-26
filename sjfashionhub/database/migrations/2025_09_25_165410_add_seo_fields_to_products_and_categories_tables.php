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
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->string('seo_title')->nullable()->after('meta_keywords');
            $table->text('long_description')->nullable()->after('description');
            $table->json('structured_data')->nullable()->after('seo_title');
            $table->boolean('seo_generated')->default(false)->after('structured_data');
            $table->timestamp('seo_generated_at')->nullable()->after('seo_generated');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->string('seo_title')->nullable()->after('meta_keywords');
            $table->json('structured_data')->nullable()->after('seo_title');
            $table->boolean('seo_generated')->default(false)->after('structured_data');
            $table->timestamp('seo_generated_at')->nullable()->after('seo_generated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'meta_keywords',
                'seo_title',
                'long_description',
                'structured_data',
                'seo_generated',
                'seo_generated_at'
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'meta_keywords',
                'seo_title',
                'structured_data',
                'seo_generated',
                'seo_generated_at'
            ]);
        });
    }
};
