<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tour;
use App\Models\Image;
use App\Models\Coupon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\CategoryResource;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tour = Tour::all();
        return TourResource::collection($tour);
    }

    /**
     * Store a newly created resource in storage.
     */
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
        //
        // get all data from table catalog
        $listCate = Category::select('categories.id as idCat', 'categories.name as catName', 'categories.parent_id as parentId')->get();
        // get all data from table images
        $listImage = Image::select(
            'images.id as idImage',
            'images.name as nameImage',
            'images.type as typeImage',
            'images.url as urlImage',
            'images.tour_id as tourId',
            'images.blog_id as blogId'
        )->get();
        // get all data from table coupon
        $listCoupon = Coupon::select(
            'coupons.id as idCoupon',
            'coupons.name as nameCoupon',
            'coupons.description as descCoupon',
            'coupons.start_date as startDate',
            'coupons.end_date as endDate',
            'coupons.tour_id as idTour',
            'coupons.cate_id as idCate',
            'coupons.percentage_price as percentagePrice',
            'coupons.fixed_price as fixedPrice',
            'coupons.status'
        )->get();

        // get info tour by id
        $tour = Tour::join('images', 'tours.main_img', '=', 'images.id')
            ->join('coupons', 'coupons.tour_id', '=', 'tours.id')
            ->join('tours_to_categories', 'tours_to_categories.tour_id', '=', 'tours.id')
            ->join('categories', 'categories.id', '=', 'tours_to_categories.cate_id')
            ->select(
                'tours.name as tourName',
                'tours.duration',
                'tours.child_price as childPrice',
                'tours.adult_price as adultPrice',
                'tours.sale_percentage as salePercentage',
                'tours.start_destination as startDestination',
                'tours.end_destination as endDestination',
                'tours.tourist_count as touristCount',
                'tours.details',
                'tours.location',
                'tours.exact_location as exactLocation',
                'tours.main_img as mainImg',
                'tours.status',
                'tours.view_count as viewCount',
                'tours.created_at as createdAt',
                'tours.updated_at as updateAt',
                'images.url as urlImage',
                'coupons.name as couponName',
                'categories.name as cateName'
            )
            ->findOrFail($id);
        if (!$tour) {
            return response()->json(['message' => '404 Not Found', 'statusCode' => 404]);
        }
        return response()->json(
            [
                'infoTour' => new TourResource($tour),
                'dataCategories' => CategoryResource::collection($listCate),
                'dataImages' => ImageResource::collection($listImage),
                'dataCoupons' => CouponResource::collection($listCoupon),
                'statusCode' => 200
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $tour = Tour::find($id);
        if ($tour) {
            $tour->update($request->all());
        } else {
            return response()->json(['message' => "Tour không tồn tại"], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tour = Tour::find($id);
        if ($tour) {
            $tour->delete();
            return response()->json(['message' => "Xóa thành công"], 200);
        } else {
            return response()->json(['message' => "Tour không tồn tại"], 404);
        }
    }
}
