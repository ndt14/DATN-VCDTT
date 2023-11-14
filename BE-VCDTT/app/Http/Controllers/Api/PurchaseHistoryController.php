<?php

namespace App\Http\Controllers\Api;

use Pusher\Pusher;
use App\Models\User;
use App\Models\Coupon;
use App\Models\UsedCoupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Notifications\ComfirmPayment;
use App\Http\Resources\CouponResource;
use App\Notifications\SendMailToClient;
use App\Notifications\CancelNotification;
use App\Notifications\PurchaseNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\PurchaseHistoryResource;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Notification as NotificationModel;
use App\Notifications\CancelPurchaseNotification;
use Illuminate\Support\Facades\Schema;


class PurchaseHistoryController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if (!$request->searchCol) {
            if (!$request->purchase_status) {
                $purchasehistorys = PurchaseHistory::where(function ($query) use ($keyword) {
                    $columns = Schema::getColumnListing((new PurchaseHistory())->getTable());
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', '%' . $keyword . '%');
                    }
                })->where('payment_status', 'LIKE', '%' . $request->payment_status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
            } else {
                $purchasehistorys = PurchaseHistory::where(function ($query) use ($keyword) {
                    $columns = Schema::getColumnListing((new PurchaseHistory())->getTable());
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'like', '%' . $keyword . '%');
                    }
                })->where('payment_status', 'LIKE', '%' . $request->payment_status ?? '' . '%')
                    ->where('purchase_status', $request->purchase_status)->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
            }
        } else {
            if (!$request->purchase_status) {
                $purchasehistorys = PurchaseHistory::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('payment_status', 'LIKE', '%' . $request->payment_status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
            } else {
                $purchasehistorys = PurchaseHistory::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('payment_status', 'LIKE', '%' . $request->payment_status ?? '' . '%')->where('purchase_status', $request->purchase_status)->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
            }
        }
        return response()->json(
            [
                'data' => [
                    'purchase_history' => PurchaseHistoryResource::collection($purchasehistorys)
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
        $user = User::where('is_admin', 1)->first();

        $data = $request->except('coupon_code', '_token');

        // if (!$data['transaction_id']) {
        //     $data['payment_status'] = 0;
        //     $data['purchase_status'] = 0;
        // } else {
        //     $data['payment_status'] = 1;
        //     $data['purchase_status'] = 1;
        // }

        $purchaseHistory = PurchaseHistory::create($data);

        $coupon = UsedCoupon::create($request->only(['user_id', 'coupon_code']));
        Notification::send($user, new PurchaseNotification($purchaseHistory));

        // không xóa, đây là code bắn dữ liệu thông báo lên pusher
        $newNotification = NotificationModel::orderBy('created_at', 'desc')->first();
        config_pusher()->trigger('PurchaseNotification', 'datn-vcdtt-development', $newNotification);

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
        $purchaseHistory = PurchaseHistory::withTrashed()->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

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
        $purchaseHistory = PurchaseHistory::withTrashed()->where('id', $id)->first();

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

        if (!$purchaseHistory) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $purchaseHistory->fill($input);

        if ($purchaseHistory->save()) {

            if ($updateAdmin) {
                $purchaseHistory->notify(new SendMailToClient($purchaseHistory->purchase_status));
            } elseif (!$updateAdmin && ($purchaseHistory->purchase_status == 6 || $purchaseHistory->purchase_status == 7)) {
                $users = User::where('is_admin', 1)->get();
                foreach ($users as $user) {
                    $user->notify(new CancelNotification($purchaseHistory));
                }

                $purchaseHistory->notify(new CancelPurchaseNotification($purchaseHistory));
            } elseif (!$updateAdmin && $purchaseHistory->payment_status == 1 && $purchaseHistory->purchase_status != 6 && $purchaseHistory->payment_method == 0) {
                $users = User::where('is_admin', 1)->get();
                foreach ($users as $user) {
                    $user->notify(new ComfirmPayment($purchaseHistory));
                }
                if ($purchaseHistory->payment_status == 1) {
                    $purchaseHistory->notify(new ComfirmPayment($purchaseHistory));
                }
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

    // public function sendNotiComfirm(Request $request)
    // {
    //     $data = $request->except('_token');
    // }

    public function destroyForever(string $id)
    {
        $purchaseHistory = PurchaseHistory::withTrashed()->find($id);
        if ($purchaseHistory) {
            $delete_purchaseHistory =  $purchaseHistory->forceDelete();
            if ($delete_purchaseHistory) {
                return response()->json(['message' => 'Xóa thành công', 'status' => 200]);
            } else {
                return response()->json([
                    'message' => 'internal server error',
                    'status' => 500
                ]);
            }
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 500]);
        }
    }
    //=======================================PurchaseHistoryAdmin Controller=======================================

    public function purchaseHistoryManagementList(Request $request)
    {
        $data['payment_status'] = $payment_status = $request->payment_status ?? '';
        $data['purchase_status'] = $purchase_status = $request->purchase_status ?? '';
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get("http://be-vcdtt.datn-vcdtt.test/api/purchase-history?sort=$sortField&direction=$sortDirection&payment_status=$payment_status&purchase_status=$purchase_status&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['purchase_history']), false);
            $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url());
            $request->limit ? $data->setPath(request()->url())->appends(['limit' => $perPage]) : '';
            $request->sort && $request->direction ? $data->setPath(request()->url())->appends(['sort' => $sortField, 'direction' => $sortDirection]) : '';
            $request->searchCol ? $data->setPath(request()->url())->appends(['searchCol' => $searchCol]) : '';
            $request->status ? $data->setPath(request()->url())->appends(['payment_status' => $payment_status]) : '';
            $request->status ? $data->setPath(request()->url())->appends(['purchase_status' => $purchase_status]) : '';
            $request->keyword ? $data->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->currentPage() > $data->lastPage()) {
                return redirect($data->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.purchase_histories.list', compact('data'));
    }

    public function purchaseHistoryManagementEdit(Request $request)
    {
        $items = Http::get('http://be-vcdtt.datn-vcdtt.test/api/purchase-history-show/' . $request->id)['data']['purchase_history'];
        // dd($items);
        return view('admin.purchase_histories.edit', compact('items'));
    }

    public function purchaseHistoryManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get('http://be-vcdtt.datn-vcdtt.test/api/purchase-history-show/' . $request->id)['data']['purchase_history'];
        $html = view('admin.purchase_histories.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }

    public function purchaseHistoryMarkAsRead(string $id)
    {
        $user = User::where('is_admin', 1)->first(); //lúc sau đổi thành tìm theo role
        $notification = $user->notifications->where('id', $id)->first();
        $notification->markAsRead();
        // return redirect()->back();
        return response()->json(['message' => 'Đã đọc', 'status' => 200]);
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


    public function purchaseHistoryManagementTrash(Request $request)
    {
        $data = PurchaseHistory::onlyTrashed()->get();
        $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.purchase_histories.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function purchaseHistoryManagementRestore($id)
    {

        if ($id) {
            $data = PurchaseHistory::withTrashed()->find($id);
            if ($data) {
                $data->restore();
            }
            return redirect()->route('purchase_histories.trash')->with('success', 'Khôi phục đơn đặt thành công');
        }
        return redirect()->route('purchase_histories.trash');
    }
}
