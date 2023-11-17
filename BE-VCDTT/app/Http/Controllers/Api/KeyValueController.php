<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KeyValueRequest;
use App\Http\Resources\KeyValueResource;
use App\Models\KeyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class KeyValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyvalues = KeyValue::all();
        return response()->json([
            'data' => [
                'keyvalues' => KeyValueResource::collection($keyvalues),
            ],
            'message' => 'OK',
            'status' => 200
        ],);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($key)
    {
        $keyvalue = KeyValue::where('key',$key)->get();
        return response()->json([
            'data' => [
                'keyvalue' => KeyValueResource::collection($keyvalue),
            ],
            'message' => 'OK',
            'status' => 200
        ],);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KeyValueRequest $request, string $id)
    {
//
    }

    public function updateAll(KeyValueRequest $request)
    {
        $data = $request->all();
        if ($data!=[]) {
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    KeyValue::where('key', $key)->update(['value' => $value]);
                }
            }
            return response()->json(['message' => 'Edit success', 'status' => 200]);
        } else {
            return response()->json(['message' => 'Edit fail', 'status' => 500]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // ==================================================== Nhóm function CRUD trên blade admin ===========================================

    public function keyvalueManagementEditAll(KeyValueRequest $request)
    {
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/keyvalue');
        $data = json_decode(json_encode($response->json()['data']['keyvalues']), false);
        $images=[];
        foreach ($data as $item){
            $item->key=='logo'?$images['logo'] = $item->value:'';
            $item->key=='favicon'?$images['favicon'] = $item->value:'';
            $item->key=='banner'?$images['banner'] = $item->value:'';
        }
        if ($request->isMethod('POST')) {
            $dataInsert = $request->except('_token', 'btnSubmit');
            foreach($images as $key => $value ){
                if($request->hasFile($key) && $request->file($key)->isValid()){
                    $value!=''?Storage::delete('/public/'. $value ):'';
                    $dataInsert[$key] = upLoadFile('images',$request->file($key));
                }else{
                    $dataInsert[$key] =  $value;
                }
            }

            $response = Http::post('http://be-vcdtt.datn-vcdtt.test/api/keyvalue-edit-all', $dataInsert);
            if ($response->status() == 200) {
                return redirect()->route('settings')->with('success', 'Cập nhật thành công');
            } else {
                return redirect()->route('settings')->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.keyvalue.setting', compact('data'));
    }
}
