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
        Schema::create('return_orders', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', [
                'pending',
                'approved',
                'ready_to_return',
                'in_transit',
                'pending_refund',
                'completed',
                'rejected'
            ])->default('pending');

            // Return request details
            $table->enum('return_type', ['refund', 'exchange', 'store_credit'])->default('refund');
            $table->text('return_reason');
            $table->text('customer_notes')->nullable();
            $table->json('return_items'); // Items being returned with quantities
            $table->decimal('return_amount', 10, 2);
            $table->json('return_images')->nullable(); // Images uploaded by customer

            // Admin management
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            // Shiprocket return integration
            $table->string('shiprocket_return_id')->nullable();
            $table->string('return_awb_number')->nullable();
            $table->string('return_courier_company')->nullable();
            $table->integer('return_courier_company_id')->nullable();
            $table->decimal('return_shipping_charges', 8, 2)->nullable();
            $table->string('return_tracking_url')->nullable();
            $table->json('return_courier_details')->nullable();

            // Manual return handling
            $table->boolean('is_manual_return')->default(false);
            $table->string('manual_return_tracking_id')->nullable();
            $table->string('manual_return_courier_name')->nullable();

            // Return timeline
            $table->timestamp('ready_to_return_at')->nullable();
            $table->timestamp('in_transit_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('refund_processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Quality check and refund details
            $table->enum('quality_check_status', ['pending', 'passed', 'failed'])->nullable();
            $table->text('quality_check_notes')->nullable();
            $table->foreignId('quality_checked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('quality_checked_at')->nullable();

            // Refund information
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->decimal('deduction_amount', 10, 2)->default(0);
            $table->text('deduction_reason')->nullable();
            $table->string('refund_method')->nullable(); // original_payment, bank_transfer, store_credit
            $table->string('refund_transaction_id')->nullable();
            $table->json('refund_details')->nullable();

            // Package details for return shipping
            $table->decimal('return_package_weight', 8, 3)->nullable();
            $table->decimal('return_package_length', 8, 2)->nullable();
            $table->decimal('return_package_breadth', 8, 2)->nullable();
            $table->decimal('return_package_height', 8, 2)->nullable();

            // Pickup details
            $table->json('pickup_address')->nullable();
            $table->timestamp('pickup_scheduled_at')->nullable();
            $table->timestamp('pickup_completed_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['order_id', 'status']);
            $table->index(['user_id', 'status']);
            $table->index('return_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_orders');
    }
};
