<?php

namespace App\Enums;

enum CustomOrderStatusEnum: string
{
    case Pending  = 'pending';   // در انتظار بررسی ادمین
    case Approved = 'approved';  // تأیید و قیمت‌گذاری شد، در انتظار پرداخت کاربر
    case Rejected = 'rejected';  // رد شد
    case Paid     = 'paid';      // پرداخت انجام شد، در حال تولید/پردازش

    public function label(): string
    {
        return match ($this) {
            self::Pending  => 'در انتظار بررسی',
            self::Approved => 'تأیید شد - در انتظار پرداخت',
            self::Rejected => 'رد شد',
            self::Paid     => 'پرداخت شد',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending  => 'badge-light-warning',
            self::Approved => 'badge-light-primary',
            self::Rejected => 'badge-light-danger',
            self::Paid     => 'badge-light-success',
        };
    }
}
