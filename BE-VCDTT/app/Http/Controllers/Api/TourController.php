<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CouponResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\TourResource;
use App\Http\Resources\TourToCategoryResource;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Image;
use App\Models\Rating;
use App\Models\Tour;
use App\Models\TourToCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;


class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Tích hợp tìm kiếm
        $keyword = $request->keyword ? trim($request->keyword) : '';
        $limit = intval($request->limit) ? intval($request->limit) : '';
        if (!$request->searchCol) {
            $tours = Tour::where(function ($query) use ($keyword) {
                $columns = Schema::getColumnListing((new Tour())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->where('status', 'LIKE', '%' . $request->status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        } elseif ($limit) {
            $tours = Tour::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->limit($limit)->get();
        } else {
            $tours = Tour::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('status', 'LIKE', '%' . $request->status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        }
        foreach ($tours as $tour) {
            $listRatings = Rating::where('tour_id', $tour->id)->orderBy('id', 'desc')->get();
            $star = 0;
            $t = 0;
            foreach ($listRatings as $c) {
                $star += $c->star;
                $t++;
            }
            $tour->star = $star / ($t == 0 ? 1 : $t);
            $tour->starCount = $t;
        }
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
        // get all data from table coupon
        $listCoupon = Coupon::select('id', 'name', 'description', 'start_date', 'end_date', 'tour_id', 'percentage_price', 'fixed_price')
            ->where('coupons.status', 1)
            ->get();
        return response()->json(
            [
                'data' => [
                    'categories' => CategoryResource::collection($listCate),
                    'coupons' => CouponResource::collection($listCoupon),
                ],
                'message' => 'OK',
                'status' => 200

            ]
        );
    }

    public function store(TourRequest $request)
    {
        $categoriesArray = [];
        $categoriesArray = $request->input('categories_data'); // ở đây thêm category
        $tour = new Tour();
        $tour->setCategoriesArray($categoriesArray);
        $tour->fill($request->all());
        $tour->save();
        if ($tour->id) {
            if (!empty($categoriesArray)) {
                $categories = [];
                foreach ($categoriesArray as $cate) {
                    $data = [
                        'cate_id' => $cate,
                        'tour_id' => $tour->id
                    ];
                    $newCate = TourToCategory::create($data);
                    $categories[] = $newCate;
                }
            }
            return response()->json([
                'data' => [
                    'tour' => new TourResource($tour),
                    'tourCategories' => !empty($categories) ? $categories : 'No category added',
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

        $listRatings = Rating::where('tour_id', $id)->orderBy('id', 'desc')->get();

        if ($firstTourToCate->isNotEmpty()) {
            $cateIds = $firstTourToCate->pluck('cate_id')->toArray();

            $query = Tour::select('tours.id', 'tours.name', 'tours.duration', 'tours.child_price', 'tours.adult_price', 'tours.sale_percentage', 'tours.start_destination', 'tours.end_destination', 'tours.tourist_count', 'tours.details', 'tours.location', 'tours.exact_location', 'tours.pathway', 'tours.main_img', 'tours.view_count', 'tours.status', 'tours.includes', 'tours.creator', 'tours.created_at', 'tours.updated_at')
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
        foreach ($toursSameCate as $tour_item) {
            $listRatings = Rating::where('tour_id', $tour_item->id)->orderBy('id', 'desc')->get();
            $star = 0;
            $t = 0;
            foreach ($listRatings as $c) {
                $star += $c->star;
                $t++;
            }
            $tour_item->star = $star / ($t == 0 ? 1 : $t);
            $tour_item->starCount = $t;
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
            'includes',
            'creator',
            'created_at',
            'updated_at'

        )
            ->where('id', $id)
            ->first();

        if (!$tour) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        } else {
            Tour::where('id', $id)->update(['view_count' => DB::raw('view_count + 1')]);
            return response()->json(
                [
                    'data' => [
                        'tour' => new TourResource($tour),
                        'categories' => new CategoryResource($listCate),
                        'images' => new ImageResource($listImage),
                        'tourToCategories' => new TourToCategoryResource($listTourToCate),
                        'toursSameCate' => new TourResource($toursSameCate),
                        'coupons' => new CouponResource($listCoupon),
                        'listRatings' => new RatingResource($listRatings)
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
        $categoriesArray = [];
        $imgArray = $request->input('imgArray');
        $categoriesArray = $request->input('categories_data'); // ở đây thêm category
        $input = $request->except('_token');

        $tour = Tour::find($id);
        if (!$tour) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
        $tour->setCategoriesArray($categoriesArray);
        $tour->fill($input);
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
        if (!empty($categoriesArray)) {
            $categories = [];
            TourToCategory::where('tour_id', $tour->id)->delete();
            foreach ($categoriesArray as $cate) {
                $data = [
                    'cate_id' => $cate,
                    'tour_id' => $tour->id
                ];
                $newCate = TourToCategory::create($data);
                $categories[] = $newCate;
            }
        }
        if ($tour->save()) {

            return response()->json([
                'data' => [
                    'tour' => $tour,
                    'tourCategories' => !empty($categories) ? $categories : 'No category added',
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
                TourToCategory::where('tour_id', $tour->id)->delete();
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

        if ($id) {
            $tour = Tour::withTrashed()->find($id);
            if ($tour) {
                TourToCategory::where('tour_id', $tour->id)->forceDelete();
                $tour->forceDelete();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'Xóa tour thành công']);
    }


    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function tourManagementList(Request $request)
    {
        $data['status'] = $status = $request->status ?? '';
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('') . "/api/tour?sort=$sortField&direction=$sortDirection&status=$status&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['tours']), false);

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
            $request->keyword ? $data->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->currentPage() > $data->lastPage()) {
                return redirect($data->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.tours.list', compact('data'));
    }

    public function tourManagementAdd(TourRequest $request)
    {
        if ($request->isMethod('POST')) {
            // Kiểm tra nếu request là Ajax
            if ($request->ajax()) {
                $data = $request->except('_token');



                // Validate form
                $myCustomAttributes = [
                    'name.required' => 'Tên của tour không được để trống',
                    'duration.required' => 'Khoảng thời gian tour không được để trống',
                    'child_price.required' => 'Giá tour cho trẻ nhỏ không được trống',
                    'adult_price.required' => 'Giá tour cho người lớn không được trống',
                    'sale_percentage.required' => 'Phần trăm giảm giá không được trống',
                    'start_destination.required' => 'Điểm bắt đầu không được để trống',
                    'end_destination.required' => 'Điểm kết thúc không được để trống',
                    'tourist_count.required' => 'Số lượng khách du lịch không được để trống',
                    'details.required' => 'Chi tiết tour không được để trống',
                    'pathway.required' => 'Lịch trình tour du lịch không được để trống',
                    'location.required' => 'Vị trí tour du lịch không được để trống',
                    'exact_location.required' => 'Vị trí chính xác tour du lịch không được để trống',
                    'main_img.required' => 'Ảnh chính của tour không được để trống',
                    'status.required' => 'Trạng thái tour không được để trống',
                    'view_count.required' => 'Số lượt xem không được để trống',
                    'pathway.required' => 'Đường dẫn không được trống',
                    'includes.required' => 'Giá tour bao gồm không được để trống'
                ];
                $validator = Validator::make($data, [
                    // 
                    'name' => 'required',
                    'duration' => 'required',
                    'child_price' => 'required',
                    'adult_price' => 'required',
                    'sale_percentage' => 'required',
                    'start_destination' => 'required',
                    'end_destination' => 'required',
                    'tourist_count' => 'required',
                    'details' => 'required',
                    'pathway' => 'required',
                    'location' => 'required',
                    'exact_location' => 'required',
                    'main_img' => 'required',
                    'status' => 'required',
                    'includes' => 'required'
                ], [], [], $myCustomAttributes);


                // kiểm tra lỗi

                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors' => $myCustomAttributes, 422]);
                }


                // Gửi request Ajax đến API
                $response = Http::post(url('') . '/api/tour-store', $data);

                // Kiểm tra kết quả từ API và trả về response tương ứng
                if ($response->successful()) {
                    return response()->json(['success' => true, 'message' => 'Thêm mới tour thành công', 'status' => 200]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Lỗi khi thêm mới tour', 'status' => 500]);
                }
            }
        }

        return view('admin.tours.add');
    }


    public function tourManagementEdit(TourRequest $request, $id)
    {
        $response = Http::get(url('') . '/api/tour-show/' . $id)['data'];
        $tour = json_decode(json_encode($response['tour']), false);
        $tourToCate = $response['tourToCategories'];
        $cateIds = [];
        // dd($tourToCate);
        foreach ($tourToCate as $item) {
            $cateIds[] = $item['cate_id'];
        }
        if ($request->isMethod('POST')) {
            // Kiểm tra nếu request là Ajax
            if ($request->ajax()) {
                $data = $request->except('_token', 'btnSubmit');



                // Validate form
                $myCustomAttributes = [
                    'name.required' => 'Tên của tour không được để trống',
                    'duration.required' => 'Khoảng thời gian tour không được để trống',
                    'child_price.required' => 'Giá tour cho trẻ nhỏ không được trống',
                    'adult_price.required' => 'Giá tour cho người lớn không được trống',
                    'sale_percentage.required' => 'Phần trăm giảm giá không được trống',
                    'start_destination.required' => 'Điểm bắt đầu không được để trống',
                    'end_destination.required' => 'Điểm kết thúc không được để trống',
                    'tourist_count.required' => 'Số lượng khách du lịch không được để trống',
                    'details.required' => 'Chi tiết tour không được để trống',
                    'pathway.required' => 'Lịch trình tour du lịch không được để trống',
                    'location.required' => 'Vị trí tour du lịch không được để trống',
                    'exact_location.required' => 'Vị trí chính xác tour du lịch không được để trống',
                    'main_img.required' => 'Ảnh chính của tour không được để trống',
                    'status.required' => 'Trạng thái tour không được để trống',
                    'view_count.required' => 'Số lượt xem không được để trống',
                    'pathway.required' => 'Đường dẫn không được trống',
                    'includes.required' => 'Giá tour bao gồm không được để trống'
                ];
                $validator = Validator::make($data, [
                    // 
                    'name' => 'required',
                    'duration' => 'required',
                    'child_price' => 'required',
                    'adult_price' => 'required',
                    'sale_percentage' => 'required',
                    'start_destination' => 'required',
                    'end_destination' => 'required',
                    'tourist_count' => 'required',
                    'details' => 'required',
                    'pathway' => 'required',
                    'location' => 'required',
                    'exact_location' => 'required',
                    'main_img' => 'required',
                    'status' => 'required',
                    'includes' => 'required'
                ], [], [], $myCustomAttributes);


                // kiểm tra lỗi

                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors' => $myCustomAttributes, 422]);
                }

            $response = Http::put(url('') . '/api/tour-edit/' . $id, $data);

            // Kiểm tra kết quả từ API và trả về response tương ứng
            if ($response->successful()) {
                return response()->json(['success' => true, 'message' => 'Cập nhật tour thành công', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật tour', 'status' => 500]);
            }
        }
    }
        return view('admin.tours.edit', compact('tour', 'cateIds'));
    }

    public function tourManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get(url('') . '/api/tour-show/' . $request->id)['data']['tour'];
        $listRatings = Rating::where('tour_id', $request->id)->orderBy('id', 'desc')->get();
        $star = 0;
        $t = 0;
        foreach ($listRatings as $c) {
            $star += $c->star;
            $t++;
        }
        $item['star'] = $star / ($t == 0 ? 1 : $t);
        $item['rcount'] = $t;
        $html = view('admin.tours.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }

    public function tourManagementTrash(Request $request)
    {
        $data = Tour::onlyTrashed()->get();
        $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.tours.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function tourManagementRestore($id)
    {

        if ($id) {
            $data = Tour::withTrashed()->find($id);
            if ($data) {
                $data->restore();
                TourToCategory::where('tour_id', $data->id)->restore();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Khôi phục tour không thành công']);
    
    }

}
