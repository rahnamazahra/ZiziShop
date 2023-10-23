<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\{HasSingleImage, HasSlug};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{HasMany, MorphMany};

class Category extends Model
{
    use SoftDeletes;
    use HasSingleImage;
    use HasSlug;

    protected $fillable = ['name', 'slug', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }

}
