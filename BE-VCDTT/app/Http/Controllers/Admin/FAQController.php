<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FAQResource;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    public function index()
    {
        //
        $listFaqs = FAQ::all();
        return FAQResource::collection($listFaqs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                'answer' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $newFaq = FAQ::create($request->all());
            return new FAQResource($newFaq);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $faq = FAQ::find($id);

        if (!$faq) {
            return response()->json(['message' => '404 Not Found', 'statusCode' => 404]);
        }
        return response()->json(['message' => 'ok', 'statusCode' => 200, 'object' => new FAQResource($faq)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $validator = Validator::make(
            $request->all(),
            [
                'question' => 'required',
                'answer' => 'required',
            ]
        );

        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()], 400);
        } else {

            $updateFaq = FAQ::where('id', $id)->update($request->except('_token'));
            $faq = FAQ::find($id);
            if ($updateFaq) {
                return response()->json(['message' => 'Cập nhật faq thành công', 'statusCode' => 200, 'object' => $faq]);
            } else {
                return response()->json(['message' => 'Cập nhật tour thất bại'], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $faq = FAQ::find($id);
        $deleteFaq = $faq->delete();
        if (!$deleteFaq) {
            return response()->json(['message' => '404 Not Found', 'statusCode' => 404]);
        }
        return response()->json(['message' => 'ok', 'statusCode' => 200]);
    }
}
