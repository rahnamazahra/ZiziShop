<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminOrderNotification;

class SendAdminNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        $admin = User::find(1);

        if ($admin) {
            $admin->notify(new AdminOrderNotification($order));
        }

    }

}
