<?php

namespace App\Models;
use App\Casts\JalaliDate;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code', 'comment', 'discount', 'shipping_discount', 'mininum_purchase_total', 'maximum_discount', 'maximum_shipping_discount', 'start_date', 'end_date', 'remaining'];

    protected $casts = [
        'start_date' => JalaliDate::class,
        'end_date' => JalaliDate::class,
    ];



    //Cart
    //->total
    // discount = min((this->products()->sum('price') * discount) / 100, maximum_dicount)
    //->postPrice
    // city_rate * (this->products()->sum('weight') * shipping_discount) / 100
}
