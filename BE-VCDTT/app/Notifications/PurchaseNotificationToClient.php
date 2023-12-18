<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseNotificationToClient extends Notification implements ShouldQueue
{
    use Queueable;
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

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase_history)
    {
        //
        $this->purchase_history = $purchase_history;
        $this->purchase_status = $purchase_history->purchase_status;
        if ($purchase_history->gender == 1) {
            $this->name = 'ông ' . $purchase_history->name;
        } elseif ($purchase_history->gender == 2) {
            $this->name = 'bà ' . $purchase_history->name;
        } else{
            $this->name = 'ông/bà ' . $purchase_history->name;
        }
        $this->email = $purchase_history->email;
        $this->phone_number = $purchase_history->phone_number;
        $this->address = $purchase_history->address;
        $this->user_id = $purchase_history->user_id;
        $this->payment_status = $purchase_history->payment_status;
        $this->tour_child_price = $purchase_history->tour_child_price;
        $this->child_count = $purchase_history->child_count;
        $this->tour_adult_price = $purchase_history->tour_adult_price;
        $this->adult_count = $purchase_history->adult_count;
        $this->tour_name = $purchase_history->tour_name;
        $this->purchase_status = $purchase_history->purchase_status;

        if ($purchase_history->purchase_method == 1) {
            $this->purchase_method = 'Chuyển khoản online';
            $this->transaction_id = '';
        } else {
            $this->purchase_method = 'Thanh toán VNPAY';
            $this->transaction_id = $purchase_history->transaction_id;
        };
        $this->updated_at = $purchase_history->updated_at;
        $this->status = 'Bạn vừa đặt một đơn hàng mới, Vui lòng thanh toán để được đi tour';
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
            ->subject('Đơn hàng mới')
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
                'user_id' => $this->user_id,
                'purchase_status' => $this->purchase_status
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
