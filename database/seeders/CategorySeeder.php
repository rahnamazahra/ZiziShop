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
        $categories = [
            ['name' => 'گوشواره',       'slug' => 'goshvare'],
            ['name' => 'نیم‌ست',         'slug' => 'nim-set'],
            ['name' => 'دستبند',        'slug' => 'dastband'],
            ['name' => 'انگشتر',        'slug' => 'angoshtar'],
            ['name' => 'گل سینه',        'slug' => 'gol-sine'],
            ['name' => 'تاج و تل',       'slug' => 'taj-o-tal'],
            ['name' => 'گردنبند',       'slug' => 'gardanband'],
            ['name' => 'آویز مانتویی',   'slug' => 'avize-mantoyi'],
            ['name' => 'نشان کتاب',      'slug' => 'neshan-ketab'],
            ['name' => 'ست هدیه',        'slug' => 'set-hediye'],
            ['name' => 'ست مردانه و زنانه', 'slug' => 'set-zananeh-mardaneh'],
            ['name' => 'بند عینک',       'slug' => 'band-eynak'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        Product::factory(30)->make()->each(function ($product) {
            $product->category()->associate(Category::inRandomOrder()->first());
            $product->save();
        });

    }
}
