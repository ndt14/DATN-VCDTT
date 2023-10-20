<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\TourResource;
use App\Http\Resources\TourToCategoryResource;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Image;
use App\Models\Tour;
use App\Models\TourToCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Tích hợp tìm kiếm
        $keyword = trim($request->keyword) ? trim($request->keyword) : '';
        // $keyword = null;
        $sql_where = '';
        // $sql_where=' AND delete_at IS NULL';
        if (!empty($keyword)) {
            $sql_where .= 'name LIKE %{$keyword}%';
        }
        $sql_order = 'updated_at';
        $limit = intval($request->limit) ? intval($request->limit) : '';
        $tours = Tour::select(
            'id',
            'name',
            'duration',
            'child_price',
            'adult_price',
            'sale_percentage',
            'start_destination',
            'end_destination',
            'tourist_count',
            'details',
            'location',
            'exact_location',
            'pathway',
            'main_img',
            'view_count',
            'status',
            'created_at',
            'updated_at'
        )
            ->where('name', 'LIKE', '%' . $keyword . '%')->orderBy($sql_order, 'DESC')->limit($limit)->get();
        return response()->json(
            [
                'data' => [
                    "tours" => TourResource::collection($tours),
                ],
                "message" => "OK",
                "status" => 200

            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add()
    {
        $listCate = Category::select('id', 'name', 'parent_id')
            ->get();
        // get all data from table images
        $listImage = Image::select('name', 'type', 'url', 'tour_id')
            ->get();
        // get all data from table coupon
        $listCoupon = Coupon::select('id', 'name', 'description', 'start_date', 'end_date', 'tour_id', 'percentage_price', 'fixed_price')
            ->where('coupons.status', 1)
            ->get();
        return response()->json(
            [
                'data' => [
                    'categories' => CategoryResource::collection($listCate),
                    'images' => ImageResource::collection($listImage),
                    'coupons' => CouponResource::collection($listCoupon),

                ],
                'message' => 'OK',
                'status' => 200

            ]
        );
    }

    public function store(TourRequest $request)
    {
        $imgArray = $request->input('imgArray');
        $tour = Tour::create($request->all());
        if ($tour->id) {

            if (!empty($imgArray)) {
                $images = [];
                foreach (json_decode($imgArray, true) as $img) {
                    $data = [
                        'url' => '/upload' . $img,
                        'tour_id' => $tour->id
                    ];
                    $newImage = Image::create($data);
                    $images[] = $newImage;
                }
            }
            return response()->json([
                'data' => [
                    'tour' => new TourResource($tour),
                    'tourImages' => !empty($images) ? $images : 'No image added'
                ],
                'message' => 'Add success',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Add fail',
                'status' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get all data from table catalog
        $listCate = Category::select('id', 'name')
            ->get();
        // get all data from table images
        $listImage = Image::select('name', 'type', 'url')->where('tour_id', '=', $id)
            ->get();
        // Get all cate for tour id
        $listTourToCate = TourToCategory::select('id', 'cate_id')->where('tour_id', '=', $id)
            ->get();
        // Get id first for tour_id
        // $firstTourToCate =  TourToCategory::select('id', 'cate_id')->where('tour_id', '=', $id)
        // ->first();

        $firstTourToCate = TourToCategory::select('id', 'cate_id')
            ->where('tour_id', '=', $id)
            ->get();

        $listCoupon = Coupon::select()->where('tour_id', '=', $id)
            ->get();

        if ($firstTourToCate->isNotEmpty()) {
            $cateIds = $firstTourToCate->pluck('cate_id')->toArray();

            $query = Tour::select('tours.id', 'tours.name', 'tours.duration', 'tours.child_price', 'tours.adult_price', 'tours.sale_percentage', 'tours.start_destination', 'tours.end_destination', 'tours.tourist_count', 'tours.details', 'tours.location', 'tours.exact_location', 'tours.pathway', 'tours.main_img', 'tours.view_count', 'tours.status', 'tours.created_at', 'tours.updated_at')
                ->join('tours_to_categories', 'tours.id', '=', 'tours_to_categories.tour_id')
                ->where('tours.id', '<>', $id)
                ->whereIn('tours_to_categories.cate_id', $cateIds)
                ->groupBy('tours.id')
                ->orderBy('tours.id', 'ASC');

            $toursSameCate = $query->get();
        } else {
            $toursSameCate = Tour::select('tours.*')
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
        }

        // get info tour by id
        $tour = Tour::select(
            'id',
            'name',
            'duration',
            'child_price',
            'adult_price',
            'sale_percentage',
            'start_destination',
            'end_destination',
            'tourist_count',
            'details',
            'location',
            'exact_location',
            'pathway',
            'main_img',
            'view_count',
            'status',
            'created_at',
            'updated_at'

        )
            ->where('id', $id)
            ->first();

        if (!$tour) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        } else {

            return response()->json(
                [
                    'data' => [
                        'tour' => new TourResource($tour),
                        'categories' => new CategoryResource($listCate),
                        'images' => new ImageResource($listImage),
                        'tourToCategories' => new TourToCategoryResource($listTourToCate),
                        'toursSameCate' => new TourResource($toursSameCate),
                        'coupons' => new CouponResource($listCoupon)
                    ],
                    'message' => 'OK',
                    'status' => 200

                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(TourRequest $request, string $id)
    {

        $input = $request->all();

        $tour = Tour::find($id);
        if (!$tour) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $tour->fill($input);

        if ($tour->save()) {
            return response()->json([
                'data' => [
                    'tour' => $tour
                ],
                'message' => 'Edit tour success',
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
        $tour = Tour::find($id);
        if ($tour) {
            $delete_tour = $tour->delete();
            if ($delete_tour) {
                // soft delete
                return response()->json(['message' => 'Xóa thành công', 'status' => 200]);
            } else {
                return response()->json(['message' => 'internal server error', 'status' => 500]);
            }
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }


    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function tourManagementList(Request $request)
    {
        $items = Http::get('http://be-vcdtt.datn-vcdtt.test/api/tour')['data']['tours'];
        return view('admin.tours.list', compact('items'));
    }

    public function tourManagementAdd(Request $request)
    {
        $categories = Http::get('http://be-vcdtt.datn-vcdtt.test/api/category')['data']['categoriesParent'];
        return view('admin.tours.add', compact('categories'));
    }


    public function tourManagementEdit(Request $request)
    {
        $data = Http::get('http://be-vcdtt.datn-vcdtt.test/api/tour-show/' . $request->id)['data'];
        $tour = $data['tour'];
        $categories = $data['categories'];
        $cate_id = $data['tourToCategories'][0]['cate_id']; //đang chỉ giải quyết cho trường hợp tour có 1 cate, sau xử lý nhiều cate thì dùng foreach
        return view('admin.tours.edit', compact('tour', 'categories', 'cate_id'));
    }

    public function tourManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get('http://be-vcdtt.datn-vcdtt.test/api/tour-show/' . $request->id)['data']['tour'];
        $html = view('admin.tours.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }
}
