<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = new Category;

        $keyword = trim($request->keyword) ? trim($request->keyword) : '';
        $limit = intval($request->limit);
        $sql_order = 'updated_at';

        $categoriesParent = $categories->getCategoriesParent($keyword, $sql_order, $limit);

        foreach($categoriesParent as $parent){
            $parent->child = $categories->getCategoriesChild($parent->id);
        }

        return response()->json(

            [
                'data' => [
                    'categoriesParent' => CategoryResource::collection($categoriesParent)
                ],
                'message' => 'OK',
                'status' => 200
            
            ]
            
            );

    }

    public function add(){
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
        if($category->id) {
            return response()->json([
                'data' => [
                    'category' => new CategoryResource($category)
                ],
                'message' => 'OK',
                'status' => 200
            ]);
        }else {
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
        // foreach($category as $parent){
        //     $parent->Child = $categories->getCategoriesChild($parent->id);
        // }
       
        return response()->json(
            [
                'data' => [
                'category' => new CategoryResource($category)
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
            
           if($cate_upd) {
            return response()->json(
                ['message' => 'Cập nhật thành công', 'status' => 200]
            
            );
           }else {
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
    public function destroy(string $id){
        $category = Category::find($id);
        if ($category) {
           $delete_cate = $category->delete(); // soft delete
           if($delete_cate) {
            return response()->json(['message' => 'Xóa thành công', 'status' => 200]);
           }else {
            return response()->json([
                'message' => 'internal server error',
                'status' => 500
            ]);
           }
            
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }


    # /\/\/\/\/\/\/\ ========================================================= NHÓM FUNC CỦA ADMIN BLADE =====================================
    
    public function cateManagementList()
    {
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/category');
        if ($response->status() == 200) {
            $data = $response->json()['data']['categoriesParent'];
            $data = json_decode(json_encode($data), false);
        } else {
            $data = [];
        }
        $perPage = 10; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url());
        return view('admin.categories.list', compact('data'));
    }   

    public function cateManagementAdd() {
        $data = Category::whereNull('parent_id')->get();
        return view('admin.categories.add', compact('data'));
    }


    public function cateManagementEidt(Request $request, $id) {

        $listCateParent = Category::whereNull('parent_id')->get();
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/category-show/'.$id);
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['category']));
        return view('admin.categories.edit', compact('data','listCateParent'));
        }else {
            return redirect()->route('category.list');
        }
    }

    
}
