<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Exception;
use Illuminate\Support\Facades\Http;

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
            'author',
            'short_desc',
            'description',
            'main_img',
            'view_count',
            'status',
            'created_at'
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

        if($blog->id) {

            return response()->json([
                'data' => [
                    'blog' => new BlogResource($blog)
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
        // mình chỉnh sửa lại của bạn để nó hoạt động theo yêu cầu chung
        try {

        // get all data from table images
        $images = Image::select('name', 'type', 'url')->where('blog_id', '=', $id)->get();
        // get info blog by id
        $blog = Blog::select(
            'id',
            'title',
            'author',
            'short_desc',
            'description',
            'main_img',
            'view_count',
            'status',
            'created_at'
        )->findOrFail($id);

        return response()->json(
            [
                'data' => [
                    'blog' => new BlogResource($blog),
                    'images' => new ImageResource($images),
                ],
                'message' => 'OK',
                'status' => 200
            ],
        );
        } catch (Exception $e) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        $input = $request->except('_token');

        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }

        $blog->fill($input);

        if ($blog->save()) {
            $updatedBlog = Blog::find($id);
            return response()->json(['message' => 'Cập nhật blog thành công', 'status' => 200, 'object' => $updatedBlog]);
        } else {
            return response()->json(['message' => 'internal server error', 'status' => 500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        if ($blog) {
          $delete_blog =  $blog->delete(); // soft delete
        if($delete_blog) {
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

    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function blogManagementList(Request $request)
    {
        $data = Http::get('http://be-vcdtt.datn-vcdtt.test/api/blog')->json()['data']['blogs'];
        return view('admin.blogs.list', compact('data'));
    }
    public function blogManagementAdd()
    {
        return view('admin.blogs.add');
    }

    public function blogManagementAddAction(Request $request) {

        $data = $request->except('_token');
        $response = Http::post('http://be-vcdtt.datn-vcdtt.test/api/blog-store', $data);
        if($response->status() == 200) {
            return redirect()->route('blog.list')->with('success', 'Thêm mới blog thành công');
        }
        return redirect()->route('blog.add')->with('fail', 'Đã xảy ra lỗi');
    }

    public function blogManagementEdit(Request $request)
    {
        $data = Http::get('http://be-vcdtt.datn-vcdtt.test/api/blog-show/'.$request->id)->json()['data']['blog'];
        return view('admin.blogs.edit',compact('data'));
    }

    public function blogManagementEditAction(Request $request) {

        $data = $request->except('_token');
        $response = Http::put('http://be-vcdtt.datn-vcdtt.test/api/blog-edit/'.$request->id, $data);

        if($response->status() == 200) {
            return redirect()->route('blog.edit', ['id'=>$request->id])->with('success', 'Thêm mới blog thành công');
        }
        return redirect()->route('blog.edit', ['id'=>$request->id])->with('fail', 'Đã xảy ra lỗi');
    }

    public function blogManagementDelete($id) {

        $response = Http::delete('http://be-vcdtt.datn-vcdtt.test/api/blog-destroy/'.$id);

        if($response->status() == 200) {
            return redirect()->route('blog.list')->with('success', 'Xóa blog thành công');
        }else {
            return redirect()->route('blog.list')->with('fail', 'Đã xảy ra lỗi');

        }

        return redirect()->route('blog.list');
    }
}
