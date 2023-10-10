<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = new Category;

        $keyword = trim($request->keyword) ? trim($request->keyword) : '';
        $limit = intval($request->limit);
        $sql_order = 'name';

        $categoriesParent = $categories->getCategoriesParent($keyword, $sql_order, $limit);

        foreach($categoriesParent as $parent){
            $parent->Child = $categories->getCategoriesChild($parent->id);
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
                'status' => 201
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
        $categories = new Category;
        $category = $categories->find($id)->get();
        if (!$category) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
        foreach($category as $parent){
            $parent->Child = $categories->getCategoriesChild($parent->id);
        }
        return response()->json(
            [
                'data' => [
                'category' => CategoryResource::collection($category)
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
}