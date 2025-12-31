<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Villa permissions
            'view villas',
            'create villa',
            'edit villa',
            'delete villa',
            'manage villa images',
            'manage villa features',
            
            // Location permissions
            'view locations',
            'create location',
            'edit location',
            'delete location',
            
            // Feature permissions
            'view features',
            'create feature',
            'edit feature',
            'delete feature',
            
            // Booking permissions
            'view bookings',
            'create booking',
            'edit booking',
            'cancel booking',
            'manage booking status',
            
            // User permissions
            'view users',
            'create user',
            'edit user',
            'delete user',
            'manage user roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Realtor role
        $realtorRole = Role::create(['name' => 'realtor']);
        $realtorRole->givePermissionTo([
            'view villas',
            'create villa',
            'edit villa',
            'delete villa',
            'manage villa images',
            'manage villa features',
            'view bookings',
            'manage booking status',
            'view locations',
            'view features',
        ]);

        // Customer role
        $customerRole = Role::create(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'view villas',
            'view locations',
            'view features',
            'create booking',
            'view bookings',
            'cancel booking',
        ]);
    }
} 