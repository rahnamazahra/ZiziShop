<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code', 'comment', 'discount', 'post_discount', 'mininum_purchase_total', 'maximum_discount', 'maximum_post_discount', 'start_date', 'end_date'];


    //Cart
    //->total
    // discount = min(this->products()->sum('price') * discount / 100, maximum_dicount)
    //->postPrice
    // city_rate * this->products()->sum('weight') * post_discount / 100
}
