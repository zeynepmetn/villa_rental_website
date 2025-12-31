<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            LocationSeeder::class,
            VillaSeeder::class,
            FeatureSeeder::class,
            BookingSeeder::class,
        ]);
    }
} 