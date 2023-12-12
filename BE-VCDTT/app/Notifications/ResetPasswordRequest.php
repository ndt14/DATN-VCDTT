<?php
//Thông báo đổi mật khẩu luồng quên mật khẩu

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

class ResetPasswordRequest extends Notification implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
    protected $token;
    protected $url;
    protected $line;

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
        $this->url = 'https://vcdtt.online/reset-password/' . $this->token;
        $this->line = 'Bạn nhận được mail này vì có một yêu cầu đổi mật khẩu cho tài khoản của bạn. Nếu không phải là bạn, vui lòng bỏ qua email này!';

        return (new MailMessage)
            ->subject('Yêu cầu đổi mật khẩu')
            ->view('mail.reset-password', [
                'url' => $this->url,
                'line' => $this->line
            ]);
    }
}
