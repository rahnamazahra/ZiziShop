<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'count', 'feature', 'discount_id', 'sub_category_id', 'description'];

    protected $attributes = [
        'healthy' => true,
        'published' => true,
    ];

    public function Colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    public function Sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }
    public function SubCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function Discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
