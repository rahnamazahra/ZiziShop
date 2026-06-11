<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMaterial extends Model
{
    protected $fillable = ['product_id', 'name', 'color', 'quantity', 'weight', 'unit_price'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * هزینه‌ی کل این متریال = تعداد × قیمت واحد
     */
    public function getLineCostAttribute(): int
    {
        return (int) $this->quantity * (int) $this->unit_price;
    }
}
