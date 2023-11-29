<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;


class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory(10)->create();
        Product::factory(30)->make()->each(function ($product) {
            $product->category()->associate(Category::inRandomOrder()->first());
            $product->save();
        });

    }
}
