<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
    public $timestamps = false;

    protected $fillable = ['product_id', 'color_id', 'size_id', 'count'];


}
