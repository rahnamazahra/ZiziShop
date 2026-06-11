<?php

namespace App\Notifications\Channels;

use App\Notifications\NewProductOrderNotification;
use Cryptommer\Smsir\Smsir;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    public function send($notifiable, NewProductOrderNotification $notification)
    {
        if (empty($notifiable->mobile)) {
            return;
        }

        try {
            $message    = $notification->toSms($notifiable);
            $lineNumber = config('smsir.line-number') ?: 30007732907923;
            Smsir::Send()->bulk($message, [$notifiable->mobile], null, $lineNumber);
        } catch (\Throwable $e) {
            // نبود تنظیمات/خطای درگاه پیامک نباید جریان سفارش را بشکند
            Log::warning('SmsChannel failed: ' . $e->getMessage());
        }
    }
}
