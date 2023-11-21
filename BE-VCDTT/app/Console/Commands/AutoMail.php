<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use App\Models\PurchaseHistory;
use App\Notifications\AnnouncementMailToClient;
use Illuminate\Console\Command;
use App\Notifications\SendMailToClientWhenPaid;

class AutoMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto mail sending';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //send mail when bill is outdated
        $purchaseHistoriesOutdated = PurchaseHistory::where('payment_status', '=', 1)->where('updated_at', '=', Carbon::now()->subDays(1))->get();

        if ($purchaseHistoriesOutdated) {
            foreach ($purchaseHistoriesOutdated as $purchaseHistory) {
                $purchaseHistory->update([
                    'purchase_status' => 1,
                    'tour_status' => 5
                ]);

                return $purchaseHistory;

                $purchaseHistory->notify(new SendMailToClientWhenPaid($purchaseHistory));
            }
        }

        //send mail when 1 week left untill start date
        $purchaseHistoryTourAnnounces = PurchaseHistory::where('payment_status', '=', '2')->where('purchase_status', '=', '3');
        if ($purchaseHistoryTourAnnounces) {
            foreach ($purchaseHistoryTourAnnounces as $purchaseHistoryTourAnnounce) {
                if ($purchaseHistoryTourAnnounce->tour_start_time == (Carbon::now()->addDays(7))) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('1'));
                } elseif ($purchaseHistoryTourAnnounce->tour_start_time == (Carbon::now()->addDays(2))) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('2'));
                } elseif ($purchaseHistoryTourAnnounce->tour_start_time == (Carbon::now()->addDays(1))) {
                    $purchaseHistoryTourAnnounce->update([
                        'tour_status' => 4
                    ]);
                } elseif ($purchaseHistoryTourAnnounce->tour_start_time == (Carbon::now())) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('3'));
                    $purchaseHistoryTourAnnounce->update([
                        'tour_status' => 2
                    ]);
                } elseif ($purchaseHistoryTourAnnounce->tour_start_time == (Carbon::now()->subDays(1))) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('4'));
                    $purchaseHistoryTourAnnounce->update([
                        'tour_status' => 3
                    ]);
                }
            }
        }
    }
}
