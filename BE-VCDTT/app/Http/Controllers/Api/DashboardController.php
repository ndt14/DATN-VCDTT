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
        $data = [];
        $purchaseHistory = PurchaseHistory::where('purchase_status',5)->orWhere('purchase_status',10)->get();

        $total=[];
        foreach($purchaseHistory as $purchaseHistory){
            $final['price'] = $purchaseHistory->tour_child_price * $purchaseHistory->child_count + $purchaseHistory->tour_adult_price * $purchaseHistory->adult_count;
            $final['price'] = $final['price']- ($final['price']/ 100 * ($purchaseHistory->coupon_percentage ?? 0 + $purchaseHistory->tour_sale_percentage ?? 0) - $purchaseHistory->coupon_fixed ?? 0);
            $final['time'] =  date("d-m-Y",strtotime($purchaseHistory->created_at));
            array_push($total, $final);
        }

        //
        $data['today']=0; $data['week']=0; $data['month']=0; $data['year']=0;
        foreach ($total as $d) {
        if($d['time'] == date("d-m-Y",strtotime(now()))){
            $data['today']+= $d['price'];
        }
        if( date("W-Y",strtotime($d['time'])) == date("W-Y",strtotime(now()))){
            $data['week'] += $d['price'];
        }
        if( date("m-Y",strtotime($d['time'])) == date("m-Y",strtotime(now()))){
            $data['month'] += $d['price'];
        }
        if( date("Y",strtotime($d['time'])) == date("Y",strtotime(now()))){
            $data['year'] += $d['price'];
        }
        }

        //
        $userCount = Count(User::where('is_admin',2)->get());
        //
        $data['UVCount'] = Count(PurchaseHistory::where('purchase_status',2)->get());
        //
        $paidPurchaseCount = PurchaseHistory::where('payment_status',2)->get();
        $data['PPCToday']=0;
        $data['PPCWeek']=0;
        $data['PPCMonth']=0;
        $data['PPCYear']=0;
        foreach ($paidPurchaseCount as $PP){
        if(date("d-m-Y",strtotime($PP->created_at)) == date("d-m-Y",strtotime(now()))){
            $data['PPCToday']++;
        }
        if(date("W-Y",strtotime($PP->created_at)) == date("W-Y",strtotime(now()))){
            $data['PPCMonth']++;
        }
        if(date("m-Y",strtotime($PP->created_at)) == date("m-Y",strtotime(now()))){
            $data['PPCMonth']++;
        }
        if(date("Y",strtotime($PP->created_at)) == date("Y",strtotime(now()))){
            $data['PPCYear']++;
        }
    }
        //chart


        //

        $data['PPCount'] = $paidPurchaseCount;
        $data['userCount'] = $userCount;
        $data = json_decode(json_encode($data));
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
