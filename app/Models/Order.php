<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'shipping_fee',
        'total',
        'address_text'
    ];

    protected $casts = [
        'order-status' =>OrderStatusEnum::class
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('count', 'price');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }


}
