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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KeyValueRequest $request, string $id)
    {
        $input = $request->only('value');

        $keyvalue = KeyValue::find($id);
        if (!$keyvalue) {
            return response()->json(['message' => "Edit fail, can't find your keyvalues ", 'status' => 500]);
        }

        $keyvalue->fill($input);

        if ($keyvalue->save()) {
            $updatedKeyValue = KeyValue::find($id);
            return response()->json(['message' => 'Edit success', 'status' => 200, 'object' => $updatedKeyValue]);
        } else {
            return response()->json(['message' => 'Edit fail', 'status' => 500]);
        }
    }

    public function updateAll(KeyValueRequest $request)
    {
        //
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
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/keyvalue' . $request->id);
        $data = json_decode(json_encode($response->json()['data']), false);
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put('http://be-vcdtt.datn-vcdtt.test/api/keyvalue-edit-all' . $data);
            if ($response->status() == 200) {
                return redirect()->route('settings')->with('success', 'Cập nhật thành công');
            } else {
                return redirect()->route('settings')->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.keyvalue.setting', compact('data'));
    }
}
