<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'name' => 'زهرا رهنما',
            'mobile' => '09306756076',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'محمد صادق خوش نظر',
            'mobile' => '09123534024',
            'password' => Hash::make('123456'),
        ]);
    }
}



