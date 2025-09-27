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
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('email'); // google, facebook
            $table->string('provider_id')->nullable()->after('provider');
            $table->string('avatar')->nullable()->after('provider_id');
            $table->string('phone')->nullable()->after('avatar');
            $table->timestamp('phone_verified_at')->nullable()->after('phone');
            $table->string('login_type')->default('email')->after('phone_verified_at'); // email, google, facebook, phone
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'provider',
                'provider_id', 
                'avatar',
                'phone',
                'phone_verified_at',
                'login_type'
            ]);
        });
    }
};
