<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Http\Resources\ImageResource;
use App\Models\Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Tích hợp tìm kiếm
        $keyword = trim($request->keyword) ? trim($request->keyword) : '';
        // $keyword = 'null';
        $sql_order = 'title';
        $limit = intval($request->limit) ? intval($request->limit) : '';
        $blogs = Blog::select(
            'id',
            'title',
            'short_desc',
            'description',
            'main_img',
            'view_count',
            'status'
        )->where('title', 'LIKE', '%' . $keyword . '%')->orderBy($sql_order)->limit($limit)->get();
        return response()->json([
            'data' => [
                'blogs' => BlogResource::collection($blogs),
            ],
            'message' => 'OK',
            'status' => 200
        ],);
    }

    public function add()
    {
        $images = Image::select('name', 'type', 'url', 'tour_id')->get();
        return response()->json([
            'data' => [
                'images' => ImageResource::collection($images),
            ],
            'message' => 'OK',
            'status' => 200,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $blog = Blog::create($request->all());
        return new BlogResource($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get all data from table images
        $images = Image::select('name', 'type', 'url')->where('blog_id', '=', $id)->get();
        // get info blog by id
        $blog = Blog::select(
            'title',
            'short_desc',
            'description',
            'main_img',
            'view_count',
            'status'
        )->findOrFail($id);
        if (!$blog) {
            return response()->json(['message' => '404 Not Found'], 404);
        }
        return response()->json(
            [
                'data' => [
                    'blog' => new BlogResource($blog),
                    'images' => ImageResource::collection($images),
                ],
                'message' => 'OK',
                'status' => 200
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $input = $request->except('_token');

        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Không tìm thấy blog'], 404);
        }

        $blog->fill($input);

        if ($blog->save()) {
            $updatedBlog = Blog::find($id);
            return response()->json(['message' => 'Cập nhật blog thành công', 'status' => 200, 'object' => $updatedBlog]);
        } else {
            return response()->json(['message' => 'Cập nhật blog thất bại', 'status' => 400]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        if ($blog) {
            $blog->delete(); // soft delete
            return response()->json(['message' => 'Xóa thành công', 'status' => 200]);
        } else {
            return response()->json(['message' => 'Blog không tồn tại', 'status' => 400]);
        }
    }
}
