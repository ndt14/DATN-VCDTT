<?php

namespace App\Http\Controllers\Api;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FAQRequest;
use App\Http\Resources\FAQResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        //
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if(!$request->searchCol){
            $faqs = FAQ::where(function($query) use ($keyword) {
                $columns = Schema::getColumnListing((new FAQ())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->orderBy($request->sort??'created_at',$request->direction??'desc')->get();
        }else{
            $faqs = FAQ::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->orderBy($request->sort??'created_at',$request->direction??'desc')->get();
        }
        return response()->json(
            [
                'data' => [
                    'faqs' => FAQResource::collection($faqs)
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
        $faq = FAQ::withTrashed()->find($id);

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

    public function destroyForever(string $id)
    {
        $faq = FAQ::withTrashed()->find($id);
        if ($faq) {
            $delete_faq =  $faq->forceDelete();
            if ($delete_faq) {
                return response()->json(['message' => 'Xóa thành công', 'status' => 200]);
            } else {
                return response()->json([
                    'message' => 'internal server error',
                    'status' => 500
                ]);
            }
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 500]);
        }
    }


    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function faqManagementList(Request $request) {
        $data['sortField']=$sortField = $request->sort??'';
        $data['sortDirection']=$sortDirection = $request->direction??'';
        $data['searchCol']=$searchCol = $request->searchCol??'';
        $data['keyword']=$keyword = $request->keyword??'';
        $response = Http::get(url('')."/api/faq?sort=$sortField&direction=$sortDirection&searchCol=$searchCol&keyword=$keyword");
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['faqs']), false);
            $perPage = $request->limit??5;// Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url());
            $request->limit?$data->setPath(request()->url())->appends(['limit' => $perPage]):'';
            $request->sort&&$request->direction?$data->setPath(request()->url())->appends(['sort' => $sortField,'direction'=>$sortDirection]):'';
            $request->searchCol?$data->setPath(request()->url())->appends(['searchCol'=>$searchCol]):'';
            $request->keyword?$data->setPath(request()->url())->appends(['keyword'=>$keyword]):'';
            if($data->currentPage()>$data->lastPage()){
                return redirect($data->url(1));
            }
        }else{
            $data = [];
        }
        return view('admin.faqs.list', compact('data'));
}


    public function faqManagementAdd(FAQRequest $request) {
        $data = $request->except('_token');
        if ($request->isMethod('POST')) {
            $response = Http::post(url('').'/api/faq-store', $data);
            if ($response->status() == 200) {
                return redirect()->route('faq.list')->with('success', 'Thêm mới faq thành công');
            } else {
                return redirect()->route('faq.add')->with('fail', 'Đã xảy ra lỗi');
            }
        };
        return view('admin.faqs.add');
    }

    public function faqManagementEdit(FAQRequest $request, $id) {
        $response = json_decode(json_encode(Http::get(url('').'/api/faq-show/' . $request->id)['data']['faq']));
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put(url('').'/api/faq-edit/' . $id, $data);
            if ($response->status() == 200) {
                return redirect()->route('faq.list')->with('success', 'Cập nhật faq thành công');
            } else {
                return redirect()->route('faq.edit', ['id' => $id])->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.faqs.edit', compact('response'));
    }

    public function faqManagementDetail(Request $request) {
        $data = $request->except('_token');
        $response = Http::get(url('').'/api/faq-show/'.$request->id);
        if($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['faq']), false);
            $html = view('admin.faqs.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }

    public function faqManagementTrash(Request $request) {
        $data = FAQ::onlyTrashed()->get();
        $perPage = $request->limit??5;// Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.faqs.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function faqManagementRestore($id) {

        if($id) {
            $data = FAQ::withTrashed()->find($id);
            if($data) {
                $data->restore();
            }
            return redirect()->route('faq.trash')->with('success', 'Khôi phục faq thành công');
        }
        return redirect()->route('faq.trash');
    }

}
