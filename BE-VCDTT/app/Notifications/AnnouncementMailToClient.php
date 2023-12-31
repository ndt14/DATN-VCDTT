<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AnnouncementMailToClient extends Notification implements ShouldQueue
{
    use Queueable;
    protected $mail_type;
    protected $subject;
    protected $line;
    protected $warning;
    protected $name;

    /**
     * Create a new notification instance.
     */
    public function __construct($mail_type,$purchaseHistory)
    {
        //
        $this->name = $purchaseHistory->name;
        $this->mail_type = $mail_type;
        switch ($mail_type) {
            case '1':
                $this->subject = "Nhắc lịch đi tour";
                $this->line = "Chỉ còn 1 tuần nữa là đến ngày đi tour " .$purchaseHistory->tour_name. ". Chúc quý khách chuẩn bị thật tốt cho chuyến đi lần này!";
                $this->warning = "Lưu ý, quý khách chỉ được hủy tour trước 1 ngày đi tour. Nếu có bất kỳ thắc mắc nào, xin vui lòng liên hệ CSKH để được tư vấn";
                break;
            case '2':
                $this->subject = "Nhắc lịch đi tour";
                $this->line = "Chỉ còn 1 ngày nữa là đến ngày đi tour " .$purchaseHistory->tour_name. ". Chúc quý khách một chuyến đi thượng lộ bình an!";
                $this->warning = "Lưu ý, quý khách đã hết hạn hủy tour. Nếu có bất kỳ thắc mắc nào, xin vui lòng liên hệ CSKH để được tư vấn";
                break;
            case '3':
                $this->subject = "Nhắc lịch đi tour";
                $this->line = "Hôm nay là ngày tour " .$purchaseHistory->tour_name. " xuất phát. Chúc quý khách một chuyến đi thượng lộ bình an!";
                $this->warning = "";
                break;
            case '4':
                $this->subject = "Thư cảm ơn";
                $this->line = "Cảm ơn quý khách đã đặt tour trên nền tảng của chúng tôi. Hẹn gặp lại quý khách trong một ngày không xa!";
                $this->warning = "";
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
            ->subject($this->subject)
            ->view('mail.auto', [
                'name' => $this->name,
                'line' => $this->line,
                'warning' => $this->warning
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
