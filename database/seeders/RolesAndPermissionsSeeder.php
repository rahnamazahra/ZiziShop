<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $programmerRole = Role::create(['name' => 'برنامه نویس', 'slug' => 'developer', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        $adminRole      = Role::create(['name' => 'ادمین', 'slug' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        $sellerRole     = Role::create(['name' => 'فروشنده', 'slug' => 'seller', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        $userRole       = Role::create(['name' => 'کاربر', 'slug' => 'user', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

        // Create permissions
        $permission_admin_index = Permission::create([
            'name'       => 'داشبورد',
            'slug'        => 'admin-index',
            'description' => 'امکان مشاهده داشبورد',
        ]);

        // Assign permissions to roles
        $permission_admin_index->roles()->attach([$programmerRole, $adminRole]);
    }
}
