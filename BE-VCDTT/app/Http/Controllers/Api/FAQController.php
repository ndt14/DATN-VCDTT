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
        if($newFaq->id) {
            return response()->json(
                [
                    'data' => [
                        'faq' => new FAQResource($newFaq)
                    ],
                    'message' => 'OK',
                    'status' => 201
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
                return response()->json(['message' => 'internal server error', 'status' => 500]);
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

    public function faqManagementAddAction(FAQRequest $request) {

        $data = $request->except('_token');
        $response = Http::post('http://be-vcdtt.datn-vcdtt.test/api/faq-store', $data);
        if($response->status() == 200) {
            return redirect()->route('faq.list')->with('success', 'Thêm faq thành công');
        }
        return redirect()->route('faq.list')->with('fail', 'Có lỗi xảy ra');
    }

    public function faqManagementEdit($id) {
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/faq-show/'.$id);
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['faq']), false);
            return view('admin.faqs.update', compact('data'));
        }
    }

    public function faqManagementEditAction(FAQRequest $request) {

            $data = $request->except('_token','btnSubmit');
            $response = Http::put('http://be-vcdtt.datn-vcdtt.test/api/faq-edit/'.$request->id, $data);
            if($response->status() == 200) {
                return redirect()->route('faq.edit', ['id' => $request->id])->with('success', 'Cập nhật faq thành công');
            }
            return redirect()->route('faq.edit', ['id' => $request->id])->with('success', 'Có lỗi xảy ra');
    }

    public function faqManagementDelete($id) {

        $response = Http::delete('http://be-vcdtt.datn-vcdtt.test/api/faq-destroy/'.$id);

        if($response->status() == 200) {

            return redirect()->route('faq.list')->with('success', 'Xóa faq thành công');
        }

        return redirect()->route('faq.list')->with('fail', 'Có lỗi xảy ra');
    }
}
