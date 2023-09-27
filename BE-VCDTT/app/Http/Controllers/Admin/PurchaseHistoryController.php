<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PurchaseHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseHistoryResource;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        //
        $user = PurchaseHistory::all();
        return PurchaseHistoryResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = PurchaseHistory::create($request->all());
        return new PurchaseHistoryResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = PurchaseHistory::find($id);
        if($user){
            return new PurchaseHistoryResource($user);
        }else{
            return response()->json(['message'=>'User không tồn tại'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = PurchaseHistory::find($id);
        if($user){
            $user->update($request->all());
        }else{
            return response()->json(['message'=>"User không tồn tại"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = PurchaseHistory::find($id);
        if($user){
            $user->delete();
            return response()->json(['message'=>"Xóa thành công"],200);
        }else{
            return response()->json(['message'=>"User không tồn tại"],404);
        }
    }
}
