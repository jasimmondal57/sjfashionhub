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
        // Create whatsapp_accounts table
        Schema::create('whatsapp_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Account nickname (e.g., "Main Account", "Backup Account")
            $table->string('business_account_id')->unique();
            $table->string('phone_number_id');
            $table->string('display_phone_number')->nullable();
            $table->string('verified_name')->nullable();
            $table->text('access_token'); // Encrypted
            $table->string('api_version')->default('v18.0');
            $table->string('quality_rating')->nullable();
            $table->string('messaging_limit_tier')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->text('webhook_url')->nullable();
            $table->string('webhook_verify_token')->nullable();
            $table->json('metadata')->nullable(); // Additional settings
            $table->timestamps();
            $table->softDeletes();
        });

        // Add account_id to whatsapp_templates
        Schema::table('whatsapp_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->after('id');
            $table->foreign('account_id')->references('id')->on('whatsapp_accounts')->onDelete('cascade');

            // Add sync tracking (check if column exists first)
            if (!Schema::hasColumn('whatsapp_templates', 'whatsapp_template_id')) {
                $table->string('whatsapp_template_id')->nullable()->after('name');
            }
            if (!Schema::hasColumn('whatsapp_templates', 'last_synced_at')) {
                $table->timestamp('last_synced_at')->nullable();
            }
        });

        // Add account_id to whatsapp_campaigns
        Schema::table('whatsapp_campaigns', function (Blueprint $table) {
            $table->unsignedBigInteger('account_id')->nullable()->after('id');
            $table->foreign('account_id')->references('id')->on('whatsapp_accounts')->onDelete('set null');
        });

        // Migrate existing data from communication_settings to whatsapp_accounts
        $existingSettings = DB::table('communication_settings')
            ->where('provider', 'whatsapp')
            ->where('service', 'whatsapp_business')
            ->get()
            ->pluck('value', 'key');

        if ($existingSettings->isNotEmpty()) {
            $accountId = DB::table('whatsapp_accounts')->insertGetId([
                'name' => 'Main Account',
                'business_account_id' => $existingSettings['business_account_id'] ?? '',
                'phone_number_id' => $existingSettings['phone_number'] ?? '',
                'access_token' => $existingSettings['api_key'] ?? '',
                'api_version' => $existingSettings['api_version'] ?? 'v18.0',
                'webhook_url' => $existingSettings['webhook_url'] ?? null,
                'webhook_verify_token' => $existingSettings['webhook_verify_token'] ?? null,
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update existing templates to use this account
            DB::table('whatsapp_templates')->update(['account_id' => $accountId]);
            
            // Update existing campaigns to use this account
            DB::table('whatsapp_campaigns')->update(['account_id' => $accountId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_campaigns', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropColumn('account_id');
        });

        Schema::table('whatsapp_templates', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropColumn(['account_id', 'whatsapp_template_id', 'last_synced_at']);
        });

        Schema::dropIfExists('whatsapp_accounts');
    }
};

