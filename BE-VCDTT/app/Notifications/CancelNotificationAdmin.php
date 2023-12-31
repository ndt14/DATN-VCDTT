<?php

//Thông báo hủy tour về bên admin

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

class CancelNotificationAdmin extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable, Dispatchable, InteractsWithSockets, SerializesModels;
    protected $payment_status;
    protected $purchaseHistoryID;
    protected $transaction_id;
    protected $tour_name;
    protected $name;
    protected $purchase_method;
    protected $paid;
    protected $refund;
    protected $admin_id;
    protected $line;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchaseHistory, $admin_id)
    {
        //
        $this->purchaseHistoryID = $purchaseHistory->id;
        $this->transaction_id = $purchaseHistory->transaction_id;
        $this->tour_name = $purchaseHistory->tour_name;
        $this->name = $purchaseHistory->name;
        $this->payment_status = $purchaseHistory->payment_status;
        $this->purchase_method = $purchaseHistory->purchase_method;
        $this->paid = ($this->payment_status == 2) ? ' sau khi đã thanh toán. ' : '.';
        $this->refund = ($this->payment_status == 2) ? ' và liên hệ với khách hàng.' : '.';
        $this->admin_id = $admin_id;
        $this->line = 'Khách hàng ' . $this->name . ' đã hủy tour ' . $this->tour_name . $this->paid . 'Vui lòng kiểm tra trong mục quản lý đơn hàng và liên hệ với khách hàng';
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
            ->subject('Khách Hàng ' . $this->name . ' đã hủy tour ' . $this->tour_name)
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
            'data' => 'Khách hàng ' . $this->name . ' đã hủy tour ' . $this->tour_name . '. Vui lòng kiểm tra trong mục quản lý đơn hàng ' . $this->refund,
            'transaction_id' => $this->transaction_id,
            'purchase_method' => $this->purchase_method
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('datn-vcdtt-development.' . $this->admin_id);
    }
}
