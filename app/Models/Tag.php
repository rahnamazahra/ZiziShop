<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function Products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public static function findOrCreateFromRequest($tags)
    {
        $tags = explode(',', $tags);

        return collect($tags)
            ->map(function ($item) {
                return trim($item);
            })->map(function ($item) {
                return Tag::firstOrCreate([
                    'name' => $item,
                ])->id;
            });

    }
}
