<?php

namespace App\Models;


use App\Traits\HasSlug;
use  Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany, HasMany, MorphMany};

class Product extends Model
{
    use SoftDeletes;
    use HasSlug;
    use HasFactory;

    protected $fillable = ['name', 'slug', 'sku', 'barcode', 'price', 'discount', 'description', 'inventory', 'is_healthy', 'is_published', 'category_id', 'weight', 'width', 'Height', 'length', 'features'];

    public $timestamps = false;

    protected $casts = [
        'features' => 'array',
    ];

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'stocks');
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'stocks');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
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

    public function oldPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->formatPrice($this->price),
        );
    }

    public function newPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->formatPrice($this->formatDiscountCalculation($this->price, $this->discount)),
        );
    }

    public function formatPrice(int $price)
    {
        return number_format($price) . ' تومان';
    }

    private function formatDiscountCalculation(int $price, int $discount)
    {
       return $price - ($price * $discount / 100);
    }

    public function getRating(): Attribute
    {
        return Attribute::make(
            get: fn() => ceil($this->ratings()->avg('rating')),
        );
    }

    public function getRatingOne(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->ratings()->where('rating', 1)->count('rating'),
        );
    }

    public function getRatingTwo(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->ratings()->where('rating', 2)->count('rating'),
        );
    }

    public function getRatingThree(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->ratings()->where('rating', 3)->count('rating'),
        );
    }

    public function getRatingFour(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->ratings()->where('rating', 4)->count('rating'),
        );
    }

    public function getRatingFive(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->ratings()->where('rating', 5)->count('rating'),
        );
    }

    public function getVote(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->ratings()->count(),
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

    public static function getBestSellersOfTheWeek()
    {
        return cache()->remember('bestSellersOfTheWeek', now()->addDays(1), function () {
            return self::whereHas('orders', function ($query) {
                $query->where('orders.created_at', '>=', Carbon::today()->subDays(7));
            })
            ->withCount('orders')
            ->having('orders_count', '>=', 3)
            ->take(4)
            ->get();
        });
    }

}

