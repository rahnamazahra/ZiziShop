<?php

namespace App\Models;

use App\Traits\HasSingleImage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\{HasMany, MorphMany};

class Category extends Model
{
    use SoftDeletes;
    use HasSingleImage;

    protected $fillable = ['name', 'slug', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }

    public function ensureUniqueSlug($request)
    {
        if ($request->slug) {
            return;
        }

        $slug = Str::slug($this->name, language: null);
        $similarSlugs  = static::where('slug', 'like', "$slug%")->get();

        if ($similarSlugs->isEmpty()) {
            return $this->slug = $slug;
        }

        $counter = 2;
        while ($similarSlugs->contains('slug', $slug. '-' . $counter)) {
            $counter++;
        }

        $this->slug = $slug . '-' . $counter;
    }

}
