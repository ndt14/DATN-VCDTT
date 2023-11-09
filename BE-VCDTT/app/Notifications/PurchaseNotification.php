<?php
//Thông báo mua hàng gửi cho bên admin

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PurchaseNotification extends Notification
{
    use Queueable;

    protected $payment_status;
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
        $this->payment_status = $purchaseHistory->payment_status;
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
    public function toMail(object $notifiable)
    {
        return (new MailMessage)
            ->greeting('Xin chào!')
            ->line('Bạn có đơn đặt hàng mới từ khách hàng ' . $this->name)
            ->line('Vui lòng kiểm tra trong đơn hàng của bạn')
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
            'purchase_history_id' => $this->purchaseHistoryID,
            'data' => 'Khách hàng ' . $this->name . ' đã đặt tour ' . $this->tour_name,
            'transaction_id' => $this->transaction_id,
            'purchase_method' => $this->purchase_method
        ];
    }
}
