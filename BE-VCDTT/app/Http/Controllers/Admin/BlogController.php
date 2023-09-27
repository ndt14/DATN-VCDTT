<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{
   public function index()
    {
        //
        $blog = Blog::all();
        return BlogResource::collection($blog);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = Blog::create($request->all());
        return new BlogResource($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $blog = Blog::find($id);
        if($blog){
            return new BlogResource($blog);
        }else{
            return response()->json(['message'=>'Blog không tồn tại'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $blog = Blog::find($id);
        if($blog){
            $blog->update($request->all());
        }else{
            return response()->json(['message'=>"Blog không tồn tại"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $blog = Blog::find($id);
        if($blog){
            $blog->delete();
            return response()->json(['message'=>"Xóa thành công"],200);
        }else{
            return response()->json(['message'=>"Blog không tồn tại"],404);
        }
    }
}
