<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NewProductOrderNotificationEvent;
use App\Services\SmsService;
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

        if ($order->user && $order->user->mobile) {
            (new SmsService)->orderPlaced($order->user->mobile, $order->id);
        }
    }
}
