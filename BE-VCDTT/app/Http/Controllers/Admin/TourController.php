<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\TourResource;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Image;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Tích hợp tìm kiếm
        $keyword = trim($request()->keyword);
        $sql_where ='';
        // $sql_where=' AND delete_at IS NULL';
        if(!empty($keyword)){
            $sql_where .= ' AND tour_name LIKE %{$keyword}%';
        }
         $sql_order =' ORDER BY DESC';
         $sql_limit =' LIMIT 9';
        $tour = DB::select('select * from tours where 1'.$sql_where.$sql_order.$sql_limit);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add()
    {
        $listCate = Category::select('id', 'name', 'parent_id')
        ->get();
        // get all data from table images
        $listImage = Image::select( 'name', 'type', 'url', 'tour_id')
        ->get();
        // get all data from table coupon
        $listCoupon = Coupon::select('id', 'name', 'description', 'start_date', 'end_date', 'tour_id', 'percentage_price', 'fixed_price')
        ->where('coupons.status', 1)
        ->get();
        return response()->json(
            [
                'dataCategories' => CategoryResource::collection($listCate),
                'dataImages' => ImageResource::collection($listImage),
                'dataCoupons' => CouponResource::collection($listCoupon),
            ], 200
        );
    }

    public function store(Request $request)
    {
        $tour = Tour::create($request->all());
        return new TourResource($tour);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get all data from table catalog
        $listCate = Category::select('id', 'name', 'parent_id')
        ->get();
            ->get();
        // get all data from table images
        $listImage = Image::select( 'name', 'type', 'url', 'tour_id')
        ->get();
        $listImage = Image::select('name', 'type', 'url', 'tour_id')
            ->get();
        // get all data from table coupon
        $listCoupon = Coupon::select('id', 'name', 'description', 'start_date', 'end_date', 'tour_id', 'percentage_price', 'fixed_price')
        ->where('coupons.status', 1)
        ->get();
            ->where('coupons.status', 1)
            ->get();
        // get info tour by id
        $tour = Tour::join('images', 'tours.main_img', '=', 'images.id')
    ->join('tours_to_categories', 'tours_to_categories.tour_id', '=', 'tours.id')
    ->join('categories', 'categories.id', '=', 'tours_to_categories.cate_id')
    ->select(
        'tours.id',
        'tours.name',
        'tours.duration',
        'tours.child_price',
        'tours.adult_price',
        'tours.sale_percentage',
        'tours.start_destination',
        'tours.end_destination',
        'tours.tourist_count',
        'tours.details',
        'tours.location',
        'tours.exact_location',
        'tours.main_img',
        'tours.status',
        'categories.id'
    )
    ->where('tours.id', $id)
    ->first();

    if (!$tour) {
        return response()->json(['message' => '404 Not Found'], 404);
    } else {
        return response()->json(
            [
                'infoTour' => new TourResource($tour),
                'dataCategories' => CategoryResource::collection($listCate),
                'dataImages' => ImageResource::collection($listImage),
                'dataCoupons' => CouponResource::collection($listCoupon),
            ],
            200
        );
    }
    
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(TourRequest $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'duration' => 'required',
            'child_price' => 'required',
            'adult_price' => 'required',
            'sale_percentage' => 'required',
            'start_destination' => 'required',
            'end_destination' => 'required',
            'tourist_count' => 'required',
            'details' => 'required',
            'location' => 'required',
            'exact_location' => 'required',
            'main_img' => 'required',
            'status' => 'required',
            'view_count' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $input = $request->except('_token');
        $input = $request->all();

        $tour = Tour::find($id);
        if (!$tour) {
            return response()->json(['message' => 'Không tìm thấy tour'], 404);
        }

        $tour->fill($input);

        if ($tour->save()) {
            $updatedTour = Tour::find($id);
            return response()->json(['message' => 'Cập nhật tour thành công', 'statusCode' => 200, 'object' => $updatedTour]);
            return response()->json(['message' => 'Cập nhật tour thất bại'], 500);
            return response()->json(['message' => 'Cập nhật tour thành công', 'statusCode' => 200, 'object' => $tour]);
        }
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = Tour::find($id);
        if ($tour) {
            $tour->delete(); // soft delete
            return response()->json(['message' => 'Xóa thành công'], 200);
        } else {
            return response()->json(['message' => 'Tour không tồn tại'], 404);
        }
    }
}
