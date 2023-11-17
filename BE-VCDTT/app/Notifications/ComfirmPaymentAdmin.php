<?php
//Thông báo cho admin khi khách hàng xác nhận thanh toán

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Messages\MailMessage;

class ComfirmPaymentAdmin extends Notification implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
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
                    ->subject('Khách hàng thanh toán đơn hàng')
                    ->greeting('Xin chào Admin!')
                    ->line('Khách hàng ' . $this->name . ' vừa thanh toán đơn hàng của họ. Mã hóa đơn: ' . $this->transaction_id . ' .Vui lòng kiểm tra tài khoản của bạn và phê duyệt cho khách hàng')
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
            'data' => 'Khách hàng ' . $this->name . ' đã thanh toán tour ' . $this->tour_name . ' .Vui lòng kiểm tra và phê duyệt!',
            'transaction_id' => $this->transaction_id,
            'purchase_method' => $this->purchase_method
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('datn-vcdtt-development');
    }
}
