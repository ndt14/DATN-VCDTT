<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FAQResource;

class FAQController extends Controller
{
   public function index()
    {
        //
        $faq = FAQ::all();
        return FAQResource::collection($faq);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $faq = FAQ::create($request->all());
        return new FAQResource($faq);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $faq = FAQ::find($id);
        if($faq){
            return new FAQResource($faq);
        }else{
            return response()->json(['message'=>'FAQ không tồn tại'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $faq = FAQ::find($id);
        if($faq){
            $faq->update($request->all());
        }else{
            return response()->json(['message'=>"FAQ không tồn tại"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $faq = FAQ::find($id);
        if($faq){
            $faq->delete();
            return response()->json(['message'=>"Xóa thành công"],200);
        }else{
            return response()->json(['message'=>"FAQ không tồn tại"],404);
        }
    }
}
