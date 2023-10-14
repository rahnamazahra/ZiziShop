<?php

namespace App\Models;

use App\Casts\{status};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, MorphMany};

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public $timestamps = false;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'model');
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%");
    }

    protected static function generateUniqueSlug($id, $slug)
    {
        return "{$slug}-" . $id;
    }


}
