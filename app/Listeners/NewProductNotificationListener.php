<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NewProductOrderNotificationEvent;
use Cryptommer\Smsir\Smsir;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProductOrderNotification;

class NewProductNotificationListener
{
    public function handle(NewProductOrderNotificationEvent $event)
    {
        $order = $event->order;

        // اعلان به همه‌ی ادمین‌ها (نوتیفیکیشن زنگوله + پیامک)
        $admins = User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->get();
        Notification::send($admins, new NewProductOrderNotification($order));

        // پیامک به مشتری
        if ($order->user && $order->user->mobile) {
            try {
                $message    = 'سفارش شما به شماره ' . $order->id . ' با موفقیت ثبت شد. گالری رهنما';
                $lineNumber = config('smsir.line-number') ?: 30007732907923;
                Smsir::Send()->bulk($message, [$order->user->mobile], null, $lineNumber);
            } catch (\Throwable $e) {
                Log::warning('Customer order SMS failed: ' . $e->getMessage());
            }
        }
    }
}
