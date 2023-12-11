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
    protected $name;
    protected $email;
    protected $phone_number;
    protected $address;
    protected $purchase_method;
    protected $transaction_id;
    protected $updated_at;
    protected $table;
    protected $user_id;
    protected $payment_status;
    protected $tour_child_price;
    protected $child_count;
    protected $tour_adult_price;
    protected $adult_count;
    protected $tour_name;
    protected $purchase_history_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase_history)
    {
        //
        $this->purchase_history = $purchase_history;
        $this->purchase_status = $purchase_history->purchase_status;
        $this->name = $purchase_history->name;
        $this->email = $purchase_history->email;
        $this->phone_number = $purchase_history->phone_number;
        $this->address = $purchase_history->address;
        $this->user_id = $purchase_history->user_id;
        $this->tour_child_price = $purchase_history->tour_child_price;
        $this->child_count = $purchase_history->child_count;
        $this->tour_adult_price = $purchase_history->tour_adult_price;
        $this->adult_count = $purchase_history->adult_count;
        $this->tour_name = $purchase_history->tour_name;
        $this->purchase_history_id = $purchase_history->id;

        $this->payment_status = $purchase_history->payment_status;

        if ($purchase_history->purchase_method == 1) {
            $this->purchase_method = 'Chuyển khoản trực tiếp';
            $this->transaction_id = '';
        } else {
            $this->purchase_method = 'Thanh toán VNPAY';
            $this->transaction_id = $purchase_history->transaction_id;
        };
        $this->updated_at = $purchase_history->updated_at;
        switch ($this->purchase_history->purchase_status) {
            case '1':
                $this->status = 'Đơn hàng (tour ' . $purchase_history->tour_name . ') của bạn mới bị hủy do hết hạn thanh toán';
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
                $this->status = "Chúng tôi đã hoàn tiền tour ". $purchase_history->tour_name . " cho bạn. Vui lòng kiểm tra tài khoản của bạn. Nếu có gì thắc mắc, vui lòng liên hệ CSKH để được tư vấn";
                break;
            case '7':
                $this->status = "Bạn đã chuyển thiếu tiền cho tour " . $purchase_history->tour_name . ", vui lòng liên hệ cho CSKH để được giúp đỡ";
                break;
            case '8':
                $this->status = "Bạn đã chuyển thừa tiền cho tour " . $purchase_history->tour_name . ", vui lòng liên hệ cho CSKH để được giúp đỡ";
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
        if ($this->purchase_status == 3 || $this->purchase_status == 2) {
            return (new MailMessage)
                ->subject('Cập nhật trạng thái đơn hàng')
                ->view('mail.paid', [
                    'tour_name' => $this->tour_name,
                    'status' => $this->status,
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone_number' => $this->phone_number,
                    'address' => $this->address,
                    'purchase_method' => $this->purchase_method,
                    'transaction_id' => $this->transaction_id,
                    'updated_at' => $this->updated_at,
                    'payment_status' => $this->payment_status,
                    'tour_child_price' => $this->tour_child_price,
                    'child_count' => $this->child_count,
                    'tour_adult_price' => $this->tour_adult_price,
                    'adult_count' => $this->adult_count,
                    'purchase_status' => $this->purchase_status,
                    'purchase_history_id' => $this->purchase_history_id,
                    'user_id' => $this->user_id
                ]);
        } else {
            return (new MailMessage)
                ->subject('Cập nhật trạng thái đơn hàng')
                ->view('mail.client', [
                    'status' => $this->status,
                    'user_id' => $this->user_id,
                    'name' => $this->name
                ]);
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
