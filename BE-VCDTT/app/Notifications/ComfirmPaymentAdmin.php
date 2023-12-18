<?php
//Thông báo cho admin khi khách hàng xác nhận thanh toán

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ComfirmPaymentAdmin extends Notification implements ShouldQueue, ShouldBroadcast

{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
    protected $purchaseHistoryID;
    protected $transaction_id;
    protected $tour_name;
    protected $name;
    protected $purchase_method;
    protected $admin_id;
    protected $line;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchaseHistory, $admin_id)
    {
        //
        $this->purchaseHistoryID = $purchaseHistory->id;
        if ($purchaseHistory->purchase_method == 1) {
            $this->transaction_id = '';
        } else {
            $this->transaction_id = '.Mã hóa đơn: ' . $purchaseHistory->transaction_id;
        }
        $this->transaction_id = $purchaseHistory->transaction_id;
        $this->tour_name = $purchaseHistory->tour_name;
        $this->name = $purchaseHistory->name;
        $this->purchase_method = $purchaseHistory->purchase_method;
        $this->admin_id = $admin_id;
        $this->line = "Khách hàng " . $this->name . " vừa thanh toán đơn hàng của họ " . $this->transaction_id . " .Vui lòng kiểm tra tài khoản của bạn và phê duyệt cho khách hàng.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Khách hàng thanh toán tour ' . $this->tour_name)
            ->view('mail.admin', [
                'line' => $this->line
            ]);
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
        return new PrivateChannel('datn-vcdtt-development.' . $this->admin_id);
    }
}
