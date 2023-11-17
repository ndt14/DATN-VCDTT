<?php
//Thông báo cho client khi admin chuyển trạng thái

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

class SendMailToClientWhenPaid extends Notification implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
    protected $purchase_status;
    protected $status;
    protected $tour_id;
    protected $purchase_history;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase_history)
    {
        //
        $this->purchase_history = $purchase_history;
        $this->purchase_status = $purchase_history->purchase_status;
        $this->tour_id = $purchase_history->tour_id;
        switch ($purchase_history->purchase_status) {
            case '1':
                $this->status = 'Đơn hàng của bạn mới bị hủy do hết hạn thanh toán';
                break;
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
        $url = url('http://datn-vcdtt.test:5173/tours/' . $this->tour_id);

        if ($this->purchase_history->user_id == null) {
            return (new MailMessage)
                ->subject('Cập nhật trạng thái đơn hàng')
                ->greeting('Xin chào!')
                ->line($this->status)
                ->line('Cảm ơn đã sử dụng dịch vụ của chúng tôi!')
                ->salutation(new HtmlString('Trân trọng, <br> VCDTT'));
        } elseif ($this->purchase_status == 3) {
            return (new MailMessage)
                ->subject('Cập nhật trạng thái đơn hàng')
                ->greeting('Xin chào!')
                ->line($this->status)
                ->line('Cảm ơn đã sử dụng dịch vụ của chúng tôi!')
                ->salutation(new HtmlString('Trân trọng, <br> VCDTT'));

        } else {
            return (new MailMessage)
                ->subject('Cập nhật trạng thái đơn hàng')
                ->greeting('Xin chào!')
                ->line($this->status)
                ->action('Kiểm tra đơn hàng của bạn ', url('http://datn-vcdtt.test:5173/user/tours')) //link đến trang đơn hàng của khách
                ->line('Cảm ơn đã sử dụng dịch vụ của chúng tôi!')
                ->salutation(new HtmlString('Trân trọng, <br> VCDTT'));
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
