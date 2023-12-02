<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Traits\HasRoles;

class UserController extends Controller
{
    use HasRoles;

    public function index(Request $request)
    {
        //
        $keyword = $request->keyword ? trim($request->keyword) : '';
        if (!$request->searchCol) {
            $users = User::where(function ($query) use ($keyword) {
                $columns = Schema::getColumnListing((new User())->getTable());
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            })->where('status', 'LIKE', '%' . $request->status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        } else {
            $users = User::where($request->searchCol, 'LIKE', '%' . $keyword . '%')->where('status', 'LIKE', '%' . $request->status ?? '' . '%')->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')->get();
        }
        return response()->json([
            'data' => [
                'users' => UserResource::collection($users)
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
        $user = User::withTrashed()->find($id);

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

    public function changePassword(Request $request, string $id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng', 'status' => 404]);
        } else {

            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json(['message' => 'Sai mật khẩu cũ', 'status' => 404]);
            }

            User::whereId($user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'message' => 'Đổi mật khẩu thành công!',
                'status' => 200
            ]);
        }
    }


    public function destroyForever(string $id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $delete_user = $user->forceDelete();
            if ($delete_user) {
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

    // ## ============================================ NHÓM HÀM CHO CRUD USER TRONG BLADE ADMIN ==================================

    public function userManagementList(Request $request)
    {
        $data['status'] = $status = $request->status ?? '';
        $data['sortField'] = $sortField = $request->sort ?? '';
        $data['sortDirection'] = $sortDirection = $request->direction ?? '';
        $data['searchCol'] = $searchCol = $request->searchCol ?? '';
        $data['keyword'] = $keyword = $request->keyword ?? '';
        $response = Http::get(url('') . "/api/user?sort=$sortField&direction=$sortDirection&status=$status&searchCol=$searchCol&keyword=$keyword");
        if ($response->status() == 200) {
            $data = json_decode(json_encode($response->json()['data']['users']), false);

            $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $collection = new Collection($data);
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
            $data->setPath(request()->url());
            $request->limit ? $data->setPath(request()->url())->appends(['limit' => $perPage]) : '';
            $request->sort && $request->direction ? $data->setPath(request()->url())->appends(['sort' => $sortField, 'direction' => $sortDirection]) : '';
            $request->searchCol ? $data->setPath(request()->url())->appends(['searchCol' => $searchCol]) : '';
            $request->status ? $data->setPath(request()->url())->appends(['status' => $status]) : '';
            $request->keyword ? $data->setPath(request()->url())->appends(['keyword' => $keyword]) : '';
            if ($data->currentPage() > $data->lastPage()) {
                return redirect($data->url(1));
            }
        } else {
            $data = [];
        }
        return view('admin.users.list', compact('data'));
    }

    public function userManagementEdit(UserRequest $request, $id)
    {
        $response = json_decode(json_encode(Http::get(url('') . '/api/user-show/' . $request->id)['data']['user']));
        if ($request->isMethod('POST')) {
            $data = $request->except('_token', 'btnSubmit');
            $response = Http::put(url('') . '/api/user-edit/' . $id, $data);
            // Kiểm tra kết quả từ API và trả về response tương ứng
            if ($response->successful()) {
                return response()->json(['success' => true, 'message' => 'Cập nhật tài khoản thành công', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Lỗi khi cập nhật tài khoản', 'status' => 500]);
            }
        }
        return view('admin.users.edit', compact('response'));
    }

    public function userManagementAdd(UserRequest $request)
    {
        $data = $request->except('_token');
        if ($request->isMethod('POST')) {
            if ($request->ajax()) {
                $response = Http::post(url('') . '/api/user-store', $data);
                // Kiểm tra kết quả từ API và trả về response tương ứng
                if ($response->successful()) {
                    return response()->json(['success' => true, 'message' => 'Thêm mới tài khoản thành công', 'status' => 200]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Lỗi khi thêm mới tài khoản', 'status' => 500]);
                }
            }
        }

        return view('admin.users.add');
    }

    public function userManagementDetail(Request $request)
    {
        $data = $request->except('_token');
        $item = Http::get(url('') . '/api/user-show/' . $request->id)->json()['data']['user'];
        $html = view('admin.users.detail', compact('item'))->render();
        return response()->json(['html' => $html, 'status' => 200]);
    }

    public function userManagementTrash(Request $request)
    {
        $data = User::onlyTrashed()->get();
        $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        return view('admin.users.trash', compact('data'));
    }

    // khôi phục bản ghi bị xóa mềm

    public function userManagementRestore($id)
    {

        if ($id) {
            $data = User::withTrashed()->find($id);
            if ($data) {
                $data->restore();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Khôi phục tài khoản không thành công']);
    }
}
