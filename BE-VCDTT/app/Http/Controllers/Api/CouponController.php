<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\TourRequest;
use App\Http\Resources\CouponResource;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
                ],
                'message' => 'OK',
                'status' => 200
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
        $coupon = $request->except('_token','type','price');
        // $input['start_at'] = Carbon::createFromFormat('d/m/Y', $input['start_at'])->format('Y-m-d H:i:s');
        // $input['end_at'] = Carbon::createFromFormat('d/m/Y', $input['end_at'])->format('Y-m-d H:i:s');
        $coupon['code'] = Str::upper($coupon['code']);
        if($request->type != 1){
            $coupon['fixed_price']= $request->price;
        }else{
            $coupon['percentage_price'] = $request->price;
        }
        $coupon = Coupon::create($coupon);

        if($coupon->id) {
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($coupon),
                ],
                'message' => 'Add success',
                'status' => 200
            ]);
        }else {
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
        if($coupon) {
            return response()->json([
                'data' => [
                    'coupon' => new CouponResource($coupon),
                ],
                'message' => 'OK',
                'status' => 200
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
                        'coupons' => new CouponResource($result),
                    ],
                    'message' => 'OK',
                    'status' => 200
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
        $input = $request->except('_token','type','price','_method');

        // $input['start_at'] = Carbon::createFromFormat('d/m/Y', $input['start_at'])->format('Y-m-d H:i:s');
        // $input['end_at'] = Carbon::createFromFormat('d/m/Y', $input['end_at'])->format('Y-m-d H:i:s');
        $input['code'] = Str::upper($input['code']);
        if($request->type != 1){
            $input['percentage_price'] = null;
            $input['fixed_price'] = $request->price;
        }else{
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
        if($coupon) {
            $delete_coupon =  $coupon->delete();

            if($delete_coupon) {
                return response()->json([
                    'data' => [
                        'coupon' => new CouponResource($coupon),
                    ],
                    'message' => "OK",
                        'status' => 200
                ]);
            }else {

                return response()->json([
                    'message' => 'internal server error',
                    'status' => 500
                ]);
            }
        }else {

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
            $delete_coupon =  $coupon->forceDelete();
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

    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function couponManagementList(Request $request) {
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/coupon');
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['coupons']), false);

            $perPage= $request->limit??5;// Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url())->appends(['limit' => $perPage]);
            if($data->currentPage()>$data->lastPage()){
                return redirect($data->url(1));
            }
        }else{
            $data = [];
        }
        return view('admin.coupons.list', compact('data'));
    }

    public function couponManagementAdd(CouponRequest $request) {
        if ($request->isMethod('POST')){
            $data = $request->except('_token');
            $response = Http::post('http://be-vcdtt.datn-vcdtt.test/api/coupon-store', $data);
            if($response->status() == 200) {
                return redirect()->route('coupon.list')->with('success', 'Thêm mới mã giảm giá thành công');
            } else {
                return redirect()->route('coupon.add')->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.coupons.add');
    }

    public function couponManagementEdit(Request $request, $id) {
        $response = json_decode(json_encode(Http::get('http://be-vcdtt.datn-vcdtt.test/api/coupon-show/' . $id)['data']['coupon']));
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put('http://be-vcdtt.datn-vcdtt.test/api/coupon-edit/' . $id, $data);
            if ($response->status() == 200) {
                return redirect()->route('coupon.list')->with('success', 'Cập nhật mã giảm giá thành công');
            } else {
                return redirect()->route('coupon.edit', ['id' => $id])->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.coupons.edit', compact('response'));
    }


    public function couponManagementDetail(Request $request) {
        $data = $request->except('_token');
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/coupon-show/'.$request->id);
        if($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['coupon']), false);
            $html = view('admin.coupons.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }

    public function couponManagementTrash(Request $request) {
        $data = Coupon::onlyTrashed()->get();
        $perPage = $request->limit??5;// Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.coupons.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function couponManagementRestore($id) {

        if($id) {
            $data = Coupon::withTrashed()->find($id);
            if($data) {
                $data->restore();
            }
            return redirect()->route('coupon.trash')->with('success', 'Khôi phục coupon thành công');
        }
        return redirect()->route('coupon.trash');
    }

}

