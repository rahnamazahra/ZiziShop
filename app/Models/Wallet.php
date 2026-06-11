<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance', 'last_charge', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public const FIRST_CHARGE = 200000;   // شارژ بار اول
    public const STEP         = 50000;    // افزایش هر بار

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * آیا اعتبار کیف پول منقضی شده؟ (۳ ماه بدون خرید)
     */
    public function isExpired(): bool
    {
        return ! $this->expires_at || $this->expires_at->isPast();
    }

    /**
     * موجودی قابل‌استفاده (اگر منقضی شده باشد صفر است).
     */
    public function usableBalance(): int
    {
        return $this->isExpired() ? 0 : (int) $this->balance;
    }

    /**
     * پاداش پس از هر خرید موفق:
     *  - بار اول یا پس از انقضا: ۲۰۰٬۰۰۰ (موجودی منقضی‌شده از بین می‌رود)
     *  - خریدهای بعدی ظرف ۳ ماه: هر بار ۵۰٬۰۰۰ بیشتر از دفعه‌ی قبل
     *  - اعتبار جدید تا ۳ ماه معتبر است
     */
    public function reward(): int
    {
        if ($this->isExpired()) {
            $this->balance = 0;
            $charge = self::FIRST_CHARGE;
        } else {
            $charge = $this->last_charge + self::STEP;
        }

        $this->balance += $charge;
        $this->last_charge = $charge;
        $this->expires_at = now()->addMonths(3);
        $this->save();

        return $charge;
    }

    /**
     * مبلغ شارژ بعدی (برای نمایش در بَج محصول).
     */
    public function nextReward(): int
    {
        return $this->isExpired() ? self::FIRST_CHARGE : $this->last_charge + self::STEP;
    }

    /**
     * خرج‌کردن اعتبار کیف پول هنگام خرید (حداکثر تا سقف موجودی قابل‌استفاده).
     * مقدار واقعی خرج‌شده را برمی‌گرداند.
     */
    public function spend(int $amount): int
    {
        $spend = min($this->usableBalance(), max(0, $amount));

        if ($spend > 0) {
            $this->balance -= $spend;
            $this->save();
        }

        return $spend;
    }
}
