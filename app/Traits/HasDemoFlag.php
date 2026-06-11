<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * رکوردهای تستی/نمایشی (is_demo=true) به‌صورت پیش‌فرض همه‌جا (سایت و پنل) پنهان می‌شوند
 * و در محاسبات واقعی تأثیری ندارند. فقط وقتی ادمین «نمایش موارد تستی» را روشن کند
 * (session: gr_show_demo) دیده می‌شوند. چون تنها مسیرِ ادمین این session را تغییر می‌دهد،
 * کاربر عادی هرگز داده‌ی تستی نمی‌بیند.
 */
trait HasDemoFlag
{
    protected static function bootHasDemoFlag(): void
    {
        static::addGlobalScope('not_demo', function (Builder $query) {
            if (! session('gr_show_demo', false)) {
                $query->where($query->getModel()->getTable() . '.is_demo', false);
            }
        });
    }

    public function scopeWithDemo(Builder $query): Builder
    {
        return $query->withoutGlobalScope('not_demo');
    }

    public function scopeOnlyDemo(Builder $query): Builder
    {
        return $query->withoutGlobalScope('not_demo')->where($this->getTable() . '.is_demo', true);
    }
}
