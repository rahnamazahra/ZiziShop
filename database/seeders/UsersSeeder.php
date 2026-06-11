<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    public function run()
    {
        $user = User::firstOrCreate(
            ['mobile' => '09306756076'],
            [
                'name' => 'زهرا رهنما',
                'password' => Hash::make('123456'),
            ]
        );

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $user->roles()->syncWithoutDetaching([$adminRole->id]);
    }
}
