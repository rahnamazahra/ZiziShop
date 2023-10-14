<?php

namespace App\Models;

use App\Casts\{status};

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, MorphMany};
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }

    public function generateUniqueSlug($slug)
    {
        $count = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$slug}-" . $count++;
        }

        return $slug;
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk('public')->url($this->image->path),
        );
    }


}
