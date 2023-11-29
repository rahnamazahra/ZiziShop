<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count');
    }

    public function getCountAttribute()
    {
        return $this->products->sum('pivot.count');
    }
}
