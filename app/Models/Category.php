<?php

namespace App\Models;

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

    public function ensureUniqueSlug($request)
    {
        if (!$request->slug) {

            $counter = 1;

            $slug = Str::slug($this->name, language: null);

            $collection  = static::where('slug', 'like', "$slug%")->get();

            while ($collection->contains('slug', $slug. '-' . $counter)) {

                $counter++;
            }

            $this->slug = $slug . '-' . $counter;
        }
        else{

            $this->slug = $request->slug;
        }
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::disk('public')->url($this->image->path),
        );
    }

    public function uploadImage($request)
    {

        if($request->hasFile('image'))
        {

            if($this->image) {

                Storage::disc('public')->delete($this->image_url);
            }


            $image_url = $request->file('image')->store('images/category', 'public');

            $this->image()->create([
                'path' => $image_url,
            ]);

        }

    }


}
