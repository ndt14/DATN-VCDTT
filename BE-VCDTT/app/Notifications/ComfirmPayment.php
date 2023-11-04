<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use PhpCsFixer\Cache\Signature;

class ComfirmPayment extends Notification
{
    use Queueable;
    protected $purchaseHistoryID;
    protected $transaction_id;
    protected $tour_name;
    protected $name;
    protected $purchase_method;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchaseHistory)
    {
        //
        $this->purchaseHistoryID = $purchaseHistory->id;
        $this->transaction_id = $purchaseHistory->transaction_id;
        $this->tour_name = $purchaseHistory->tour_name;
        $this->name = $purchaseHistory->name;
        $this->purchase_method = $purchaseHistory->purchase_method;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Xin chào Admin!')
                    ->line('Khách hàng ' . $this->name . ' vừa chuyển tiền! Vui lòng kiểm tra tài khoản của bạn');

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
            'purchase_history_id' => $this->purchaseHistoryID,
            'data' => 'Khách hàng ' . $this->name . ' đã thanh toán tour ' . $this->tour_name,
            'transaction_id' => $this->transaction_id,
            'purchase_method' => $this->purchase_method
        ];
    }
}