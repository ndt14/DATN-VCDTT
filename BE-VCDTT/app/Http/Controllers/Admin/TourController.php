<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tour;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tour = Tour::all();
        return TourResource::collection($tour);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tour = Tour::create($request->all());
        return new TourResource($tour);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $tour = Tour::find($id);
        if($tour){
            return new TourResource($tour);
        }else{
            return response()->json(['message'=>'Tour không tồn tại'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $tour = Tour::find($id);
        if($tour){
            $tour->update($request->all());
        }else{
            return response()->json(['message'=>"Tour không tồn tại"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tour = Tour::find($id);
        if($tour){
            $tour->delete();
            return response()->json(['message'=>"Xóa thành công"],200);
        }else{
            return response()->json(['message'=>"Tour không tồn tại"],404);
        }
    }
}
