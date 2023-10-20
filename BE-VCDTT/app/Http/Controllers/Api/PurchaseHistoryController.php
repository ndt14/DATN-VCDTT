<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\PurchaseHistoryResource;
use App\Notifications\PurchaseNotification;
use Illuminate\Support\Facades\Notification;

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
        $purchaseHistory = PurchaseHistory::create($request->all());
        $users = User::where('is_admin',1)->get();
        Notification::send($users, new PurchaseNotification($request->transaction_id, $request->tour_name, $request->name));

        $users2 = User::where('is_admin',2)->get();
        Notification::send($users2, new PurchaseNotification($request->transaction_id, $request->tour_name, $request->name));

        if ($purchaseHistory->id) {

            return response()->json([
                'data' => [
                    'purchase_history' => new PurchaseHistoryResource($purchaseHistory)
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
    public function show(string $id){
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

    public function showById(string $id) //show theo user_id
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
        $input = $request->all();

        $purchaseHistory = PurchaseHistory::find($id);
        if (!$purchaseHistory) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $purchaseHistory->fill($input);

        if ($purchaseHistory->save()) {
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
        // dd($items);
    }

    public function purchaseHistoryManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get('http://be-vcdtt.datn-vcdtt.test/api/purchase-history-show/' . $request->id)['data']['purchase_history'];
        $html = view('admin.purchase_histories.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }
}
