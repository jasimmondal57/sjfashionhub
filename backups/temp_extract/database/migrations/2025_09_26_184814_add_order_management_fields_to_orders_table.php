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
            // Enhanced status management
            $table->enum('order_status', [
                'pending', 'confirmed', 'ready_to_ship', 'in_transit',
                'out_for_delivery', 'delivered', 'cancelled', 'rto'
            ])->default('pending')->after('status');

            // Shiprocket integration fields
            $table->string('shiprocket_order_id')->nullable()->after('order_status');
            $table->string('shiprocket_shipment_id')->nullable()->after('shiprocket_order_id');
            $table->string('awb_number')->nullable()->after('shiprocket_shipment_id');
            $table->string('courier_company')->nullable()->after('awb_number');
            $table->string('courier_company_id')->nullable()->after('courier_company');
            $table->decimal('shipping_charges', 8, 2)->nullable()->after('courier_company_id');
            $table->string('tracking_url')->nullable()->after('shipping_charges');
            $table->json('courier_details')->nullable()->after('tracking_url');

            // Manual shipping fields
            $table->boolean('is_manual_shipping')->default(false)->after('courier_details');
            $table->string('manual_tracking_id')->nullable()->after('is_manual_shipping');
            $table->string('manual_courier_name')->nullable()->after('manual_tracking_id');

            // Order management fields
            $table->timestamp('confirmed_at')->nullable()->after('manual_courier_name');
            $table->timestamp('ready_to_ship_at')->nullable()->after('confirmed_at');
            $table->timestamp('in_transit_at')->nullable()->after('ready_to_ship_at');
            $table->timestamp('out_for_delivery_at')->nullable()->after('in_transit_at');
            $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
            $table->timestamp('rto_at')->nullable()->after('cancelled_at');

            // Admin management
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->after('rto_at');
            $table->text('admin_notes')->nullable()->after('confirmed_by');
            $table->text('cancellation_reason')->nullable()->after('admin_notes');
            $table->text('rto_reason')->nullable()->after('cancellation_reason');

            // Delivery details
            $table->string('delivery_attempts')->default(0)->after('rto_reason');
            $table->json('delivery_updates')->nullable()->after('delivery_attempts');
            $table->decimal('cod_amount', 10, 2)->nullable()->after('delivery_updates');
            $table->boolean('is_cod')->default(false)->after('cod_amount');

            // Weight and dimensions for shipping
            $table->decimal('package_weight', 8, 3)->nullable()->after('is_cod');
            $table->decimal('package_length', 8, 2)->nullable()->after('package_weight');
            $table->decimal('package_breadth', 8, 2)->nullable()->after('package_length');
            $table->decimal('package_height', 8, 2)->nullable()->after('package_breadth');

            // Estimated delivery
            $table->date('estimated_delivery_date')->nullable()->after('package_height');
            $table->integer('estimated_delivery_days')->nullable()->after('estimated_delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'order_status', 'shiprocket_order_id', 'shiprocket_shipment_id', 'awb_number',
                'courier_company', 'courier_company_id', 'shipping_charges', 'tracking_url',
                'courier_details', 'is_manual_shipping', 'manual_tracking_id', 'manual_courier_name',
                'confirmed_at', 'ready_to_ship_at', 'in_transit_at', 'out_for_delivery_at',
                'cancelled_at', 'rto_at', 'confirmed_by', 'admin_notes', 'cancellation_reason',
                'rto_reason', 'delivery_attempts', 'delivery_updates', 'cod_amount', 'is_cod',
                'package_weight', 'package_length', 'package_breadth', 'package_height',
                'estimated_delivery_date', 'estimated_delivery_days'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
