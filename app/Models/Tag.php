<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['title'];
    public $timestamps = false;

    public function Products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
