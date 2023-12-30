<?php

namespace App\Notifications;

use App\Models\Order;
use Tzsk\Sms\Builder;
use Tzsk\Sms\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;

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
        return ['broadcast', 'database', SmsChannel::class];

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
        return (new Builder)
        ->send('سفارش شما با شناسه '. $this->order->id .'ثبت شد')
        ->to([$notifiable->mobile]);
    }
}
