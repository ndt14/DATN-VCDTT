<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Http\Resources\WishListResource;
use App\Models\Rating;
use App\Models\Tour;
use App\Models\WishList;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listWish = WishList::where('tour_id', $request->tour_id)->where('user_id', $request->user_id)->orderBy('id', 'desc')->get();
        return response()->json(
            [
                'data' => [
                    'listWish' => new WishListResource($listWish),
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    public function indexAll(Request $request)
    {
        $listWish = WishList::select('tour_id')->where('user_id', $request->id)->get();
        $listTour = Tour::whereIn('id', $listWish)->get();
        foreach ($listTour as $tour) {
            $listRatings = Rating::where('tour_id', $tour->id)->orderBy('id', 'desc')->get();
            $star = 0;
            $t = 0;
            foreach ($listRatings as $c) {
                $star += $c->star;
                $t++;
            }
            $tour->star = $star / ($t == 0 ? 1 : $t);
            $tour->starCount = $t;
        }
        return response()->json(
            [
                'data' => [
                    'tours' => new TourResource($listTour)
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $newWishList = WishList::create($request->all());
        // if($newWishList->id) {
        //     return response()->json(
        //         [
        //             'data' => [
        //                 'wishList' => new WishListResource($newWishList)
        //             ],
        //             'message' => 'Đã thích',
        //             'status' => 200
        //         ]
        //     );
        // }else {
        //     return response()->json([
        //         'message' => 'Lỗi hệ thống',
        //         'status' => 500
        //     ]);
        //}

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $wishList = WishList::where('tour_id',$id);
        // if (!$wishList) {
        //     return response()->json(['message' => '404 Không tìm thấy', 'status' => 404]);
        // }
        // return response()->json([
        //     'data' => [
        //         'wishList' => new WishListResource($wishList)

        //     ],
        //     'message' => 'OK',
        //     'status' => 200,
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        // $wishList = WishList::find($id);

        // if($wishList) {
        //     $deleteWishList = $wishList->delete();
        //     if (!$deleteWishList) {
        //         return response()->json(['message' => 'Lỗi hệ thống', 'status' => 500]);
        //     }
        //     return response()->json(['message' => 'Đã hủy thích', 'status' => 200]);
        // }else {
        //     return response()->json(['message' => '404 Không tìm thấy', 'status' => 404]);
        // }
    }

    public function useWishList(Request $request)
    {
        $wishList = WishList::where('tour_id', $request->tour_id)->where('user_id', $request->user_id)->first();
        if (!$wishList) {
            $newWishList = WishList::create($request->all());
            if ($newWishList->id) {
                return response()->json(
                    [
                        'data' => [
                            'wishList' => new WishListResource($newWishList)
                        ],
                        'message' => 'Đã thích',
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
            if ($wishList) {
                $deleteWishList = $wishList->delete();
                if (!$deleteWishList) {
                    return response()->json(['message' => 'Lỗi hệ thống', 'status' => 500]);
                }
                return response()->json(['message' => 'Đã hủy thích', 'status' => 200]);
            } else {
                return response()->json(['message' => '404 Không tìm thấy', 'status' => 404]);
            }
            return response()->json(['message' => 'Thích', 'status' => 200]);
        }
    }
}
