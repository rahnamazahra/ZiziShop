<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = ['body', 'postal_code', 'national_code', 'city_id', 'mobile', 'receiver', 'user_id'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
