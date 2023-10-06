<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'sku', 'barcode', 'price', 'discount', 'description', 'inventory', 'category_id', 'weight', 'width', 'Height', ' length', 'feature'];

    public $timestamps = false;

    protected $attributes = [
        'is_healthy' => true,
        'is_published' => true,
    ];

    public function Colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    public function Sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    public function Category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function uploadImage($images):void
    {
        if ($images)
        {
            $storage_dir = '/products';

        }
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
