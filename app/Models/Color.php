<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    protected $fillable = ['name', 'code'];

    public $timestamps = false;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'stocks');
    }

    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%")
        ->orWhere('code', "%$search%");
    }

}
