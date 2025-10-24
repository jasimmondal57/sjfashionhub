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
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('SJ Fashion Hub');
            $table->text('company_description')->nullable();
            $table->json('contact_info')->nullable(); // phone, email, address
            $table->json('social_links')->nullable(); // facebook, instagram, twitter, etc.
            $table->json('quick_links')->nullable(); // About, Contact, Privacy Policy, etc.
            $table->json('customer_service_links')->nullable(); // FAQ, Shipping, Returns, etc.
            $table->json('categories_links')->nullable(); // Men, Women, Kids, etc.
            $table->string('copyright_text')->nullable();
            $table->json('payment_methods')->nullable(); // visa, mastercard, paypal, etc.
            $table->text('newsletter_text')->nullable();
            $table->boolean('show_newsletter')->default(true);
            $table->boolean('show_social_links')->default(true);
            $table->boolean('show_payment_methods')->default(true);
            $table->string('background_color')->default('#ffffff');
            $table->string('text_color')->default('#374151');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
