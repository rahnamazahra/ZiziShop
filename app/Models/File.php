<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['file_name', 'path', 'size', 'mime_type', 'fileable_type','fileable_id'];

    public $timestamps = false;

    public function fileable_type()
    {
        return $this->morphTo('fileable');
    }

    public function uploadImage($image): void
    {
    }

    public function deleteImage($image)
    {
    }
}
