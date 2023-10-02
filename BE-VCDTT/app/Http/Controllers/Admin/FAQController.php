<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FAQRequest;
use App\Http\Resources\FAQResource;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    public function index()
    {
        //
        $listFaqs = FAQ::all();
        return response()->json(
            [
                'data' => [
                    'faqs' => FAQResource::collection($listFaqs)
                ],
                'message' => 'OK',
                'status' => 200
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FAQRequest $request)
    {
    
        $faq = $request->all();
        $newFaq = FAQ::create($faq);
        return response()->json(
            [
                'data' => [
                    'faq' => new FAQResource($newFaq)
                ],
                'message' => 'OK',
                'status' => 201
            ]
        );
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $faq = FAQ::find($id);

        if (!$faq) {
            return response()->json(['message' => '404 Not Found', 'status' => 404]);
        }
        return response()->json([
            'data' => [
                'faq' => new FAQResource($faq)

            ],
            'message' => 'ok', 
            'status' => 200, 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FAQRequest $request, string $id)
    {
        //

            $faq = $request->all();
            $updateFaq = FAQ::where('id', $id)->update($request->except('_token'));
            $faq = FAQ::find($id);
            if ($updateFaq) {
                return response()->json([
                    'data' => [
                        'faq' => $faq
                    ],
                    'message' => 'OK',
                     'status' => 200
                ]);
            } else {
                return response()->json(['message' => 'noSuccess', 'status' => 500]);
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
            return response()->json(['message' => '404 Not Found', 'status' => 404]);
        }
        return response()->json(['message' => 'OK', 'status' => 200]);
    }
}
