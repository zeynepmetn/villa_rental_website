<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@villaland.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Realtor user
        $realtor = User::create([
            'name' => 'Realtor',
            'email' => 'realtor@villaland.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);
        $realtor->assignRole('realtor');

        // Customer user
        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@villaland.com',
            'password' => Hash::make('123456'),
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');
    }
} 