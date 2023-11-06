<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CancelPurchaseNotification extends Notification
{
    use Queueable;
    protected $tour_name;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchaseHistory)
    {
        //
        $this->tour_name = $purchaseHistory->tour_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Xin chào!')
            ->line('Bạn vừa hủy tour ' . $this->tour_name . '. Vui lòng liên hệ với CSKH của chúng tôi để được hoàn tiền')
            ->line('Nếu không phải bạn, hãy liên hệ với chúng tôi để được giúp đỡ')
            ->salutation(new HtmlString('Trân trọng, <br> VCDTT'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
