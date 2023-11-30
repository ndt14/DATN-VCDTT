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
use Illuminate\Support\Facades\Schema;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if (!$request->searchCol) {
            $ratings = Rating::where(function ($query) use ($keyword) {
                $columns = Schema::getColumnListing((new Rating())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->where('tour_id', $request->id)->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        } else {
            $ratings = Rating::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('tour_id', $request->id)->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        }
        $tour = Tour::find($request->id);
        return response()->json(
            [
                'data' => [
                    'ratings' => new RatingResource($ratings),
                    'tour' => new TourResource($tour)
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    public function indexAll(Request $request)
    {
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if (!$request->searchCol) {
            $ratings = Rating::where(function ($query) use ($keyword) {
                $columns = Schema::getColumnListing((new Rating())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        } else {
            $ratings = Rating::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        }
        return response()->json(
            [
                'data' => [
                    'ratings' => RatingResource::collection($ratings),
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
        $check = PurchaseHistory::where('tour_id', $request->tour_id)->where('user_id', $request->user_id)->orderBy('id', 'desc')->first();
        if ($check->tour_status == 3) {
            if ($request->star) {
                $newRating = Rating::create($request->all());
                if ($newRating->id) {
                    $purchaseHistory = PurchaseHistory::find($check->id);
                    $input['tour_status'] = 1; // Đã đi xong -> đã đánh giá
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
                } else {
                    return response()->json([
                        'message' => 'Lỗi hệ thống',
                        'status' => 500
                    ]);
                }
            } else {
                return response()->json(
                    [
                        'data' => [
                            'purchase_status' => $check->tour_status
                        ],
                        'message' => 'OK',
                        'status' => 200
                    ]
                );
            }
        } elseif ($check->tour_status == 1) {
            return response()->json([
                'data' => [
                    'purchase_status' => $check->tour_status
                ],
                'message' => 'Bạn chưa đi tour này',
                'status' => 404
            ]);
        } else {
            return response()->json([
                'data' => [
                    'purchase_status' => $check->tour_status
                ],
                'message' => 'Bạn hoàn thành tour này',
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
        $rating = Rating::withTrashed()->find($id);

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

        if ($rating) {
            $deleteRating = $rating->delete();
            if (!$deleteRating) {
                return response()->json(['message' => 'internal server error', 'status' => 500]);
            }
            return response()->json(['message' => 'OK', 'status' => 200]);
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

    public function destroyForever(string $id)
    {
        $rating = Rating::withTrashed()->find($id);
        if ($rating) {
            $delete_rating =  $rating->forceDelete();
            if ($delete_rating) {
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

    public function allRatingManagementList(Request $request)
    {
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('')."/api/rating?sort=$sortField&direction=$sortDirection&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['ratings']), false);
            $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url());
            $request->limit ? $data->setPath(request()->url())->appends(['limit' => $perPage]) : '';
            $request->sort && $request->direction ? $data->setPath(request()->url())->appends(['sort' => $sortField, 'direction' => $sortDirection]) : '';
            $request->searchCol ? $data->setPath(request()->url())->appends(['searchCol' => $searchCol]) : '';
            $request->keyword ? $data->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->currentPage() > $data->lastPage()) {
                return redirect($data->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.ratings.list_all', compact('data'));
    }


    public function ratingManagementList(Request $request)
    {
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('').'/api/rating/' . $request->id . "?sort=$sortField&direction=$sortDirection&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']), false);
            $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data->ratings);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data->ratings = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->ratings->setPath(request()->url());
            $request->limit ? $data->ratings->setPath(request()->url())->appends(['limit' => $perPage]) : '';
            $request->sort && $request->direction ? $data->ratings->setPath(request()->url())->appends(['sort' => $sortField, 'direction' => $sortDirection]) : '';
            $request->searchCol ? $data->ratings->setPath(request()->url())->appends(['searchCol' => $searchCol]) : '';
            $request->keyword ? $data->ratings->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->ratings->currentPage() > $data->ratings->lastPage()) {
                return redirect($data->ratings->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.ratings.list', compact('data'));
    }

    public function ratingManagementAdd()
    {
        return view('admin.ratings.add');
    }

    public function ratingManagementEdit(Request $request)
    {
        $response = Http::get(url('').'/api/rating-show/' . $request->id);
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put(url('').'/api/rating-edit/' . $request->id, $data);
            if ($response->status() == 200) {
                return redirect()->route('rating.edit', ['id' => $request->id])->with('success', 'Cập nhật rating thành công');
            } else {
                return redirect()->route('rating.edit', ['id' => $request->id])->with('fail', 'Đã xảy ra lỗi');
            }
        }
        $data = json_decode(json_encode($response->json()['data']['rating']), false);
        return view('admin.ratings.edit', compact('data'));
    }

    public function ratingManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $response = Http::get(url('').'/api/rating-show/' . $request->id);
        if ($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['rating']), false);
            $html = view('admin.ratings.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }

    public function ratingManagementTrash(Request $request)
    {
        $data = Rating::onlyTrashed()->get();
        $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.ratings.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function ratingManagementRestore($id)
    {

        if ($id) {
            $data = Rating::withTrashed()->find($id);
            if ($data) {
                $data->restore();
            }
            return redirect()->route('rating.trash')->with('success', 'Khôi phục đánh giá thành công');
        }
        return redirect()->route('rating.trash');
    }
}
