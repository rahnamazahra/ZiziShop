<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewProductOrderNotificationEvent;
use App\Notifications\NewProductOrderNotification;

class SendUserSMS
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    /**
     * Handle the event.
     */
    public function handle(NewProductOrderNotificationEvent $event)
    {
        $order = $event->order;

        if (auth()->check()) {
            $user = User::find(auth()->user()->id);
            $user->notify(new NewProductOrderNotification($order));
        }

    }
}
