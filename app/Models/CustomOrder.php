<?php

namespace App\Models;

use App\Enums\CustomOrderStatusEnum;
use App\Traits\HasDemoFlag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomOrder extends Model
{
    use HasDemoFlag;

    protected $fillable = [
        'user_id', 'contact_name', 'product_id', 'description', 'quantity', 'contact_mobile',
        'status', 'unit_price', 'admin_note', 'gateway_ref', 'paid_at', 'order_id', 'is_demo',
    ];

    protected $casts = [
        'status'  => CustomOrderStatusEnum::class,
        'paid_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * مبلغ کل قابل پرداخت (قیمت واحد × تعداد)
     */
    public function getTotalAttribute(): int
    {
        return (int) $this->unit_price * (int) $this->quantity;
    }

    public function isPending(): bool
    {
        return $this->status === CustomOrderStatusEnum::Pending;
    }

    public function isApproved(): bool
    {
        return $this->status === CustomOrderStatusEnum::Approved;
    }

    public function isPaid(): bool
    {
        return $this->status === CustomOrderStatusEnum::Paid;
    }

    public function isPayable(): bool
    {
        return $this->status === CustomOrderStatusEnum::Approved && $this->unit_price > 0;
    }
}
