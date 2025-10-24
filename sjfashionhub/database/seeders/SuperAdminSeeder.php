<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the first super admin if it doesn't exist
        \App\Models\User::firstOrCreate(
            ['email' => 'superadmin@sjfashionhub.in'],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@sjfashionhub.in',
                'password' => \Illuminate\Support\Facades\Hash::make('8536945959'),
                'role' => 'super_admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Super Admin created successfully!');
        $this->command->info('Email: superadmin@sjfashionhub.in');
        $this->command->info('Password: 8536945959');
        $this->command->warn('Please change the password after first login!');
    }
}
