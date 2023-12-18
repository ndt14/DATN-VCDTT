<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\PurchaseHistory;
use Illuminate\Console\Command;

class AutoDeleteOutdatedBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-delete-outdated-bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $purchaseHistoryAutoOutdate = PurchaseHistory::where('purchase_status', '=', 1)
            ->whereDate('updated_at', '>=', Carbon::now()->subDays(7)->toDateString())
            ->where('deleted_at', '=', null)->get();

        if ($purchaseHistoryAutoOutdate) {
            foreach ($purchaseHistoryAutoOutdate as $purchaseHistory) {
                $purchaseHistory->delete();
            }
        }

        $purchaseHistoryOutdate = PurchaseHistory::where('purchase_status', '=', 6)
            ->whereDate('updated_at', '>=', Carbon::now()->subDays(7)->toDateString())
            ->where('deleted_at', '=', null)->get();

        if ($purchaseHistoryOutdate) {
            foreach ($purchaseHistoryOutdate as $purchaseHistory) {
                $purchaseHistory->delete();
            }
        }
    }
}
