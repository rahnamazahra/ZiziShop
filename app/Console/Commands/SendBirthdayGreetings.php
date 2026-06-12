<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Voucher;
use Cryptommer\Smsir\Smsir;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

class SendBirthdayGreetings extends Command
{
    protected $signature = 'birthdays:greet';

    protected $description = 'ارسال پیامک تبریک تولد و ساخت کوپن ۲۰۰هزارتومانی ۱۰روزه برای متولدین امروز';

    /**
     * مبلغ هدیه‌ی تولد (تومان) و مدت اعتبار (روز)
     */
    public const GIFT_AMOUNT = 200000;
    public const VALID_DAYS  = 10;

    /**
     * تاریخ تولد باید حداقل این تعداد روز قبل از روز تولد ثبت شده باشد
     * (جلوگیری از ثبت تولدِ «همین فردا» فقط برای گرفتن فوری هدیه)
     */
    public const MIN_REGISTRATION_DAYS = 30;

    public function handle(): int
    {
        $users = User::birthdayToday()
            ->whereNotNull('mobile')
            // null = کاربران قدیمی که قبل از این قانون تولدشان را ثبت کرده‌اند
            ->where(function ($q) {
                $q->whereNull('birthday_set_at')
                  ->orWhere('birthday_set_at', '<=', now()->subDays(self::MIN_REGISTRATION_DAYS));
            })
            ->get();
        $sent = 0;

        foreach ($users as $user) {
            $code = 'BDAY-' . $user->id . '-' . now()->year;

            // جلوگیری از تکرار در همان سال
            if (Voucher::where('code', $code)->exists()) {
                continue;
            }

            $voucher = Voucher::create([
                'user_id'          => $user->id,
                'code'             => $code,
                'comment'          => 'هدیه تولد',
                'discount_percent' => 0,
                'amount'           => self::GIFT_AMOUNT,
                'remaining'        => 1,
                // کستِ JalaliDate ورودی جلالی می‌خواهد و خودش به میلادی ذخیره می‌کند
                'start_date'       => Jalalian::fromCarbon(now())->format('Y/m/d'),
                'end_date'         => Jalalian::fromCarbon(now()->addDays(self::VALID_DAYS))->format('Y/m/d'),
            ]);

            // ارسال پیامک و ثبت وضعیت ارسال روی کوپن
            if ($this->sendSms($user, $code)) {
                $voucher->update(['sms_sent' => true, 'sms_sent_at' => now()]);
            }

            $sent++;
        }

        $this->info("تبریک تولد برای {$sent} کاربر ارسال شد.");

        return self::SUCCESS;
    }

    protected function sendSms(User $user, string $code): bool
    {
        try {
            $message = sprintf(
                'تولدت مبارک %s عزیز! 🎉 هدیه‌ی گالری رهنما: کد تخفیف %s به ارزش %s تومان، معتبر تا %d روز.',
                $user->name,
                $code,
                number_format(self::GIFT_AMOUNT),
                self::VALID_DAYS
            );
            $lineNumber = config('smsir.line-number') ?: 30007732907923;
            Smsir::Send()->bulk($message, [$user->mobile], null, $lineNumber);

            return true;
        } catch (\Throwable $e) {
            Log::warning('Birthday SMS failed for user ' . $user->id . ': ' . $e->getMessage());

            return false;
        }
    }
}
