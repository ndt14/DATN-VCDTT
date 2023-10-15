<?php

namespace App\Http\Controllers\Api;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FAQRequest;
use App\Http\Resources\FAQResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    public function index()
    {
        //
        $listFaqs = FAQ::orderBy('updated_at', 'desc')->get();
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
        $newFaq = FAQ::create($request->all());
        if($newFaq->id) {
            return response()->json(
                [
                    'data' => [
                        'faq' => new FAQResource($newFaq)
                    ],
                    'message' => 'Add success',
                    'status' => 200
                ]
            );
        }else {
            return response()->json([
                'message' => 'internal server error',
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
        $faq = FAQ::find($id);

        if (!$faq) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
        return response()->json([
            'data' => [
                'faq' => new FAQResource($faq)

            ],
            'message' => 'OK', 
            'status' => 200, 
        ]);
    }

    // search faq
    // thực hiện tìm kiếm câu hỏi trong bảng faqs sử dụng chỉ mục và truy vấn full-text search

    public function search_faq(Request $request)
{
    $question = $request->query('question');

    $results = FAQ::where('question','LIKE',"%$question%")->get();

    if(count($results) > 0) {
        return response()->json([
            'data' => [
                'faqs' => $results
            ],
            'message' => 'OK',
            'status' => 200
        ]);
    }else {
        return response()->json(['message' => '404 Not found', 'status' => 404]);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(FAQRequest $request, string $id)
    {
        //

            $faq = $request->all();
            $updateFaq = FAQ::where('id', $id)->update($request->except('_token','_method'));
            $faq = FAQ::find($id);
            if ($updateFaq) {
                return response()->json([
                    'data' => [
                        'faq' => $faq
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

        $faq = FAQ::find($id);
       
        if($faq) {
            $deleteFaq = $faq->delete();
            if (!$deleteFaq) {
                return response()->json(['message' => 'internal server error', 'status' => 500]);
            }
            return response()->json(['message' => 'OK', 'status' => 200]);
        }else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }


    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function faqManagementList() {

        $data = Http::get('http://be-vcdtt.datn-vcdtt.test/api/faq');
        if($data->status() == 200) {

            $data = json_decode(json_encode($data->json()['data']['faqs']), false);
            return view('admin.faqs.list', compact('data'));
        }else{
            $data = [];
            return view('admin.faqs.list', compact('data'));
        }
    }

    public function faqManagementAdd() {
        return view('admin.faqs.add');
    }

    public function faqManagementEdit(Request $request) {
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/faq-show/'.$request->id);
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['faq']), false);
            return view('admin.faqs.edit', compact('data'));
        }
    }

    public function faqManagementDetail(Request $request) {
        $data = $request->except('_token');
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/faq-show/'.$request->id);
        if($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['faq']), false);
            $html = view('admin.faqs.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }


}
