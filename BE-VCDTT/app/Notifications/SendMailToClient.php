<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMailToClient extends Notification
{
    use Queueable;
    protected $purchase_status;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase_status)
    {
        //
        $this->purchase_status = $purchase_status;
        switch ($purchase_status) {
            case '0':
                $this->status = 'chưa thanh toán.';
                break;
            case '1':
                $this->status = 'đang đợi xác nhận.';
                break;
            case '2':
                $this->status = 'đã xác nhận đơn hàng.';
                break;
            case '3':
                $this->status = 'sắp tới ngày đi tour.';
                break;
            case '4':
                $this->status = 'tour đang diễn ra.';
                break;
            case '5':
                $this->status = 'tour đã kết thúc.';
                break;
            case '6':
                $this->status = 'admin đã hủy tour.';
                break;
            case '7':
                $this->status = 'khách hàng đã hủy đơn hàng.';
                break;
            case '8':
                $this->status = 'tự động hủy do quá hạn thanh toán.';
                break;
            case '9':
                $this->status = 'đã hoàn tiền.';
                break;
            case '10':
                $this->status = 'đã đánh giá.';
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
        return (new MailMessage)
            ->greeting('Xin chào!')
            ->line('Đơn hàng của bạn vừa được cập nhật trạng thái: '. $this->status .' Vui lòng bấm vào đường link bên dưới để kiểm tra')
            ->action('Kiểm tra đơn hàng của bạn ', url('/')) //link đến trang đơn hàng của khách
            ->line('Cảm ơn đã sử dụng dịch vụ của chúng tôi!');
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
