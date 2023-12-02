<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
  //

  public function __construct()
  {

  }

  public function roleManagementList(Request $request)
  {
    $data = Role::all();
    $perPage = $request->limit ?? 5; // Số mục trên mỗi trang
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $collection = new Collection($data);
    $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $data = new LengthAwarePaginator($currentPageItems, count($collection), $perPage);
    $data->setPath(request()->url())->appends(['limit' => $perPage]);
    if ($data->currentPage() > $data->lastPage()) {
      return redirect($data->url(1));
    }
    return view('admin.decentralization.roles.list', compact('data'));
  }

  public function roleManagementAdd(RoleRequest $request)
  {

    if ($request->isMethod('POST')) {
      $data = $request->all();
      $data_insert_role = [
        'name' => $data['name'],
        'guard_name' => $data['guard_name'],
        'desc_role' => $data['desc_role']
      ];

      $role = Role::create($data_insert_role);

      if ($role->id) {
        $role = Role::find($role->id);
        $role->syncPermissions($data['permission']);
        $role->save();
        return response()->json(['message' => 'Thêm mới vai trò thành công', 'success' => true, 'status' => 200]);
      }

    }
    return view('admin.decentralization.roles.add');
  }
  public function roleManagementEdit(RoleRequest $request, $id)
  {

    if ($request->isMethod('POST')) {
      $data = $request->all();
      $data_update_role = [
        'name' => $data['name'],
        'guard_name' => $data['guard_name'],
        'desc_role' => $data['desc_role']
      ];
      $role = Role::where('id', $id)->update($data_update_role);
      $role_has_permissions_before = DB::table('role_has_permissions')->where('role_id', $id)->select('permission_id')->get()->pluck('permission_id')->toArray();
      if ($role) {
        $role = Role::find($id);
        $role->syncPermissions($data['permission']);
        $user = DB::table('model_has_roles')->where('role_id', $id)->select('model_id')->get()->pluck('model_id')->toArray();
        if (!empty($user)) {
          if (count(array_map('intval', $data['permission'])) > count($role_has_permissions_before)) {
            // sự khác biệt khi tăng quyền (thêm)
            $compare_arrays = array_diff(array_map('intval', $data['permission']), $role_has_permissions_before);

            foreach ($user as $user_id) {

              $user_item = User::find($user_id);
              foreach ($compare_arrays as $permission_want_add) {
                $check_user_has_permission = DB::table('model_has_permissions')->where('model_id', $user_id)->where('permission_id', $permission_want_add)->exists();
                if (!$check_user_has_permission) {
                  $give_permission_user = DB::table('model_has_permissions')->insert(['permission_id' => $permission_want_add, 'model_type' => 'App\Models\User', 'model_id' => $user_id]);
                }
              }
            }
          } else {
            // sự khác biệt khi giảm quyền (xóa)
            $compare_arrays = array_diff($role_has_permissions_before, array_map('intval', $data['permission']));
            foreach ($user as $user_id) {
              // lấy list role từ user hiện tại (trừ role hiện tại)
              // lặp list role trong lúc lặp lấy các quyền từ các role
              // kiểm tra xem có quyền hiện tại hay không. Có => thôi, không => xóa

              $user_has_roles = DB::table('model_has_roles')->where('model_id', $user_id)->where('role_id', '<>', $id)->select('role_id')->get()->pluck('role_id')->toArray();
              if (!empty($user_has_roles)) {

                foreach ($user_has_roles as $role) {
                  $role_has_permissions = DB::table('role_has_permissions')->where('role_id', $role)->select('permission_id')->get()->pluck('permission_id')->toArray();
                  if (!empty($role_has_permissions)) {

                    foreach ($compare_arrays as $permission_want_del) {

                      if (!in_array($permission_want_del, $role_has_permissions)) {
                        $delete_permission_user = DB::table('model_has_permissions')->where('model_id', $user_id)->where('permission_id', $permission_want_del)->delete();
                      }
                    }
                  }
                }
              }

            }
          }



        }



      }
      return response()->json(['success' => true, 'message' => 'Cập nhật vai trò thành công', 'status' => 200]);
    }

    $role = Role::findById($id);
    $permissions = DB::table('role_has_permissions')
      ->where('role_id', $id)
      ->select('permission_id')
      ->get()
      ->pluck('permission_id')
      ->toArray();
    return view('admin.decentralization.roles.edit', compact('role', 'permissions'));
  }

  // api delete

  public function destroy($id)
  {

    $role = Role::findById($id);

    if ($role) {
      $deleteRole = $role->delete();
      if (!$deleteRole) {
        return response()->json(['message' => 'internal server error', 'status' => 500]);
      }
      return response()->json(['message' => 'OK', 'status' => 200]);
    } else {
      return response()->json(['message' => '404 Not found', 'status' => 404]);
    }
  }

  //

}
