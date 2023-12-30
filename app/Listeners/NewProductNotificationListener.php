<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NewProductOrderNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProductOrderNotification;

class NewProductNotificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(){

    }

    public function handle(NewProductOrderNotificationEvent $event)
    {
        $order = $event->order;

        $admin = User::find(1);

        if ($admin) {
            $admin->notify(new NewProductOrderNotification($order));
        }

    }



}
