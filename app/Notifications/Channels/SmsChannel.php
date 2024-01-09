<?php

namespace App\Notifications\Channels;

use App\Notifications\NewProductOrderNotification;
use Cryptommer\Smsir\Smsir;

class SmsChannel
{
    public function send($notifiable, NewProductOrderNotification $notification)
    {
        $message = $notification->toSms($notifiable);

        $line_number = 30007732907923;
        $send = smsir::Send();
        $send->bulk($message, [$notifiable->mobile], null, $line_number);
    }
}
