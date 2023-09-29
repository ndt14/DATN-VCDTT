<?php

namespace App\Http\Controllers\Admin;

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

        return response()->json(['dataCategoriesParent' => CategoryResource::collection($categoriesParent)], 200);

    }

    public function add(){
        $categories = new Category;
        $categoriesParent = $categories->getCategoriesParent();
        return response()->json(
            [
                'dataCategories' => CategoryResource::collection($categoriesParent),
            ],
            200
        );
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categories = new Category;
        $category = $categories->find($id)->get();
        if (!$category) {
            return response()->json(['message' => 'Không tìm thấy tour'], 404);
        }
        foreach($category as $parent){
            $parent->Child = $categories->getCategoriesChild($parent->id);
        }
        return response()->json(
            [
                'dataCategory' => CategoryResource::collection($category),
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($request->all());
            return response()->json(['message' => 'Cập nhật thành công'], 200);
        } else {
            return response()->json(['message' => 'Category không tồn tại'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    }
}
