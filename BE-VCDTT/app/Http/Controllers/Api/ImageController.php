<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Tour;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Expr\FuncCall;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $data = Image::orderBy('created_at', 'desc')
                        ->get();
        foreach($data as $item){
            if($item->tour_id){
                    $item->tour_name = Tour::withTrashed()->find($item->tour_id) ? Tour::withTrashed()->find($item->tour_id)->name : '';
            } else {
                $item->tour_name = 'Ảnh tự do';
            }
        }
        $perPage= $request->limit??5;// Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.images.list', compact('data'));
    }
    public function trash(Request $request)
    {

        $data = Image::onlyTrashed()->get();
        foreach($data as $item){
            if($item->tour_id){
                $item->tour_name = Tour::find($item->tour_id)->name;
            } else {
                $item->tour_name = 'Ảnh tự do';
            }
        }
        $perPage= $request->limit??5;// Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);

        return view('admin.images.trash', compact('data'));
    }

    public function restore($id)
    {

        if ($id) {
            $data = Image::withTrashed()->find($id);
            if ($data) {
                $data->restore();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Khôi phục ảnh không thành công']);
    }

    public function destroyForever(string $id)
    {
        $image = Image::withTrashed()->find($id);
        if ($image) {
            $delete_image = $image->forceDelete();
            if ($delete_image) {
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

    public function download(Request $request, $id)
    {
        $image = Image::find($id);
        if($image){
            return Response::download(public_path(str_replace(url('').'/', '', $image->url)), $image->name.'.'.$image->type, ['Content-Type: image/jpeg']);
        }
        else{
            // image not found -> 404
        }
    }

    public function bannerCall(Request $request)
    {
        $banner = Image::select('id','url','created_at','updated_at')->where('banner_id',1)->get();
        if($banner){
            return response()->json([
                'data' => [
                    'banner' => ImageResource::collection($banner),
                ],
                'message' => 'OK',
                'status' => 200
            ],);
        }
    }


    public function destroy(string $id)
    {
        $image = Image::find($id);
        if ($image) {
            $delete_img = $image->delete();
            if($delete_img) {
                $parsedUrl = parse_url($image->url);
                $path = ltrim($parsedUrl['path'], '/');
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
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

    public function imageList(Request $request)
    {
        $images = Image::orderBy('created_at', 'desc')->get();
        $data = ImageResource::collection($images);
        $html = view('admin.tours.detail_image', compact('data'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }
    public function imageShow(Request $request)
    {
        $data = $request->query('imageValue');
        $html = view('admin.images.show', compact('data'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }
    public function bannerEdit(Request $request)
    {
        $images = Image::orderBy('created_at', 'desc')->get();
        $dataImages = ImageResource::collection($images);
        $banners = Image::select('url')->whereNotNull('banner_id')->orderBy('updated_at', 'desc')->get();
        $data = json_decode(json_encode($banners, false));
        if ($request->id) {
            $check = Image::where('id',$request->id)->first();
            if($check->banner_id==""){
                Image::where('id', $request->id)->update(['banner_id' => 1]);
            }else{
                Image::where('id', $request->id)->update(['banner_id' => null]);
            }
        }
        $html = view('admin.images.banner_edit', compact('dataImages','data'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }
    public function dropzone(){
        $tours = Tour::select('name','id')->orderBy('created_at', 'desc')->get();
        return view('admin.images.dropzone', compact('tours'));
    }
}
