<?php
//Thông báo đổi mật khẩu luồng quên mật khẩu

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordRequest extends Notification implements ShouldQueue
{
    use Queueable;
    protected $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //Đây chỉ là link tạm thời để test chức năng. Sau này sẽ bảo ae fe sửa link để gửi trong mail cho khách
        //link dẫn đến trang đổi password
        $url = 'http://datn-vcdtt.test:5173/reset-password/' . $this->token;

        return (new MailMessage)
            ->line('Bạn nhận được mail này vì có một yêu cầu đổi mật khẩu cho tài khoản của bạn')
            ->action('Đổi mật khẩu', $url)
            ->line('Nếu không phải là bạn, vui lòng bỏ qua email này');
    }
}
