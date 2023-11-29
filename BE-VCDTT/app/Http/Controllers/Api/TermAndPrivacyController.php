<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermAndPrivacyRequest;
use App\Http\Resources\TermAndPrivacyResource;
use App\Models\TermAndPrivacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TermAndPrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $existingTerm = TermAndPrivacy::where('type', 1)->first();
        if (!$existingTerm) {
            $dataTerm = [
                'title'=> 'Điều khoản và dịch vụ bản mẫu',
                'content'=> 'Nội dung điều khoản bản mẫu',
                'type'=> '1',
                'status' => '2',
            ]; 
            TermAndPrivacy::create($dataTerm);
        }
        $existingPrivacy = TermAndPrivacy::where('type', 2)->first();
        if (!$existingPrivacy) {
            $dataPrivacy = [
                'title'=> 'Điều khoản bảo mật thông tin bản mẫu',
                'content'=> 'Nội dung điều khoản bảo mật thông tin bản mẫu',
                'type'=> '2',
                'status' => '2',
            ]; 
            TermAndPrivacy::create($dataPrivacy);
        }
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if(!$request->searchCol){
            $page = TermAndPrivacy::where(function($query) use ($keyword) {
                $columns = Schema::getColumnListing((new TermAndPrivacy())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->orderBy($request->sort??'created_at',$request->direction??'desc')->get();
        }else{
            $page = TermAndPrivacy::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->orderBy($request->sort??'created_at',$request->direction??'desc')->get();
        }
        $term = TermAndPrivacy::where('type', '=','1')->get();
        $privacy = TermAndPrivacy::where('type', '=','2')->get();
        return response()->json(
            [
                'data' => [
                    'pages' => TermAndPrivacyResource::collection($page),
                    'term'=> TermAndPrivacyResource::collection($term),
                    'privacy'=> TermAndPrivacyResource::collection($privacy),


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
        
        $newPage = TermAndPrivacy::create($request->all());

        if($newPage->id) {
            return response()->json(
                [
                    'data' => [
                        'page' => new TermAndPrivacyResource($newPage)
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
        $page = TermAndPrivacy::withTrashed()->find($id);

        if (!$page) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
        return response()->json([
            'data' => [
                'page' => new TermAndPrivacyResource($page)

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
        $page = $request->all();
        $updatePage = TermAndPrivacy::where('id', $id)->update($request->except('_token','_method'));
        $page = TermAndPrivacy::find($id);
        if ($updatePage) {
            return response()->json([
                'data' => [
                    'page' => $page
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
        $page = TermAndPrivacy::find($id);

        if($page) {
            $deletePage = $page->delete();
            if (!$deletePage) {
                return response()->json(['message' => 'internal server error', 'status' => 500]);
            }
            return response()->json(['message' => 'OK', 'status' => 200]);
        }else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }



// ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function pageManagementList(Request $request) {
        $data['sortField']=$sortField = $request->sort??'';
        $data['sortDirection']=$sortDirection = $request->direction??'';
        $data['searchCol']=$searchCol = $request->searchCol??'';
        $data['keyword']=$keyword = $request->keyword??'';
        $response = Http::get(url('')."/api/page?sort=$sortField&direction=$sortDirection&searchCol=$searchCol&keyword=$keyword");
        if($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['pages']), false);
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
        return view('admin.term_and_privacy.list', compact('data'));
    }
    
    
    public function pageManagementAdd(TermAndPrivacyRequest $request) {
        $data = $request->except('_token');
        if ($request->isMethod('POST')) {
            $response = Http::post(url('').'/api/page-store', $data);
            if ($response->status() == 200) {
                return redirect()->route('page.list')->with('success', 'Thêm mới page thành công');
            } else {
                return redirect()->route('page.add')->with('fail', 'Đã xảy ra lỗi');
            }
        };
        return view('admin.term_and_privacy.add');
    }

    public function pageManagementEdit(TermAndPrivacyRequest $request, $id) {
        $response = json_decode(json_encode(Http::get(url('').'/api/page-show/' . $request->id)['data']['page']));
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put(url('').'/api/page-edit/' . $id, $data);
            if ($response->status() == 200) {
                return redirect()->route('page.list')->with('success', 'Cập nhật page thành công');
            } else {
                return redirect()->route('page.edit', ['id' => $id])->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.term_and_privacy.edit', compact('response'));
    }
    
    public function pageManagementDetail(Request $request) {
        $data = $request->except('_token');
        $response = Http::get(url('').'/api/page-show/'.$request->id);
        if($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['page']), false);
            $html = view('admin.term_and_privacy.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }

    public function pageManagementTrash(Request $request) {
        $data = TermAndPrivacy::onlyTrashed()->get();
        $perPage = $request->limit??5;// Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.term_and_privacy.trash', compact('data'));
    }
    
        // khôi phục bản ghi bị xóa mềm
    
    public function pageManagementRestore($id) {

        if($id) {
            $data = TermAndPrivacy::withTrashed()->find($id);
            if($data) {
                if($data->type == 1 || $data->type == 2){
                    $item = TermAndPrivacy::where('deleted_at', null)->where('type',$data->type)->first();
                    if($item){
                        $update = $data->toArray();
                        $item->update($update);
                        $this->destroyForever($id);
                    }
                    else{
                        $data->restore();
                    }
                }
                else{
                    $data->restore();
                }
            }
            return redirect()->route('page.trash')->with('success', 'Khôi phục page thành công');
        }
        return redirect()->route('page.trash');
    }

    public function destroyForever(string $id)
    {
        $term = TermAndPrivacy::withTrashed()->find($id);
        if ($term) {
            $delete_term =  $term->forceDelete();
            if ($delete_term) {
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

}
