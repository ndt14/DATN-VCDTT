<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Http\Resources\PurchaseHistoryResource;
use App\Models\Coupon;
use App\Models\UsedCoupon;
use Illuminate\Support\Str;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $purchaseHistory = PurchaseHistory::create($request->except('coupon_code'));

        if($purchaseHistory->id) {
            $coupon = UsedCoupon::create($request->only(['user_id','coupon_code']));
            return response()->json([
                'data' => [
                    'purchase_history' => new PurchaseHistoryResource($purchaseHistory),
                    'coupon' => new CouponResource($coupon),
                ],
                'message' => 'OK',
                'status' => 200
            ]);
        }else {
            return response()->json([
                'message' => 'internal server error',
                'status' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    }

    public function check_coupon(Request $request){
        if($request->user_id!=null){
            if($request->coupon_code!=null){
                $code = Str::upper($request->coupon_code);
                if(Coupon::select()->where('code',$code)->exists()){
                if(UsedCoupon::select()->where('user_id',$request->user_id)->where('coupon_code',$code)->exists()){
                    return response()->json(['message' => 'This coupon code has been used', 'status' => 500]);
                }else{
                    $coupon = Coupon::select()->where('code',$code)->first();
                    return response()->json([
                        'coupon' => new CouponResource($coupon),
                        'message' => 'This coupon code is valid',
                        'status' => 200
                ]);
                }
                }else{
                    return response()->json(['message' => 'This coupon code is unvalid', 'status' => 500]);
                }
            }
        }
    }
}
