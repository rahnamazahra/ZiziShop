<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasSlug;
use  Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, MorphMany};

class Product extends Model
{
    use SoftDeletes;
    use HasSlug;
    protected $fillable = ['name', 'slug', 'sku', 'barcode', 'price', 'discount', 'description', 'inventory', 'is_healthy', 'is_published', 'category_id', 'weight', 'width', 'Height', 'length', 'features'];

    public $timestamps = false;

    protected $casts = [
        'features' => 'array',
    ];

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function generateUniqueSlug($slug)
    {
        $count = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$slug}-" . $count++;
        }

        return $slug;
    }

    public function tagsString(): Attribute
    {
        return Attribute::make(
            get: fn() => implode(', ', $this->tags()->pluck('name')->toArray()),
        );
    }

    public function statusHealtyLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->is_healthy ? 'سالم' : 'ایرادجزئی',
        );
    }

    public function statusPublishedLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->is_published ? 'انتشار' : 'عدم انتشار',
        );
    }

    public function priceLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => number_format($this->price) . ' تومان',
        );
    }

    public function priceWithDiscount(): Attribute
    {
        return Attribute::make(
            get: fn() => number_format($this->price - ($this->price * ($this->discount / 100))) . ' تومان',
        );
    }

    public function getRating(): Attribute
    {
        return Attribute::make(
            get: fn() => ceil($this->ratings()->avg('rating')),
        );
    }

    public function getCategory(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->category->name,
        );
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%")
               ->orWhere('sku', 'like', "%$search%")
               ->orWhere('barcode', 'like', "%$search%");
    }

    public static function scopePublishstatusProducts($query, $is_published)
    {

        return $query->where('is_published', $is_published);
    }

    public static function scopeHealtystatusProducts($query, $is_healthy)
    {
        return $query->where('is_healthy', $is_healthy);
    }

    public static function scopeFindProductCategory($query, $category)
    {
        return $query->where('category_id', $category);
    }

    public function getBestSellersOfTheWeek()
    {
        return $this->withCount('orders', function (Builder $query) {
                $query->where('created_at','>=', Carbon::today()->subDays(7));
            })->oredrBy('orders_count')
            ->take(6)
            ->get();
    }
}
