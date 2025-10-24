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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'shiprocket_shipment_id')) {
                $table->string('shiprocket_shipment_id')->nullable()->after('tracking_number');
            }
            if (!Schema::hasColumn('orders', 'courier_name')) {
                $table->string('courier_name')->nullable()->after('shiprocket_shipment_id');
            }
            if (!Schema::hasColumn('orders', 'estimated_delivery_date')) {
                $table->timestamp('estimated_delivery_date')->nullable()->after('courier_name');
            }
            if (!Schema::hasColumn('orders', 'latest_scan_activity')) {
                $table->string('latest_scan_activity')->nullable()->after('estimated_delivery_date');
            }
            if (!Schema::hasColumn('orders', 'latest_scan_location')) {
                $table->string('latest_scan_location')->nullable()->after('latest_scan_activity');
            }
            if (!Schema::hasColumn('orders', 'latest_scan_date')) {
                $table->timestamp('latest_scan_date')->nullable()->after('latest_scan_location');
            }
            if (!Schema::hasColumn('orders', 'webhook_history')) {
                $table->json('webhook_history')->nullable()->after('latest_scan_date');
            }
            if (!Schema::hasColumn('orders', 'status_history')) {
                $table->json('status_history')->nullable()->after('webhook_history');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shiprocket_shipment_id',
                'courier_name',
                'estimated_delivery_date',
                'latest_scan_activity',
                'latest_scan_location',
                'latest_scan_date',
                'webhook_history',
                'status_history'
            ]);
        });
    }
};

