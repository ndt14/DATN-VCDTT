<?php

//Thông báo hủy tour về bên admin

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CancelNotification extends Notification
{
    use Queueable;
    protected $payment_status;
    protected $purchaseHistoryID;
    protected $transaction_id;
    protected $tour_name;
    protected $name;
    protected $purchase_method;
    protected $paid;

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
        $this->paid = ($this->payment_status == 1) ? 'đã thanh toán' : 'chưa thanh toán';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Khách Hàng ' . $this->name . ' Đã Hủy Tour ' . $this->tour_name)
            ->greeting('Xin chào!')
            ->line('Khách hàng ' . $this->name . ' đã hủy tour ' . $this->tour_name . '(khách hàng ' . $this->paid . '). Vui lòng kiểm tra trong mục quản lý đơn hàng và liên hệ với khách hàng')
            ->line('Cảm ơn đã sử dụng dịch vụ của chúng tôi!')
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
            'purchase_history_id' => $this->purchaseHistoryID,
            'data' => 'Khách hàng ' . $this->name . ' đã hủy tour ' . $this->tour_name . '. Vui lòng kiểm tra trong mục quản lý đơn hàng',
            'transaction_id' => $this->transaction_id,
            'purchase_method' => $this->purchase_method
        ];
    }
}
