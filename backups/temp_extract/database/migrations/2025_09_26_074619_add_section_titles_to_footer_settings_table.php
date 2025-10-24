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
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->string('quick_links_title')->default('Quick Links')->after('additional_links');
            $table->string('customer_service_title')->default('Customer Service')->after('quick_links_title');
            $table->string('categories_title')->default('Categories')->after('customer_service_title');
            $table->string('additional_title')->default('More')->after('categories_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->dropColumn(['quick_links_title', 'customer_service_title', 'categories_title', 'additional_title']);
        });
    }
};
