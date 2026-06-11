<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['path', 'type', 'sort_order', 'imageable_type', 'imageable_id'];

    public $timestamps = false;

    public static function booted()
    {
        static::deleted(function ($image) {
            Storage::disk('public')->delete($image->path);
        });
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
