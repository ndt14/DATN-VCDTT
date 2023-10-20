<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseNotification extends Notification
{
    use Queueable;
    protected $transaction_id;
    protected $tour_name;
    protected $name;

    /**
     * Create a new notification instance.
     */
    public function __construct($transaction_id, $tour_name, $name)
    {
        //
        $this->transaction_id = $transaction_id;
        $this->tour_name = $tour_name;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
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
            'data' => 'Khách hàng ' . $this->name . ' đã đặt tour ' . $this->tour_name,
            'transaction_id' => $this->transaction_id,
        ];
    }
}
