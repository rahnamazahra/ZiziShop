<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    protected $fillable = ['title'];

    public function Products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
