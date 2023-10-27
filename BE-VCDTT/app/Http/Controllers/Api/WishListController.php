<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishListResource;
use App\Models\WishList;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listWishLists = WishList::where('user_id', $request->id)->orderBy('updated_at', 'desc')->get();
        return response()->json(
            [
                'data' => [
                    'wishLists' => new WishListResource($listWishLists)
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $wishList = WishList::find($id);

        if (!$wishList) {
            return response()->json(['message' => '404 Không tìm thấy', 'status' => 404]);
        }
        return response()->json([
            'data' => [
                'wishList' => new WishListResource($wishList)

            ],
            'message' => 'OK',
            'status' => 200,
        ]);
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

        $wishList = WishList::find($id);

        if ($wishList) {
            $deleteWishList = $wishList->delete();
            if (!$deleteWishList) {
                return response()->json(['message' => 'Lỗi hệ thống', 'status' => 500]);
            }
            return response()->json(['message' => 'Đã hủy thích', 'status' => 200]);
        } else {
            return response()->json(['message' => '404 Không tìm thấy', 'status' => 404]);
        }
    }
}
