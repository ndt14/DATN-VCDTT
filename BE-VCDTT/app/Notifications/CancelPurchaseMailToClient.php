<?php
//Thông báo cho user khi user yêu cầu hủy tour khi đã thanh toán

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

class CancelPurchaseMailToClient extends Notification implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
    protected $tour_name;
    protected $purchase_status_noti;
    protected $status;
    protected $name;
    protected $user_id;
    protected $gender;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchaseHistory)
    {
        //
        $this->user_id = $purchaseHistory->id;
        $this->name = $purchaseHistory->name;
        if ($purchaseHistory->gender == 1) {
            $this->gender = 'ông ';
        } elseif ($purchaseHistory->gender == 2) {
            $this->gender = 'bà ';
        } else{
            $this->gender = 'ông/bà ';
        }
        $this->tour_name = $purchaseHistory->tour_name;
        if ($purchaseHistory->payment_status == 1) {
            $this->purchase_status_noti =  '. Vui lòng liên hệ với CSKH của chúng tôi để được hoàn tiền';
        } elseif ($purchaseHistory->purchase_status == 2) {
            $this->purchase_status_noti =  '';
        }
        $this->status = 'Bạn vừa hủy tour ' . $this->tour_name . $this->purchase_status_noti . ' .Nếu không phải bạn, hãy liên hệ với chúng tôi để được giúp đỡ';
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
            ->subject('Cập nhật trạng thái đơn hàng')
            ->view('mail.client', [
                'status' => $this->status,
                'user_id' => $this->user_id,
                'name' => $this->name,
                'gender' => $this->gender
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
        ];
    }
}
