<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update redirect URIs to use production domain
        DB::table('social_login_settings')
            ->where('provider', 'google')
            ->update([
                'redirect_uri' => 'https://sjfashionhub.in/auth/google/callback',
                'updated_at' => now()
            ]);

        DB::table('social_login_settings')
            ->where('provider', 'facebook')
            ->update([
                'redirect_uri' => 'https://sjfashionhub.in/auth/facebook/callback',
                'updated_at' => now()
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to localhost URLs (for development)
        DB::table('social_login_settings')
            ->where('provider', 'google')
            ->update([
                'redirect_uri' => 'http://localhost/auth/google/callback',
                'updated_at' => now()
            ]);

        DB::table('social_login_settings')
            ->where('provider', 'facebook')
            ->update([
                'redirect_uri' => 'http://localhost/auth/facebook/callback',
                'updated_at' => now()
            ]);
    }
};
