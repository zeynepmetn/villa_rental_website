<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create realtor user
        $realtor = User::create([
            'name' => 'Realtor User',
            'email' => 'realtor@example.com',
            'password' => Hash::make('password'),
            'phone' => '+90 555 123 4567',
            'address' => 'İstanbul, Turkey',
            'email_verified_at' => now(),
        ]);
        $realtor->assignRole('realtor');

        // Create customer user
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '+90 555 987 6543',
            'address' => 'Ankara, Turkey',
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');
    }
} 