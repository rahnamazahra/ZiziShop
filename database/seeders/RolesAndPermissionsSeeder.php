<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $programmerRole = Role::create(['name' => 'developer']);
        $adminRole      = Role::create(['name' => 'admin']);
        $sellerRole     = Role::create(['name' => 'seller']);
        $userRole       = Role::create(['name' => 'user']);

        // Create permissions
        $permission_admin_index = Permission::create([
            'name'       => 'داشبورد',
            'slug'        => 'admin-index',
            'description' => 'امکان مشاهده داشبورد',
        ]);

        // Assign permissions to roles
        $permission_admin_index->roles()->sync([$programmerRole->id, $adminRole->id]);
    }
}



