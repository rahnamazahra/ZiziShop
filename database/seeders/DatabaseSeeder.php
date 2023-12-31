<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(ProvinceCitySeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
