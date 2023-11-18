<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use App\Models\PurchaseHistory;
use Illuminate\Console\Command;
use App\Notifications\SendMailToClientWhenPaid;

class AutoCancelBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-cancel-bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi mail cho khách khi không thanh toán sau 1 ngày';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $purchaseHistories = PurchaseHistory::where('updated_at', '=', Carbon::now()->subDays(1))->where('payment_status', '=', 1)->get();

        if ($purchaseHistories){
            foreach ($purchaseHistories as $purchaseHistory){
                $purchaseHistory->update([
                    'purchase_status' => 1,
                    'tour_status' => 5
                ]);

                return $purchaseHistory;

                $purchaseHistory->notify(new SendMailToClientWhenPaid($purchaseHistory));
            }
        }
    }
}
