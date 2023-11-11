<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

trait HasSingleImage
{
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk('public')->url($this->image->path),
        );
    }

    public function uploadImage($request)
    {
        if (! $request->hasFile('image')) {
            return;
        }

        if ($this->image) {
            $this->image->delete();
        }

        $dir = str(static::class)->afterLast('\\')->lower();
        $path = $request->file('image')->store('images/' . $dir, 'public');

        $this->image()->create([
            'path' => $path,
        ]);
    }
}
