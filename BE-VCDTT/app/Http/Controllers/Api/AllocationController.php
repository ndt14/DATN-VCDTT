<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AllocationRequest;
use App\Models\Allocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class AllocationController extends Controller
{
    //
    public function allocationManagementList(Request $request) {
        $data = User::with('roles')->whereHas('roles')->get();
        $perPage= $request->limit??5;// Số mục trên mỗi trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $collection = new Collection($data);
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
        $data->setPath(request()->url())->appends(['limit' => $perPage]);
        if($data->currentPage()>$data->lastPage()){
            return redirect($data->url(1));
        }
        return view('admin.decentralization.allocations.list', compact('data'));
    }

    public function allocationManagementAdd(AllocationRequest $request) {

        if($request->isMethod('POST')) {
            $roles = $request->role;
            $user = User::find($request->user);
            if(!empty($roles)) {

                $permissions = [];
                foreach($roles as $item) {
                    $permission = DB::table('role_has_permissions')->where('role_id', $item)->select('permission_id')->get()->pluck('permission_id')
                    ->toArray();
                    $permissions[] = $permission;
                }
            if(!empty($permissions)) {
                $permissions = array_unique(call_user_func_array('array_merge', $permissions));
                if($user) {
                    $user->syncPermissions($permissions);
                    $user->syncRoles($roles);
                    return redirect()->route('allocation.add')->with('success', 'Cấp quyền cho user có email "'.$user->email.'" thành công');
                }
            }
            }
        }
        $list_roles = Role::where('name', '!=', 'Admin')->get();
        $list_users = User::where('is_admin','!=', 1)->select('id','email')->get();
        return view('admin.decentralization.allocations.add', compact('list_roles','list_users'));
    }


    public function allocationManagementEdit(AllocationRequest $request, $user_id) {

        if($request->isMethod('POST')) {
            $user = User::find($user_id);
            $data = $request->all();
            $roles = $data['role'];
            if(!empty($roles)) {
                $permissions = [];
                foreach($roles as $item) {
                    $permission = DB::table('role_has_permissions')->where('role_id', $item)->select('permission_id')->get()->pluck('permission_id')
                    ->toArray();
                    $permissions[] = $permission;
                }
            if(!empty($permissions)) {
                $permissions = array_unique(call_user_func_array('array_merge', $permissions));
                $user->syncPermissions($permissions);
                $user->syncRoles($roles);
            }
            }
            return redirect()->route('allocation.edit', ['user_id' => $user_id])->with('success', 'Cấp vai trò lại cho user có email "'.$user->email.'" thành công');
        }
        $list_roles = Role::where('name', '!=', 'Admin')->get();
        $list_users = User::where('is_admin','!=', 1)->select('id','email')->get();
        $roles_user = DB::table('model_has_roles')->where('model_id', $user_id)->select('role_id')->get()->pluck('role_id')->toArray();
        return view('admin.decentralization.allocations.edit', compact('list_roles','list_users', 'user_id', 'roles_user'));
    }

    public function delete_one_user_role(Request $request) {

        $user = User::find($request->idUser);

        if($user) {
            $delete_model_has_roles = DB::table('model_has_roles')->where('role_id', $request->idRole)->where('model_id', $request->idUser)->delete();
            $permission = DB::table('role_has_permissions')->where('role_id', $request->idRole)->select('permission_id')->get()->pluck('permission_id')
            ->toArray();
            $permissions[] = $permission;

            if(!empty($permissions)) {
                $permissions = array_unique(call_user_func_array('array_merge', $permissions));

                foreach($permissions as $item) {
                    $delete_model_has_permissions = DB::table('model_has_permissions')->where('permission_id', $item)->where('model_id', $request->idUser)->delete();
                }
            }
            return response()->json(['message' => 'OK', 'status' => 200]);
        }
    }


    // api allocation
    public function destroy(Request $request, $user_id) {

        $user = User::find($user_id);

        if($user) {
            $roles_user = $user->roles->pluck('id')->toArray();
            if(!empty($roles_user)) {

                $permissions = [];
                foreach($roles_user as $item) {
                    $delete_model_has_roles = DB::table('model_has_roles')->where('role_id', $item)->where('model_id', $user_id)->delete();
                    $permission = DB::table('role_has_permissions')->where('role_id', $item)->select('permission_id')->get()->pluck('permission_id')
                    ->toArray();
                    $permissions[] = $permission;
                }
            if(!empty($permissions)) {
                $permissions = array_unique(call_user_func_array('array_merge', $permissions));

                foreach($permissions as $item) {
                    $delete_model_has_permissions = DB::table('model_has_permissions')->where('permission_id', $item)->where('model_id', $user_id)->delete();
                }
            }
            return response()->json(['message' => 'OK', 'status' => 200]);
        }
    }else {
        return response()->json(['message' => '404 Not found', 'status' => 404]);
    }

    }


    public function allocationManagementDetail(Request $request) {
        $data = $request->except('_token');
        $response = Http::get('http://be-vcdtt.datn-vcdtt.test/api/rating-show/'.$request->id);
        if($response->status() == 200) {
            $item = json_decode(json_encode($response->json()['data']['rating']), false);
            $html = view('admin.ratings.detail', compact('item'))->render();
            return response()->json(['html' => $html, 'status' => 200]);
        }
    }

    // hiện tại đã hoàn thành đến bước cấp quyền và insert dữ liệu vào đủ các bảng
    // thấy rằng đúng là nếu xóa vai trò thì list show cấp quyền cũng rút theo và thấy rằng được cái model_has_roles cũng rút role, và role_permission cũng vậy
    // nhưng ở bảng model_has_permisson thì chưa.
    // hôm nay tiếp tục lưu ý các phần trên để đảm bảo tính toàn vẹn về dữ liệu
    // làm tiếp chức năng xóa và cập nhật và đi phân quyền trong hệ thống (blade, route)

    // hướng giải quyết tính toàn vẹn: khi xóa vai trò => danh sách cấp rút theo (tức bản ghi tại 3 bảng: role, role_has, model_has_role) => thì mình dựa vào id_role vừa xóa để lấy ra tất cả các user thuộc id_role (vì mỗi role tạo ra đều có quyền hoặc nhóm quyền) => mình sẽ dựa vào id_role để lấy ra nhóm user thuộc vai trò đó => dựa vào nhóm user thuộc để xóa đi những bản ghi
}
