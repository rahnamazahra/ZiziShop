<?php

namespace App\Notifications;

use App\Models\Order;
use Cryptommer\Smsir\Smsir;
use Illuminate\Bus\Queueable;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;


class NewProductOrderNotification extends Notification
{
    use Queueable;

    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [SmsChannel::class, 'broadcast', 'database'];

    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_careated_at' => $this->order->created_at,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'یک سفارش جدید دارید',
        ];

    }

    public function toSms($notifiable)
    {
        return 'کابر گرامی سفارش شما به شماره ' . $this->order->id . ' ثبت شد.';

    }


}
