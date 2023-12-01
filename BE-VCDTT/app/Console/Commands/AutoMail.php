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
        $purchaseHistoriesOutdated = PurchaseHistory::where('payment_status', '=', 1)->whereDate('created_at', '<=', Carbon::today()->subDays(1)->toDateString())->get();

        if ($purchaseHistoriesOutdated) {
            foreach ($purchaseHistoriesOutdated as $purchaseHistory) {
                $purchaseHistory->update([
                    'purchase_status' => 1,
                    'tour_status' => 5
                ]);

                if ($purchaseHistory->created_at == Carbon::today()->subDays(1)->toDateString()) {
                    $purchaseHistory->notify(new SendMailToClientWhenPaid($purchaseHistory));
                }
            }
        }

        //send mail when 1 week left untill start date
        $purchaseHistoryTourAnnounces = PurchaseHistory::where('payment_status', '=', '2')->where('purchase_status', '=', '3')->get();
        if ($purchaseHistoryTourAnnounces) {
            foreach ($purchaseHistoryTourAnnounces as $purchaseHistoryTourAnnounce) {
                $tour_start_time_string = $purchaseHistoryTourAnnounce->tour_start_time;
                $tour_start_time = Carbon::createFromFormat("Y-m-d H:i:s", $tour_start_time_string)->format('Y-m-d');

                $tour_end_time_string = $purchaseHistoryTourAnnounce->tour_end_time;
                $tour_end_time = Carbon::createFromFormat("Y-m-d H:i:s", $tour_end_time_string)->format('Y-m-d');

                //remind client about tour cancelling
                if ($tour_start_time == (Carbon::today()->addDays(7)->toDateString())) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('1'));
                } elseif ($tour_start_time == Carbon::now()->addDays(1)->toDateString()) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('2'));
                    $purchaseHistoryTourAnnounce->update([
                        'tour_status' => 4                                                   //turn off tour cancelling + mail
                    ]);
                } elseif ($tour_start_time == Carbon::now()->toDateString()) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('3'));
                    $purchaseHistoryTourAnnounce->update([
                        'tour_status' => 2                                                    //wish client best experiences
                    ]);
                } elseif ($tour_end_time == Carbon::now()->subDays(1)->toDateString()) {
                    $purchaseHistoryTourAnnounce->notify(new AnnouncementMailToClient('4'));
                    $purchaseHistoryTourAnnounce->update([
                        'tour_status' => 3                                                    //thank you mail
                    ]);
                }
            }
        }
    }
}
