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

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $data = Image::select('images.*','tours.name as tour_name')
                        ->join('tours', 'tours.id', '=', 'images.tour_id')
                        ->orderBy('images.created_at', 'desc')
                        ->get();

        $perPage= $request->limit??5;// Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);

        return view('admin.images.list', compact('data'));
    }
    public function download(Request $request, $id)
    {
        $image = Image::find($id);
        if($image){
            return Response::download(public_path($image->url), $image->name.'.'.$image->type, ['Content-Type: image/jpeg']);
        }
        else{
            // image not found -> 404
        }
    }

    public function destroy(string $id)
    {
        $image = Image::find($id);
        if ($image) {
            $delete_img = $image->delete();
            if($delete_img) {
                if (File::exists(public_path($image->url))) {
                    File::delete(public_path($image->url));
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
        $images = Image::all();
        $data = ImageResource::collection($images);
        $html = view('admin.tours.detail_image', compact('data'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }
}
