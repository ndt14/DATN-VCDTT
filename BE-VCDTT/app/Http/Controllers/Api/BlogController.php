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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Tích hợp tìm kiếm
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if (!$request->searchCol) {
            $blogs = Blog::where(function ($query) use ($keyword) {
                $columns = Schema::getColumnListing((new Blog())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->where('status', 'LIKE', '%' . $request->status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        } else {
            $blogs = Blog::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('status', 'LIKE', '%' . $request->status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        }
        return response()->json([
            'data' => [
                'blogs' => BlogResource::collection($blogs),
            ],
            'message' => 'OK',
            'status' => 200
        ], );
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

        if ($blog->id) {

            return response()->json([
                'data' => [
                    'blog' => new BlogResource($blog)
                ],
                'message' => 'Add success',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Validate error',
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
            $blog = Blog::withTrashed()->select(
                'id',
                'title',
                'author',
                'short_desc',
                'description',
                'main_img',
                'view_count',
                'status',
                'created_at',
                'updated_at'
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
            return response()->json(['message' => "Edit fail, can't find your blogs ", 'status' => 500]);
        }

        $blog->fill($input);

        if ($blog->save()) {
            $updatedBlog = Blog::find($id);
            return response()->json(['message' => 'Edit success', 'status' => 200, 'object' => $updatedBlog]);
        } else {
            return response()->json(['message' => 'Edit fail', 'status' => 500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::find($id);
        if ($blog) {
            $delete_blog = $blog->delete();
            if ($delete_blog) {
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

    public function destroyForever(string $id)
    {
        $blog = Blog::withTrashed()->find($id);
        if ($blog) {
            $delete_blog = $blog->forceDelete();
            if ($delete_blog) {
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

    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function blogManagementList(Request $request)
    {
        $data['status'] = $status = $request->status ?? '';
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('') . "/api/blog?sort=$sortField&direction=$sortDirection&status=$status&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['blogs']), false);
            $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            // $data->setPath(request()->url())->appends(['limit' => $perPage,'sort' => $sortField,'direction'=>$sortDirection,'status'=>$status,'keyword'=>$keyword]);
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
        return view('admin.blogs.list', compact('data'));
    }

    public function blogManagementAdd(BlogRequest $request)
    {

        if ($request->isMethod('POST')) {
            if ($request->ajax()) {
                $data = $request->except('_token');
                // Validate form
                $myCustomAttributes = [
                    'title' => 'required',
                    'author' => 'required',
                    'short_desc' => 'required',
                    'description' => 'required',
                    'main_img' => 'required',
                ];
                $validator = Validator::make($data, [
                    // 
                    'title.required' => 'Không được bỏ trống tiêu đề!',
                    'author.required' => 'Không được bỏ trống tác giả!',
                    'short_desc.required' => 'Không được bỏ trống miêu tả ngắn!',
                    'description.required' => 'Mô tả blog không được trống',
                    'main_img.required' => 'Không được bỏ trống ảnh!',
                ], [], [], $myCustomAttributes);


                // kiểm tra lỗi

                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors' => $myCustomAttributes, 422]);
                }
                $response = Http::post(url('') . '/api/blog-store', $data);
                // Kiểm tra kết quả từ API và trả về response tương ứng
                if ($response->successful()) {
                    return response()->json(['success' => true, 'message' => 'Thêm mới bài viết thành công', 'status' => 200]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Lỗi khi thêm mới bài viết', 'status' => 500]);
                }
            }
        }
        ;
        return view('admin.blogs.add');
    }

    public function blogManagementEdit(BlogRequest $request, $id)
    {
        $response = Http::get(url('') . '/api/blog-show/' . $request->id)['data']['blog'];
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put(url('') . '/api/blog-edit/' . $id, $data);
            // Kiểm tra kết quả từ API và trả về response tương ứng
            if ($response->successful()) {
                return response()->json(['success' => true, 'message' => 'Cập nhật bài viết thành công', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật bài viết', 'status' => 500]);
            }
        }
        return view('admin.blogs.edit', compact('response'));
    }

    public function blogManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get(url('') . '/api/blog-show/' . $request->id)['data']['blog'];
        $html = view('admin.blogs.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }

    public function blogManagementTrash(Request $request)
    {
        $data = Blog::onlyTrashed()->get();
        $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.blogs.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function blogManagementRestore($id)
    {

        if ($id) {
            $data = Blog::withTrashed()->find($id);
            if ($data) {
                $data->restore();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Khôi phục blog không thành công']);
    }
}
