<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Notifications\PurchaseNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\CouponResource;
use App\Http\Resources\PurchaseHistoryResource;
use App\Models\Coupon;
use App\Models\UsedCoupon;
use App\Notifications\SendMailToClient;
use Illuminate\Support\Str;


class PurchaseHistoryController extends Controller
{
    public function index()
    {
        //
        $listPurchaseHistory = PurchaseHistory::orderBy('created_at', 'asc')->get();
        return response()->json(
            [
                'data' => [
                    'purchase_history' => PurchaseHistoryResource::collection($listPurchaseHistory)
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $users = User::where('is_admin',1)->get();

        $purchaseHistory = PurchaseHistory::create($request->except('coupon_code'));
        $coupon = UsedCoupon::create($request->only(['user_id', 'coupon_code']));
        Notification::send($users, new PurchaseNotification($purchaseHistory));

        if ($purchaseHistory->id) {
            return response()->json([
                'data' => [
                    'purchase_history' => new PurchaseHistoryResource($purchaseHistory),
                    'coupon' => new CouponResource($coupon),
                ],
                'message' => 'OK',
                'status' => 200
            ]);
        } else {
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



    public function showByUser(string $user_id) //show theo user_id
    {
        //
        $purchaseHistory = PurchaseHistory::where('user_id', $user_id)->get();

        if (!$purchaseHistory) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        } else {
            return response()->json([
                'data' => [
                    'purchase_history' => new PurchaseHistoryResource($purchaseHistory)
                ],
                'message' => 'OK',
                'status' => 200,
            ]);
        }
    }

    public function showById(string $id) //show theo id đơn hàng
    {
        //
        $purchaseHistory = PurchaseHistory::where('id', $id)->first();

        if (!$purchaseHistory) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        } else {
            return response()->json([
                'data' => [
                    'purchase_history' => new PurchaseHistoryResource($purchaseHistory)
                ],
                'message' => 'OK',
                'status' => 200,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $input = $request->except('update_admin');
        $updateAdmin = $request->only('update_admin');

        $purchaseHistory = PurchaseHistory::find($id);

        // $email = $user->email;

        if (!$purchaseHistory) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $purchaseHistory->fill($input);

        if ($purchaseHistory->save()) {

            if($updateAdmin){
                $purchaseHistory->notify(new SendMailToClient());
            }

            return response()->json([
                'data' => [
                    'purchase_history' => $purchaseHistory
                ],
                'message' => 'Edit success',
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'message' => 'Can not edit, internal server error',
                'status' => 500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $purchaseHistory = PurchaseHistory::find($id);
        if ($purchaseHistory) {
            $delete_purchase_history = $purchaseHistory->delete();
            if ($delete_purchase_history) {
                // soft delete
                return response()->json(['message' => 'Xóa thành công', 'status' => 200]);
            } else {
                return response()->json(['message' => 'internal server error', 'status' => 500]);
            }
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

    // public function markAsRead(){
    //     Auth::user()->unreadNotifications->markAsRead();
    //     return redirect()->back();
    // }

    //=======================================PurchaseHistoryAdmin Controller=======================================

    public function purchaseHistoryManagementList(Request $request)
    {
        $items = Http::get('http://be-vcdtt.datn-vcdtt.test/api/purchase-history')->json()['data']['purchase_history'];
        return view('admin.purchase_histories.list', compact('items'));
    }

    public function purchaseHistoryManagementEdit(Request $request)
    {
        $items = Http::get('http://be-vcdtt.datn-vcdtt.test/api/purchase-history-show/' . $request->id)['data']['purchase_history'];
        return view('admin.purchase_histories.edit', compact('items'));
    }

    public function purchaseHistoryManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get('http://be-vcdtt.datn-vcdtt.test/api/purchase-history-show/' . $request->id)['data']['purchase_history'];
        $html = view('admin.purchase_histories.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }

    public function purchaseHistoryMarkAsRead(){
        $user = User::where('is_admin',1)->first();
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

    //coupon

    public function check_coupon(Request $request)
    {
        if ($request->user_id != null) {
            if ($request->coupon_code != null) {
                $code = Str::upper($request->coupon_code);
                if (Coupon::select()->where('code', $code)->exists()) {
                    if (UsedCoupon::select()->where('user_id', $request->user_id)->where('coupon_code', $code)->exists()) {
                        return response()->json(['message' => 'Bạn đã dùng mã này cho 1 đơn khác', 'status' => 500]);
                    } else {
                        $coupon = Coupon::select()->where('code', $code)->first();
                        return response()->json([
                            'coupon' => new CouponResource($coupon),
                            'message' => 'Mã giảm giá hợp lệ',
                            'status' => 200
                        ]);
                    }
                } else {
                    return response()->json(['message' => 'Không có mã giảm giá này', 'status' => 500]);
                }
            }
        }
    }
}
