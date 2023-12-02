<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\TourToCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if (!$request->searchCol) {
            $categories = Category::where(function ($query) use ($keyword) {
                $columns = Schema::getColumnListing((new Category())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->where('parent_id', NULL)->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        } elseif ($request->searchCol == 'child') {
            $childSearch = (new Category)->getCategoriesChildSearch($keyword)->pluck('parent_id')->toArray();
            $categories = Category::whereIn('id', $childSearch)->where('parent_id', NULL)->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        } else {
            $categories = Category::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('parent_id', NULL)->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        }
        foreach ($categories as $parent) {
            $parent->child = (new Category)->getCategoriesChild($parent->id);
        }


        return response()->json(

            [
                'data' => [
                    'categoriesParent' => CategoryResource::collection($categories)
                ],
                'message' => 'OK',
                'status' => 200

            ]

        );

    }

    public function add()
    {
        $categories = new Category;
        $categoriesParent = $categories->getCategoriesParent();
        return response()->json(
            [
                'data' => [
                    'categories' => CategoryResource::collection($categoriesParent),
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        if ($category->id) {
            return response()->json([
                'data' => [
                    'category' => new CategoryResource($category)
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

        // Vì để thực hiện phần show info để sửa, mình buộc phải comment dòng của bạn lại, có gì
        // ae mình trao đổi lại sau nhé

        // $categories = new Category;
        // $category = $categories->find($id)->first();
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $query = Tour::select('tours.id', 'tours.name', 'tours.duration', 'tours.child_price', 'tours.adult_price', 'tours.sale_percentage', 'tours.start_destination', 'tours.end_destination', 'tours.tourist_count', 'tours.details', 'tours.location', 'tours.exact_location', 'tours.pathway', 'tours.main_img', 'tours.view_count', 'tours.status', 'tours.created_at', 'tours.updated_at')
            ->join('tours_to_categories', 'tours.id', '=', 'tours_to_categories.tour_id')
            ->where('tours_to_categories.cate_id', $id)
            ->groupBy('tours.id')
            ->orderBy('tours.id', 'ASC');

        $toursByCate = $query->get();

        // foreach($category as $parent){
        //     $parent->Child = $categories->getCategoriesChild($parent->id);
        // }

        return response()->json(
            [
                'data' => [
                    'category' => new CategoryResource($category),
                    'toursByCate' => new TourResource($toursByCate)
                ],
                'message' => 'OK',
                'status' => 200
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $cate_upd = $category->update($request->all());

            if ($cate_upd) {
                return response()->json(
                    ['message' => 'Cập nhật thành công', 'status' => 200]

                );
            } else {
                return response()->json([
                    'message' => 'internal server error',
                    'status' => 500
                ]);
            }
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            // Lấy danh sách các IDs của các tour thuộc danh mục hiện tại
            $tourIds = $category->tours()->withTrashed()->pluck('tours.id')->toArray(); // list id tour
            $update_tour_to_cate = TourToCategory::where('cate_id', $category->id)->whereIn('tour_id', $tourIds)->update(['deleted_at' => now()]);

            if (count($tourIds) > 0) {
                foreach ($tourIds as $id_tour) {

                    $check_cate_other_of_tour = DB::table('tours_to_categories')->where('cate_id', '<>', $category->id)->where('tour_id', $id_tour)->exists();

                    if (!$check_cate_other_of_tour) {
                        $update_tour_to_cate = DB::table('tours_to_categories')->where('cate_id', $category->id)->where('tour_id', $id_tour)->update(['deleted_at' => null]);
                        $checkIsset = Category::where('name', 'Chưa phân loại')->exists();
                        if ($checkIsset) {
                            $result = Category::where('name', 'Chưa phân loại')->select('id')->first();
                            // $category->tours()->withTrashed()->update(['tours_to_categories.cate_id' => $result->id]);
                            TourToCategory::where('tour_id', $id_tour)->where('cate_id', $category->id)->withTrashed()->update(['tours_to_categories.cate_id' => $result->id, 'id_cate_before' => $category->id]);
                        } else {
                            $id_cate = Category::insertGetId(['name' => 'Chưa phân loại']);
                            // $category->tours()->withTrashed()->update(['tours_to_categories.cate_id' => $id_cate]);
                            TourToCategory::where('tour_id', $id_tour)->where('cate_id', $category->id)->withTrashed()->update(['tours_to_categories.cate_id' => $id_cate, , 'id_cate_before' => $category->id]);
                        }
                    }else {
                        $checkIsset = Category::where('name', 'Chưa phân loại')->exists();
                        if ($checkIsset) {
                            $result = Category::where('name', 'Chưa phân loại')->select('id')->first();
                            // $category->tours()->withTrashed()->update(['tours_to_categories.cate_id' => $result->id]);
                            TourToCategory::where('tour_id', $id_tour)->where('cate_id', $category->id)->withTrashed()->update(['tours_to_categories.cate_id' => $result->id, , 'id_cate_before' => $category->id]);
                        } else {
                            $id_cate = Category::insertGetId(['name' => 'Chưa phân loại']);
                            // $category->tours()->withTrashed()->update(['tours_to_categories.cate_id' => $id_cate]);
                            TourToCategory::where('tour_id', $id_tour)->where('cate_id', $category->id)->withTrashed()->update(['tours_to_categories.cate_id' => $id_cate, , 'id_cate_before' => $category->id]);
                        }
                    }

                }
            }
            $delete_cate = $category->delete(); // soft delete
            // $delete_cate = $category->tours()->delete(); // tour cũng bị xóa mềm
            if ($delete_cate) {
                return response()->json(['message' => 'Di chuyển vào thùng thành công', 'status' => 200, 'data' => $update_tour_to_cate]);
            } else {
                return response()->json([
                    'message' => 'internal server error',
                    'status' => 500
                ]);
            }

        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

    public function destroyForever(string $id)
    {
        $category = Category::withTrashed()->find($id);
        if ($category) {
            
            $tourIds = $category->tours()->withTrashed()->pluck('tours.id')->toArray();
            $delete_cate = $category->forceDelete();
            $category->tours()->withTrashed()->update(['tours.deleted_at' => null]);
            if (count($tourIds) > 0) {
                foreach ($tourIds as $id_tour) {

                    $check_cate_other_of_tour = DB::table('tours_to_categories')->where('cate_id', '<>', $category->id)->where('tour_id', $id_tour)->exists();

                    if (!$check_cate_other_of_tour) {
                        $update_tour_to_cate = DB::table('tours_to_categories')->where('cate_id', $category->id)->where('tour_id', $id_tour)->update(['deleted_at' => null]);
                        $checkIsset = Category::where('name', 'Chưa phân loại')->exists();
                        if ($checkIsset) {
                            $result = Category::where('name', 'Chưa phân loại')->select('id')->first();
                            // $category->tours()->withTrashed()->update(['tours_to_categories.cate_id' => $result->id]);
                            TourToCategory::where('tour_id', $id_tour)->where('cate_id', $category->id)->withTrashed()->update(['tours_to_categories.cate_id' => $result->id]);
                        } else {
                            $id_cate = Category::insertGetId(['name' => 'Chưa phân loại']);
                            // $category->tours()->withTrashed()->update(['tours_to_categories.cate_id' => $id_cate]);
                            TourToCategory::where('tour_id', $id_tour)->where('cate_id', $category->id)->withTrashed()->update(['tours_to_categories.cate_id' => $id_cate]);
                        }
                    }else {
                        $delete_tour_to_cate = TourToCategory::where('cate_id', $category->id)->where('tour_id', $id_tour)->forceDelete();
                    }

                }
            }

            if ($delete_cate) {
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


    # /\/\/\/\/\/\/\ ========================================================= NHÓM FUNC CỦA ADMIN BLADE =====================================


    public function cateManagementList(Request $request)
    {
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('') . "/api/category?sort=$sortField&direction=$sortDirection&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = $response->json()['data']['categoriesParent'];
            foreach ($data as $key => $item) {
                if ($item['parent_id'] == NULL) {
                    $data[$key]['parent_name'] = "Chưa có danh mục cha";
                } else {
                    $nameParent = Category::where('id', $item['parent_id'])->select('name')->first();
                    $data[$key]['parent_name'] = $nameParent['name'];
                }
            }
            $data = json_decode(json_encode($data), false);
            $perPage = $request->limit ?? 5;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url());
            $request->limit ? $data->setPath(request()->url())->appends(['limit' => $perPage]) : '';
            $request->sort && $request->direction ? $data->setPath(request()->url())->appends(['sort' => $sortField, 'direction' => $sortDirection]) : '';
            $request->searchCol ? $data->setPath(request()->url())->appends(['searchCol' => $searchCol]) : '';
            $request->keyword ? $data->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->currentPage() > $data->lastPage()) {
                return redirect($data->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.categories.list', compact('data'));

    }

    public function cateManagementAdd()
    {
        $data = Category::whereNull('parent_id')->get();
        return view('admin.categories.add', compact('data'));
    }

    public function cateManagementStore(CategoryRequest $request)
    {
        if($request->isMethod('POST')) {
            $data = $request->all();
        $response = Http::post(url('') . '/api/category-store', $data);
         // Kiểm tra kết quả từ API và trả về response tương ứng
         if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Thêm mới danh mục thành công', 'status' => 200]);
        } else {
            return response()->json(['success' => false, 'message' => 'Lỗi khi thêm mới danh mục', 'status' => 500]);
        }
        }
    }

    public function cateManagementEdit(CategoryRequest $request, $id)
    {

        if ($request->isMethod('POST')) {
            $data = $request->all();
            $response = Http::put(url('') . "/api/category-edit/{$id}", $data);
            // Kiểm tra kết quả từ API và trả về response tương ứng
         if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Cập nhật danh mục thành công', 'status' => 200]);
        } else {
            return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật danh mục', 'status' => 500]);
        }
        }
        $listCateParent = Category::whereNull('parent_id')->get();
        $response = Http::get(url('') . '/api/category-show/' . $id);
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['category']));
            return view('admin.categories.edit', compact('data', 'listCateParent'));
        } else {
            return redirect()->route('category.list');
        }
    }

    public function cateManagementTrash(Request $request)
    {
        $data = Category::onlyTrashed()->get();
        // dd($data);
        $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.categories.trash', compact('data'));
    }


    // khôi phục bản ghi bị xóa mềm

    public function cateManagementRestore($id)
    {
        if ($id) {
            $data = Category::withTrashed()->find($id);
            if ($data) {
                // Lấy danh sách các IDs của các tour thuộc danh mục hiện tại
                $tourIds = $data->tours()->withTrashed()->pluck('tours.id')->toArray();
                // $update_tour_to_cate = DB::table('tours_to_categories')->where('cate_id', $data->id)->whereIn('tour_id', $tourIds)->update(['deleted_at' => null]);
                if(count($tourIds) > 0) { 

                    foreach($tourIds as $tour_id) {

                        $update_tour_to_cate_item = DB::table('tours_to_categories')->where('id_cate_before', $data->id)->where('tour_id', $tour_id)->update(['cate_id' => $data->id]);

                    }
                }
                // Khôi phục các tour thuộc danh mục
                // $data->tours()->withTrashed()->update(['tours.deleted_at' => null]);
                // Khôi phục danh mục
                $data->restore();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Khôi phục danh mục không thành công']);
    }



}
