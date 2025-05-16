<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = ['address', 'postal_code', 'city_id', 'postal_code', 'mobile', 'receiver', 'city_id', 'user_id'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
