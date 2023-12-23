<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\{HasSingleImage, HasSlug};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{HasMany, MorphMany};

class Category extends Model
{
    use SoftDeletes;
    use HasSingleImage;
    use HasSlug;
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }

    public function getAllCategories()
    {
        return cache()->remember('categories', now()->addMonths(1), function () {
            return Category::all();
        });
    }

    public function getAllProducts()
    {
        return $this->products->where('is_published', 1)
        ->sortByDesc('id')
        ->values()
        ->all();
    }

    public function getExpensiveProducts()
    {

       return $this->products->where('is_published', 1)
        ->sortByDesc('price')
        ->values()
        ->all();
    }

    public function getChipsetProducts()
    {

       return $this->products->where('is_published', 1)
        ->sortBy('price')
        ->values()
        ->all();
    }

    public function getLatestProducts()
    {
        return $this->products->where('is_published', 1)
        ->sortByDesc('created_at')
        ->values()
        ->all();
    }

    public function getBestSellingProducts()
    {
        $categoryId = $this->id;

        return Product::whereHas('category', function ($query) use ($categoryId) {
            $query->where('id', $categoryId);
        })
        ->whereHas('orders')
        ->withCount('orders')
        ->having('orders_count', '>=', 3)
        ->orderByDesc('orders_count')
        ->get();
    }

    public function getMostVisitedProducts()
    {
        return $this->products->where('is_published', 1)
        ->sortByDesc('visit')
        ->all();
    }

    public function getProductsPriceRange($minPrice, $maxPrice)
    {
        
        return $this->products->where('is_published', 1)
        ->whereBetween('price', [$minPrice, $maxPrice])
        ->all();
    }

}
