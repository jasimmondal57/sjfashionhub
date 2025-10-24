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
            $table->string('last_login_ip')->nullable()->after('last_login_at');
            $table->string('last_login_location')->nullable()->after('last_login_ip');
            $table->string('last_login_country')->nullable()->after('last_login_location');
            $table->text('last_login_user_agent')->nullable()->after('last_login_country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'last_login_ip',
                'last_login_location', 
                'last_login_country',
                'last_login_user_agent'
            ]);
        });
    }
};
