<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    protected $fillable = ['title', 'discount_percentage', 'minimum_purchase'];

    protected $attributes = ['start_date', 'end_date'];

    public function Products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
