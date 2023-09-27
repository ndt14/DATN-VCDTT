<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;

class CouponController extends Controller
{
   public function index()
    {
        //
        $coupon = Coupon::all();
        return CouponResource::collection($coupon);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $coupon = Coupon::create($request->all());
        return new CouponResource($coupon);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $coupon = Coupon::find($id);
        if($coupon){
            return new CouponResource($coupon);
        }else{
            return response()->json(['message'=>'Coupon không tồn tại'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $coupon = Coupon::find($id);
        if($coupon){
            $coupon->update($request->all());
        }else{
            return response()->json(['message'=>"Coupon không tồn tại"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $coupon = Coupon::find($id);
        if($coupon){
            $coupon->delete();
            return response()->json(['message'=>"Xóa thành công"],200);
        }else{
            return response()->json(['message'=>"Coupon không tồn tại"],404);
        }
    }
}
