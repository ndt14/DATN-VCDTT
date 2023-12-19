<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\TourRequest;
use App\Http\Resources\CouponResource;
use App\Models\UsedCoupon;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ? trim($request->keyword) : '';
        $code_type = $request->code_type == '1' ? 'percentage_price' : ($request->code_type == '2' ? 'fixed_price' : 'name');
        $sortCol = $request->sort ?? 'created_at';
        $request->code_type && $request->sort == 'amount' ? $sortCol = $code_type : '';
        if (!$request->searchCol) {
            $coupons = Coupon::where(function ($query) use ($keyword) {
                $columns = Schema::getColumnListing((new Coupon())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->where('status', 'LIKE', '%' . $request->status ?? '' . '%')
                ->where(function ($query) use ($code_type) {
                    if ($code_type === 'fixed_price') {
                        $query->whereNull('percentage_price');
                    } elseif ($code_type === 'percentage_price') {
                        $query->wherenotNull('percentage_price');
                    }
                })
                ->orderBy($sortCol, $request->direction ?? 'desc')->get();
        } elseif ($request->searchCol == 'amount') {
            $coupons = Coupon::where('percentage_price', 'LIKE', '%' . $keyword . '%')->orWhere('fixed_price', 'LIKE', '%' . $keyword . '%')->where('status', 'LIKE', '%' . $request->status ?? '' . '%')
                ->where(function ($query) use ($code_type) {
                    if ($code_type === 'fixed_price') {
                        $query->whereNull('percentage_price');
                    } elseif ($code_type === 'percentage_price') {
                        $query->wherenotNull('percentage_price');
                    }
                })
                ->orderBy($sortCol, $request->direction ?? 'desc')->get();
        } else {
            $coupons = Coupon::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('status', 'LIKE', '%' . $request->status ?? '' . '%')
                ->where(function ($query) use ($code_type) {
                    if ($code_type === 'fixed_price') {
                        $query->whereNull('percentage_price');
                    } elseif ($code_type === 'percentage_price') {
                        $query->wherenotNull('percentage_price');
                    }
                })
                ->orderBy($sortCol, $request->direction ?? 'desc')->get();
        }
        return response()->json([
            'data' => [
                'coupons' => CouponResource::collection($coupons),
            ],
            'message' => 'OK',
            'status' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $coupon = $request->except('_token', 'type', 'price');
        // $input['start_at'] = Carbon::createFromFormat('d/m/Y', $input['start_at'])->format('Y-m-d H:i:s');
        // $input['end_at'] = Carbon::createFromFormat('d/m/Y', $input['end_at'])->format('Y-m-d H:i:s');
        $coupon['code'] = Str::upper($coupon['code']);
        if ($request->type != 1) {
            $coupon['fixed_price'] = $request->price;
        } else {
            $coupon['percentage_price'] = $request->price;
        }
        $coupon = Coupon::create($coupon);

        if ($coupon->id) {
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($coupon),
                ],
                'message' => 'Add success',
                'status' => 200
            ]);
        } else {
            return response()->json(
                [
                    'message' => 'internal server error',
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

        $coupon = Coupon::withTrashed()->find($id);
        if ($coupon) {
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($coupon),
                ],
                'message' => 'OK',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => '404 Not found',
                'status' => 404
            ]);
        }
    }

    // search coupon theo mã

    public function search_coupon(Request $request)
    {

        $name = $request->query('name');
        $result = Coupon::where('name', 'LIKE', "%$name%")->get();

        if (count($result) > 0) {

            return response()->json(
                [
                    'data' => [
                        'coupons' => new CouponResource($result),
                    ],
                    'message' => 'OK',
                    'status' => 200
                ]
            );
        } else {
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
        $input = $request->except('_token', 'type', 'price', '_method');

        // $input['start_at'] = Carbon::createFromFormat('d/m/Y', $input['start_at'])->format('Y-m-d H:i:s');
        // $input['end_at'] = Carbon::createFromFormat('d/m/Y', $input['end_at'])->format('Y-m-d H:i:s');
        $check_code = Coupon::where('code', $input['code'])->whereNull('deleted_at')->get();
        $input['code'] = Str::upper($input['code']);
        // if($check_code->id && Str::upper($check_code->code) != $input['code']){
        //     return response()->json([
        //         'message' => 'Mã đã tồn tại',
        //         'status' => 500
        //     ]);
        // }
        if ($request->type != 1) {
            $input['percentage_price'] = null;
            $input['fixed_price'] = $request->price;
        } else {
            $input['fixed_price'] = null;
            $input['percentage_price'] = $request->price;
        }
        $coupon = Coupon::find($id);
        $coupon->update($input);
        if ($coupon->id) {
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($coupon)
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
        if ($coupon) {
            $delete_coupon = $coupon->delete();

            if ($delete_coupon) {
                return response()->json([
                    'data' => [
                        'coupon' => new CouponResource($coupon),
                    ],
                    'message' => "OK",
                    'status' => 200
                ]);
            } else {

                return response()->json([
                    'message' => 'internal server error',
                    'status' => 500
                ]);
            }
        } else {

            return response()->json([
                'message' => '404 Not found',
                'status' => 404
            ]);
        }
    }


    public function destroyForever(string $id)
    {
        $coupon = Coupon::withTrashed()->find($id);
        if ($coupon) {
            $delete_coupon = $coupon->forceDelete();
            if ($delete_coupon) {
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

    public function listCouponUserId(Request $request, string $id)
    {
        $coupons = Coupon::whereNotIn('code', UsedCoupon::select('coupon_code')->where('user_id', $id)->get())->get();
        return response()->json([
            'data' => [
                'coupons' => CouponResource::collection($coupons),
            ],
            'message' => 'OK',
            'status' => 200
        ]);
    }

    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function couponManagementList(Request $request)
    {
        $data['status'] = $status = $request->status ?? '';
        $data['code_type'] = $code_type = $request->code_type ?? '';
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('') . "/api/coupon?sort=$sortField&direction=$sortDirection&status=$status&code_type=$code_type&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['coupons']), false);

            $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url());
            $request->limit ? $data->setPath(request()->url())->appends(['limit' => $perPage]) : '';
            $request->sort && $request->direction ? $data->setPath(request()->url())->appends(['sort' => $sortField, 'direction' => $sortDirection]) : '';
            $request->searchCol ? $data->setPath(request()->url())->appends(['searchCol' => $searchCol]) : '';
            $request->status ? $data->setPath(request()->url())->appends(['status' => $status]) : '';
            $request->code_type ? $data->setPath(request()->url())->appends(['code_type' => $code_type]) : '';
            $request->keyword ? $data->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->currentPage() > $data->lastPage()) {
                return redirect($data->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.coupons.list', compact('data'));
    }

    public function couponManagementAdd(CouponRequest $request)
    {
        if ($request->isMethod('POST')) {
            if ($request->ajax()) {
                $data = $request->except('_token');
                $response = Http::post(url('') . '/api/coupon-store', $data);
                // Kiểm tra kết quả từ API và trả về response tương ứng
                if ($response->successful()) {
                    return response()->json(['success' => true, 'message' => 'Thêm mới mã giảm giá thành công', 'status' => 200]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Lỗi khi thêm mới mã giảm giá', 'status' => 500]);
                }
            }
        }
        return view('admin.coupons.add');
    }

    public function couponManagementEdit(CouponRequest $request, $id)
    {
        $response = json_decode(json_encode(Http::get(url('') . '/api/coupon-show/' . $id)['data']['coupon']));
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put(url('') . '/api/coupon-edit/' . $id, $data);
           // Kiểm tra kết quả từ API và trả về response tương ứng
           if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Cập nhật mã giảm giá thành công', 'status' => 200]);
        } else {
            return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật mã giảm giá', 'status' => 500]);
        }
        }
        return view('admin.coupons.edit', compact('response'));
    }


    public function couponManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $response = Http::get(url('') . '/api/coupon-show/' . $request->id);
        if ($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['coupon']), false);
            $html = view('admin.coupons.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }

    public function couponManagementTrash(Request $request)
    {
        $data = Coupon::onlyTrashed()->get();
        $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.coupons.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function couponManagementRestore($id)
    {

        if ($id) {
            $data = Coupon::withTrashed()->find($id);
            if ($data) {
                $data->restore();
            }
            return response()->json(['success' => true, 'message' => 'Khôi phục mã giảm giá thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Khôi phục mã giảm giá không thành công']);
    }
}
