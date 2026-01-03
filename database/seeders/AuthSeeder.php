<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_approved' => true,
                'approved_at' => now(),
            ]
        );

        // Freelance
        User::updateOrCreate(
            ['email' => 'freelance@example.com'],
            [
                'name' => 'Freelance User',
                'password' => Hash::make('password123'),
                'role' => 'freelance',
                'is_approved' => true,
                'approved_at' => now(),
            ]
        );

        // Customer
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'is_approved' => true,
                'approved_at' => now(),
            ]
        );

        // Settings for pricing
        Setting::updateOrCreate(
            ['key' => 'freelance_price'],
            ['value' => '2990']
        );

        Setting::updateOrCreate(
            ['key' => 'customer_price'],
            ['value' => '1990']
        );
    }
}
