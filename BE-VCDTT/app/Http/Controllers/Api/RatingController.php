<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Http\Resources\TourResource;
use App\Models\PurchaseHistory;
use App\Models\Rating;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $listRatings = Rating::where('tour_id',$request->id)->orderBy('updated_at', 'desc')->get();
        $tour = Tour::find($request->id);
        return response()->json(
            [
                'data' => [
                    'ratings' => new RatingResource($listRatings),
                    'tour' => new TourResource($tour)
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    public function indexAll()
    {
        $listRatings = Rating::orderBy('created_at', 'desc')->get();
        return response()->json(
            [
                'data' => [
                    'ratings' => new RatingResource($listRatings),
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RatingRequest $request)
    {
        $check = PurchaseHistory::where('tour_id',$request->tour_id)->where('user_id',$request->user_id)->orderBy('id','desc')->first();
        if($check->purchase_status == 5){
            if($request->star){
            $newRating = Rating::create($request->all());
            if($newRating->id) {
            $purchaseHistory = PurchaseHistory::find($check->id);
            $input['purchase_status'] = 10; // Đã đi xong -> đã đánh giá
            $purchaseHistory->fill($input);
            $purchaseHistory->save();
            return response()->json(
                [
                    'data' => [
                        'rating' => new RatingResource($newRating)
                    ],
                    'message' => 'Đánh giá thành công',
                    'status' => 200
                ]
            );
        }else{
            return response()->json([
                'message' => 'Lỗi hệ thống',
                'status' => 500
            ]);
        }
    }else{
        return response()->json(
            [
                'data' => [
                    'purchase_status' => $check->purchase_status
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }
        }else if($check->purchase_status == 10){
            return response()->json([
                'message' => 'Bạn đã đánh giá tour này, vui lòng đi lại tour',
                'status' => 500
            ]);
        }else {
            return response()->json([
                'data' => [
                    'purchase_status' => $check->purchase_status
                ],
                'message' => 'Bạn chưa đi tour này',
                'status' => 404
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
        return response()->json([
            'data' => [
                'rating' => new RatingResource($rating)

            ],
            'message' => 'OK',
            'status' => 200,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RatingRequest $request, string $id)
    {
        $input = $request->all();
        $rating = Rating::find($id);
        if (!$rating) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
        $rating->update($input);
            if ($rating->id) {
                return response()->json([
                    'data' => [
                        'rating' => new RatingResource($rating)
                    ],
                    'message' => 'Edit success',
                    'status' => 200
                ]);
            } else {
                return response()->json(['message' => 'Edit fail, internal server error', 'status' => 500]);
            }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $rating = Rating::find($id);

        if($rating) {
            $deleteRating = $rating->delete();
            if (!$deleteRating) {
                return response()->json(['message' => 'internal server error', 'status' => 500]);
            }
            return response()->json(['message' => 'OK', 'status' => 200]);
        }else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

     // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function allRatingManagementList(Request $request) {
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/rating');
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['ratings']), false);

            $perPage= $request->limit??5;// Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url())->appends(['limit' => $perPage]);

        }else{
            $data = [];
        }
        return view('admin.ratings.list_all', compact('data'));
    }


    public function ratingManagementList(Request $request) {

        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/rating/'.$request->id);
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']), false);
            $perPage= $request->limit??5;// Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data->ratings);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data->ratings = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->ratings->setPath(request()->url())->appends(['limit' => $perPage]);
        }else{
            $data = [];

        }
        return view('admin.ratings.list', compact('data'));
    }

    public function ratingManagementAdd() {
        return view('admin.ratings.add');
    }

    public function ratingManagementEdit(Request $request) {
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/rating-show/'.$request->id);
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['rating']), false);
            return view('admin.ratings.edit', compact('data'));
        }
    }

    public function ratingManagementDetail(Request $request) {
        $data = $request->except('_token');
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/rating-show/'.$request->id);
        if($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['rating']), false);
            $html = view('admin.ratings.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }


}
