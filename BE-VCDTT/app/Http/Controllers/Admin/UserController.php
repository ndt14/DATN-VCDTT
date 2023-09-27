<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
   public function index()
    {
        //
        $user = User::all();
        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        if($user){
            return new UserResource($user);
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
        $user = User::find($id);
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
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json(['message'=>"Xóa thành công"],200);
        }else{
            return response()->json(['message'=>"User không tồn tại"],404);
        }
    }
}
