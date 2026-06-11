<?php

namespace App\Models;

use App\Enums\ExpenseTypeEnum;
use App\Traits\HasDemoFlag;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasDemoFlag;

    protected $fillable = [
        'title', 'type', 'amount', 'spent_at', 'recurrence', 'description',
        'material_name', 'product_code', 'quantity', 'weight', 'is_demo',
    ];

    protected $casts = [
        'type'     => ExpenseTypeEnum::class,
        'spent_at' => 'date',
        'is_demo'  => 'boolean',
    ];

    public const RECURRENCES = [
        'once'      => 'یک‌باره',
        'monthly'   => 'ماهانه',
        'quarterly' => 'سه‌ماهه',
        'biannual'  => 'شش‌ماهه',
        'yearly'    => 'سالانه',
    ];

    /**
     * معادل ماهانه‌ی هزینه (برای تخمین پس‌انداز لازم).
     */
    public function monthlyEquivalent(): float
    {
        return match ($this->recurrence) {
            'monthly'   => $this->amount,
            'quarterly' => $this->amount / 3,
            'biannual'  => $this->amount / 6,
            'yearly'    => $this->amount / 12,
            default     => 0, // یک‌باره در پس‌انداز دوره‌ای لحاظ نمی‌شود
        };
    }
}
