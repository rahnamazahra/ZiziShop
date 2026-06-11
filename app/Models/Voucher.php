<?php

namespace App\Models;
use App\Casts\JalaliDate;
use App\Traits\HasDemoFlag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    use HasDemoFlag;

    protected $fillable = ['user_id', 'product_id', 'code', 'comment', 'discount', 'discount_percent', 'amount', 'shipping_discount', 'mininum_purchase_total', 'maximum_discount', 'maximum_shipping_discount', 'start_date', 'end_date', 'remaining', 'sms_sent', 'sms_sent_at', 'is_demo'];

    protected $casts = [
        'start_date'  => JalaliDate::class,
        'end_date'    => JalaliDate::class,
        'sms_sent'    => 'boolean',
        'sms_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * تخفیف این کوپن برای یک محصول مشخص (برای نمایش قیمت تخفیف‌خورده در سایت).
     * اگر کوپن مبلغی باشد مقدار ثابت، در غیر این صورت درصدِ قیمت.
     */
    public function discountFor(Product $product): int
    {
        if ($this->amount) {
            return min((int) $this->amount, (int) $product->price);
        }

        return (int) round($product->price * $this->discount_percent / 100);
    }
}
