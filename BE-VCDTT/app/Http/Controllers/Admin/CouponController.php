<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\TourRequest;
use App\Http\Resources\CouponResource;
use Illuminate\Support\Carbon;

class CouponController extends Controller
{
   public function index()
    {
        //
        $listCounpon = Coupon::all();
        if(count($listCounpon) > 0) {
            return response()->json([
                'data' => [
                    'coupons' =>  CouponResource::collection($listCounpon),
                    'message' => 'OK',
                    'status' => 200
                ]
            ]);
        }else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $input = $request->all();
        // $input['start_at'] = Carbon::createFromFormat('d/m/Y', $input['start_at'])->format('Y-m-d H:i:s');
        // $input['end_at'] = Carbon::createFromFormat('d/m/Y', $input['end_at'])->format('Y-m-d H:i:s');
        $new_coupon = Coupon::create($input);

        if($new_coupon->id) {
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($new_coupon),
                    'message' => 'OK',
                    'status' => 201
                ]
            ]);
        }else {
            return response()->json(
                [
                    'message' => 'Fail',
                    'status' => 500
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $coupon = Coupon::find($id);
        if($coupon) {
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($coupon),
                    'message' => 'OK',
                    'status' => 200
                ]
            ]);
        }else {
            return response()->json([
                'message' => '404 Not found',
                'status' => 404
            ]);
        }
    }

    // search coupon theo mã

    public function search_coupon(Request $request) {

        $name = $request->query('name');
        $result = Coupon::where('name','LIKE',"%$name%")->get();

        if(count($result) > 0) {

            return response()->json(
                [
                    'data' => [
                        'coupons' => CouponResource::collection($result),
                        'message' => 'OK',
                        'status' => 200
                    ]
                ]
            );
        }else {
            return response()->json([
                'message' => '404 Not found',
                'status' => 404
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, string $id)
    {
        //

        $input = $request->all();

        $coupon = Coupon::find($id);
        if (!$coupon) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $coupon->fill($input);

        if ($coupon->save()) {
            return response()->json([
                'data' => [
                    'coupon' => $coupon
                ],
                'message' => 'OK',
                'status' => 200,
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $coupon = Coupon::find($id);
        if($coupon) {
            $coupon->delete();
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($coupon),
                    'message' => "OK",
                    'status' => 200
                ]
            ]);
        }else {
            return response()->json([
                'message' => 'Fail',
                'status' => 500
            ]);
        }

    }
}
