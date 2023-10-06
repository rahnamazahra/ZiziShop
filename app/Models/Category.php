<?php

namespace App\Models;

use App\Casts\{status};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, MorphMany};

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public $timestamps = false;

    public function products():HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function files():MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function uploadImage($image):void
    {
            if ($image)
            {
                $storage_dir = '/category';
                uploadFile($storage_dir, ['image' => $image], ['fileable_id' => $this->id, 'fileable_type' => Category::class]);
            }
    }

    public function deleteImage($image)
    {
        if ($image) {

            $file = $this->files->get();

            if ($file) {
                purge($file->path);
                $file->delete();
            }
        }
    }
}
