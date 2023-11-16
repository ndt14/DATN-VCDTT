<?php
//Thông báo cho client khi admin chuyển trạng thái

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendMailToClientWhenPaid extends Notification implements ShouldQueue
{
    use Queueable;
    protected $purchase_status;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase_history)
    {
        //
        $this->purchase_status = $purchase_history->purchase_status;
        switch ($purchase_history->purchase_status) {
            case '2':
                $this->status = 'Bạn vừa thanh toán đơn hàng của bạn! Vui lòng chờ xác nhận đơn hàng.';
                break;
            case '3':
                $this->status = 'Đơn hàng của bạn đã được phê duyệt. Giờ đây bạn đã có thể đi tour mà bạn đã đặt. Chúc quý khách thượng lộ bình an';
                break;
            case '5':
                $this->status = "Yêu cầu hủy tour " . $purchase_history->tour_name . " của bạn đã được phê duyệt. Vui lòng liên hệ với CSKH để được hoàn tiền";
                break;
            case '6':
                $this->status = "Chúng tôi đã hoàn tiền cho bạn. Vui lòng kiểm tra tài khoản của bạn. Nếu có gì thắc mắc, vui lòng liên hệ CSKH để được tư vấn";
                break;
            case '7':
                $this->status = "Bạn đã chuyển thiếu tiền cho chúng tôi, vui lòng liên hệ cho CSKH để được giúp đỡ";
                break;
            case '8':
                $this->status = "Bạn đã chuyển thừa tiền cho chúng tôi, vui lòng liên hệ cho CSKH để được giúp đỡ";
                break;
            default:
                break;
        }
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
        if ($this->purchase_status == 2 || $this->purchase_status == 5 || $this->purchase_status == 6 || $this->purchase_status == 7 || $this->purchase_status == 8) {
            return (new MailMessage)
                ->greeting('Xin chào!')
                ->line($this->status)
                ->action('Kiểm tra đơn hàng của bạn ', url('http://datn-vcdtt.test:5173/user/tours')) //link đến trang đơn hàng của khách
                ->line('Cảm ơn đã sử dụng dịch vụ của chúng tôi!')
                ->salutation(new HtmlString('Trân trọng, <br> VCDTT'));
        } else {
            return (new MailMessage);
        }
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
