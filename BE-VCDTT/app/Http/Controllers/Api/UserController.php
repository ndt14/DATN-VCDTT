<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        //
        $listUsers = User::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'data' => [
                'users' => UserResource::collection($listUsers)
            ],
            'message' => 'OK',
            'status' => 200
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $newUser = User::create($request->all());
        if ($newUser->id) {
            return response()->json(
                [
                    'data' => [
                        'user' => new UserResource($newUser)
                    ],
                    'message' => 'Add success',
                    'status' => 200
                ]
            );
        } else {
            return response()->json([
                'message' => 'internal server error',
                'status' => 500
            ]);
        }
    }

    public function search_user(Request $request)
    {
        $user = $request->query('name');

        $results = User::where('name', 'LIKE', "%$user%")->get();

        if (count($results) > 0) {
            return response()->json([
                'data' => [
                    'users' => $results
                ],
                'message' => 'OK',
                'status' => 200
            ]);
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
        return response()->json([
            'data' => [
                'user' => new UserResource($user)
            ],
            'message' => 'OK',
            'status' => 200
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $data = $request->except('_token', '_method');

        if (!$user) {
            return response()->json(['message' => 'User not found', 'status' => 404]);
        }

        if (empty($data['password'])) {
            $data['password'] = $user->password;
        }
        $user->update($data);

        return response()->json([
            'data' => [
                'user' => $user
            ],
            'message' => 'Edit success',
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);

        if ($user) {
            $deleteUser = $user->delete();
            if (!$deleteUser) {
                return response()->json(['message' => 'internal server error', 'status' => 500]);
            }
            return response()->json(['message' => 'OK', 'status' => 200]);
        } else {
            return response()->json(['message' => '404 Not found', 'status' => 404]);
        }
    }


    // ## ============================================ NHÓM HÀM CHO CRUD USER TRONG BLADE ADMIN ==================================

    public function userManagementList()
    {

        $data = Http::get('http://be-vcdtt.datn-vcdtt.test/api/user');
        if ($data->status() == 200) {
            $data = json_decode(json_encode($data->json()['data']['users']), false);
            return view('admin.users.list', compact('data'));
        } else {
            $data = [];
            return view('admin.users.list', compact('data'));
        }
    }

    public function userManagementEdit(UserRequest $request, $id)
    {
        $response = json_decode(json_encode(Http::get('http://be-vcdtt.datn-vcdtt.test/api/user-show/' . $request->id)['data']['user']));
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put('http://be-vcdtt.datn-vcdtt.test/api/user-edit/' . $id, $data);
            if ($response->status() == 200) {
                return redirect()->route('user.list')->with('success', 'Cập nhật user thành công');
            } else {
                return redirect()->route('user.edit', ['id' => $id])->with('fail', 'Đã xảy ra lỗi');
            }
        }
        return view('admin.users.edit', compact('response'));
    }

    public function userManagementAdd(UserRequest $request)
    {
        $data = $request->except('_token');
        if ($request->isMethod('POST')) {
            $response = Http::post('http://be-vcdtt.datn-vcdtt.test/api/user-store', $data);
            if ($response->status() == 200) {
                return redirect()->route('user.list')->with('success', 'Thêm mới người dùng thành công');
            } else {
                return redirect()->route('user.add')->with('fail', 'Đã xảy ra lỗi');
            }
        }

        return view('admin.users.add');
    }

    public function userManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get('http://be-vcdtt.datn-vcdtt.test/api/user-show/' . $request->id)->json()['data']['user'];
        $html = view('admin.users.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }
}
