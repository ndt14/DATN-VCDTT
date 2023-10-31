<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    public function totalEarn(Request $request){
        //
        //today
        //this week
        //this month
        //this year
        //over all
        //views how many?
        //passengers how many?
        //sold how many?
        $purchaseHistory = PurchaseHistory::where('purchase_status',5)->orWhere('purchase_status',10)->get();

        $total=[];
        foreach($purchaseHistory as $purchaseHistory){
            $final['price'] = $purchaseHistory->tour_child_price * $purchaseHistory->child_count + $purchaseHistory->tour_adult_price * $purchaseHistory->adult_count;
            $final['price'] = $final['price']- ($final['price']/ 100 * ($purchaseHistory->coupon_percentage ?? 0 + $purchaseHistory->tour_sale_percentage ?? 0) - $purchaseHistory->coupon_fixed ?? 0);
            $final['time'] =  date("d-m-Y",strtotime($purchaseHistory->created_at));
            array_push($total, $final);
        }

        //
        $all=0;
        foreach ($total as $d) {
        if($d['time'] == date("d-m-Y",strtotime(now()))){
        $all += $d['price'];
        }
        }

        //
        $userCount = Count(User::where('is_admin',2)->get());
        //
        $unVerifyCount = Count(PurchaseHistory::where('purchase_status',2)->get());
        //
        $paidPurchaseCount = Count(PurchaseHistory::where('payment_status',2)->get());

        //chart


        //
        $data = [];
        $data['today'] = $all;
        $data['PPCount'] = $paidPurchaseCount;
        $data['UVCount'] = $unVerifyCount;
        $data['userCount'] = $userCount;
        return view('dashboard',compact('data'));
    }
    public function totalEarning(Request $request){
        //
        //daily
        //weekly
        //monthly
        //yearly-not important
        //views how many?
        //passengers how many?
        //sold how many?
    }
    public function totalEarnCate(Request $request){
        // money made by category
    }
}

