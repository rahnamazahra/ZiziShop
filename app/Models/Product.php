<?php

namespace App\Models;


use App\Traits\HasSlug;
use  Illuminate\Support\Carbon;
use App\Traits\HasDemoFlag;
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
    use HasDemoFlag;

    protected $fillable = ['name', 'slug', 'sku', 'barcode', 'price', 'cost_price', 'discount', 'description', 'inventory', 'is_healthy', 'is_published', 'category_id', 'weight', 'width', 'Height', 'length', 'features', 'is_demo'];

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
        return $this->morphMany(Image::class, 'imageable')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * تعداد مجاز مدیا (عکس/فیلم) برای هر محصول
     */
    public const MAX_MEDIA = 5;

    /**
     * اولین مدیای محصول (می‌تواند عکس یا فیلم باشد)
     */
    public function mainMedia(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->images->first(),
        );
    }

    /**
     * آدرس تصویر شاخص برای کارت‌ها و لیست‌ها.
     * اگر اولین مدیا فیلم باشد، اولین عکسِ محصول استفاده می‌شود؛
     * در نبود هر عکسی، تصویر پیش‌فرض برمی‌گردد.
     */
    public function posterUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $firstImage = $this->images->firstWhere('type', 'image');

                return $firstImage
                    ? asset('storage/' . $firstImage->path)
                    : asset('site/assets/img/product/2/prodcut-1.jpg');
            },
        );
    }

    public function isInStock(): bool
    {
        return (int) $this->inventory > 0;
    }

    /**
     * متریال‌های مصرفیِ محصول (برای محاسبه‌ی قیمت تمام‌شده).
     */
    public function materials(): HasMany
    {
        return $this->hasMany(ProductMaterial::class);
    }

    /**
     * محاسبه‌ی مجدد قیمت تمام‌شده از روی جمع هزینه‌ی متریال‌ها.
     */
    public function recomputeCostPrice(): void
    {
        $sum = (int) $this->materials()->sum(\Illuminate\Support\Facades\DB::raw('quantity * unit_price'));

        if ($sum > 0) {
            $this->forceFill(['cost_price' => $sum])->saveQuietly();
        }
    }

    /**
     * تحلیل سود این محصول از روی سفارش‌های واقعی (غیرتستی).
     * شامل: درآمد، تعداد فروخته‌شده، قیمت تمام‌شده‌ی کل و سود.
     */
    public function profitAnalysis(): array
    {
        $lines = \Illuminate\Support\Facades\DB::table('order_product')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->where('order_product.product_id', $this->id)
            ->where('orders.is_demo', false)
            ->selectRaw('COALESCE(SUM(order_product.price * order_product.count),0) as revenue, COALESCE(SUM(order_product.count),0) as units')
            ->first();

        $revenue = (int) ($lines->revenue ?? 0);
        $units   = (int) ($lines->units ?? 0);
        $cost    = $units * (int) $this->cost_price;

        return [
            'revenue' => $revenue,
            'units'   => $units,
            'cost'    => $cost,
            'profit'  => $revenue - $cost,
            'margin'  => $revenue > 0 ? round(($revenue - $cost) / $revenue * 100) : 0,
        ];
    }

    /**
     * کوپن عمومیِ فعالِ مخصوص این محصول (برای نمایش قیمت تخفیف‌خورده در سایت).
     */
    public function activeProductVoucher()
    {
        return \App\Models\Voucher::where('product_id', $this->id)
            ->whereNull('user_id')
            ->where('remaining', '>', 0)
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', now()->toDateString());
            })
            ->first();
    }

    /**
     * آیا محصول تنوع قیمت‌دار (سایز/رنگ با قیمت مجزا) دارد؟
     */
    public function hasPricedVariants(): bool
    {
        return $this->stocks->where('price', '>', 0)->isNotEmpty();
    }

    /**
     * کمترین قیمت بین تنوع‌ها (برای نمایش «شروع از…»). در نبود تنوع قیمت‌دار، قیمت پایه.
     */
    public function startingPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                $min = $this->stocks->where('price', '>', 0)->min('price');

                return $min ?: $this->price;
            },
        );
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

    public function checkProductStock($product,$quantity)
    {

        if($product->inventory >= $quantity)
        {
            return $this->reduceProductStock($product, $quantity);
        }
        return false;
    }

    public function reduceProductStock($product, $quantity)
    {

        return Product::whereId($product->id)->decrement('inventory', $quantity);

    }

}

