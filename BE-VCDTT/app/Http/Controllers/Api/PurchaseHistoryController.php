<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Coupon;
use App\Models\UsedCoupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TermAndPrivacy;
use App\Models\PurchaseHistory;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\CouponResource;
use Illuminate\Support\Facades\Schema;
use App\Notifications\ComfirmPaymentAdmin;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CancelNotificationAdmin;
use App\Http\Resources\PurchaseHistoryResource;
use App\Notifications\SendMailToClientWhenPaid;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Notifications\PurchaseNotificationAdmin;
use App\Models\Notification as NotificationModel;
use App\Notifications\CancelPurchaseMailToClient;
use App\Notifications\CancelPurchaseNotification;
use App\Notifications\PurchaseNotificationToClient;
use App\Notifications\RefundRemindingNotificationAdmin;


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
                    ->where('purchase_status', 'LIKE', '%' . $request->purchase_status ?? '' . '%')
                    ->where('tour_status', 'LIKE', '%' . $request->tour_status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
            }
        } else {
            $purchasehistorys = PurchaseHistory::where($request->searchCol, 'LIKE', '%' . $keyword . '%')
                ->where('payment_status', '%' . $request->payment_status ?? '' . '%')
                ->where('purchase_status',  '%' . $request->purchase_status ?? '' . '%')
                ->where('tour_status', '%' . $request->tour_status ?? '' . '%')
                ->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
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
        $users = User::where('is_admin', 1)->get();

        $data = $request->except('coupon_code', '_token');
        // if (!$data['transaction_id']) {
        //     $data['payment_status'] = 0;
        //     $data['purchase_status'] = 0;
        // } else {
        //     $data['payment_status'] = 1;
        //     $data['purchase_status'] = 1;
        // }
        $term = TermAndPrivacy::where('type', '=', 1)->where('status', '=', 1)->first();
        $privacy = TermAndPrivacy::where('type', '=', 2)->where('status', '=', 1)->first();
        if ($term) {
            $data['payment_term'] = $term->content;
        }
        if ($privacy) {
            $data['payment_privacy'] = $privacy->content;
        }

        $purchaseHistory = PurchaseHistory::create($data);
        if ($request->only('coupon_code') != null) {
            $coupon = UsedCoupon::create($request->only(['user_id', 'coupon_code']));
        }

        //Gửi thông báo cho admin
        foreach ($users as $user) {
            $user->notify(new PurchaseNotificationAdmin($purchaseHistory, $user->id));
        }
        $purchaseHistory->notify(new PurchaseNotificationToClient($purchaseHistory));

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
        $users = User::where('is_admin', 1)->get();

        $purchaseHistory = PurchaseHistory::find($id);

        if (!$purchaseHistory) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $purchaseHistory->fill($input);

        if ($purchaseHistory->save()) {
            //Gửi mail khi client cập nhật

            if (!$updateAdmin) {
                switch ($purchaseHistory->purchase_status) {
                    case '2':
                        if ($purchaseHistory->comfirm_click == 2) {
                            $purchaseHistory->notify(new SendMailToClientWhenPaid($purchaseHistory));
                            foreach ($users as $user) {
                                $user->notify(new ComfirmPaymentAdmin($purchaseHistory, $user->id));
                            }
                        }
                        break;
                    case '4':
                        $purchaseHistory->notify(new CancelPurchaseMailToClient($purchaseHistory));
                        foreach ($users as $user) {
                            $user->notify(new CancelNotificationAdmin($purchaseHistory, $user->id));
                        }
                    default:
                        break;
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
        $data['tour_status'] = $tour_status = $request->tour_status ?? '';
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('')."/api/purchase-history?sort=$sortField&direction=$sortDirection&payment_status=$payment_status&purchase_status=$purchase_status&tour_status=$tour_status&searchCol=$searchCol&keyword=$keyword");
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
            $request->payment_status ? $data->setPath(request()->url())->appends(['payment_status' => $payment_status]) : '';
            $request->purchase_status ? $data->setPath(request()->url())->appends(['purchase_status' => $purchase_status]) : '';
            $request->tour_status ? $data->setPath(request()->url())->appends(['tour_status' => $tour_status]) : '';
            $request->keyword ? $data->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->currentPage() > $data->lastPage()) {
                return redirect($data->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.purchase_histories.list', compact('data'));
    }

    public function purchaseHistoryManagementEdit(Request $request, string $id)
    {
        $items = Http::get(url('').'/api/purchase-history-show/' . $request->id)['data']['purchase_history'];
        if ($request->isMethod('POST')) {
            $data = json_decode(json_encode($request->except('_token', 'btnSubmit')));
            $response = Http::put(url('').'/api/purchase-history-edit/' . $id, $data);
            if (isset($data->purchase_status) && isset($items['purchase_status'])  && ($data->purchase_status != $items['purchase_status'])) {
                $users = User::where('is_admin', 1)->get();
                $responseData = json_decode(json_encode($response['data']['purchase_history']));

                $purchaseHistory = PurchaseHistory::find($responseData->id);

                if ($purchaseHistory->purchase_status != 2 && $purchaseHistory->purchase_status != 4 && $purchaseHistory->purchase_status != 1) {
                    $purchaseHistory->notify(new SendMailToClientWhenPaid($purchaseHistory));
                }
                if ($purchaseHistory->purchase_status == 6) {
                    foreach ($users as $user) {
                        $user->notify(new RefundRemindingNotificationAdmin($purchaseHistory, $user->id));
                    }
                }
            }

            if ($response->status() == 200) {
                return redirect()->route('purchase_histories.edit', ['id' => $id])->with('success', 'Cập nhật hóa đơn thành công');
            } else {
                return redirect()->route('purchase_histories.edit', ['id' => $id])->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.purchase_histories.edit', compact('items'));
    }

    public function purchaseHistoryManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get(url('').'/api/purchase-history-show/' . $request->id)['data']['purchase_history'];
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

    public function purchaseHistoryMarkAllAsRead()
    {
        $user = User::where('is_admin', 1)->first(); //lúc sau đổi thành tìm theo role
        foreach ($user->unreadnotifications as $notification) {
            $notification->markAsRead();
        }
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
                        $coupon = Coupon::where('code', $code)->first();
                        if ($coupon->status == 3) {
                            return response()->json(['message' => 'Mã này đã hết hạn', 'status' => 500]);
                        }
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

    // public function test()
    // {
    //     $purchaseHistoryTourAnnounces = PurchaseHistory::where('payment_status', '=', '2')->where('purchase_status', '=', '3')->get();
    //     foreach ($purchaseHistoryTourAnnounces as $purchaseHistoryTourAnnounce) {
    //         echo (Carbon::parse($purchaseHistoryTourAnnounce->tour_start_time)->format('Y-m-d'));
    //     }
    // }
}
