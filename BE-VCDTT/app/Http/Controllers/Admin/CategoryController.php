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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    }
}
