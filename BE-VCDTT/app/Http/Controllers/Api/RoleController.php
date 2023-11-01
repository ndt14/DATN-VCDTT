<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
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

    public function roleManagementList() {
      $data = Role::all();
      return view('admin.decentralization.roles.list', compact('data'));
    }

    public function roleManagementAdd(RoleRequest $request) {
        
        if($request->isMethod('POST')) {
          $data = $request->all();
          $data_insert_role = [
            'name' => $data['name'],
            'guard_name' => $data['guard_name'],
            'desc_role' => $data['desc_role']
          ];

          $role = Role::create($data_insert_role);
          
          if($role->id) {
            $role = Role::find($role->id);
            $role->syncPermissions($data['permission']);
            $role->save();
            return redirect()->route('role.add')->with('success', 'Thêm vai trò thành công');
           
          }

        }
        return view('admin.decentralization.roles.add');
    }
    public function roleManagementEdit(RoleRequest $request, $id) {
        
      if($request->isMethod('POST')) {
          $data = $request->all();
          $data_update_role = [
            'name' => $data['name'],
            'guard_name' => $data['guard_name'],
            'desc_role' => $data['desc_role']
          ];
          $role = Role::where('id', $id)->update($data_update_role);

          if($role) {
            $role = Role::find($id);
            $role->syncPermissions($data['permission']);
            $role->save();
            return redirect()->route('role.edit',['id' => $id])->with('success', 'Cập nhật vai trò thành công');
          }
      }

        $role = Role::findById($id);
        $permissions = DB::table('role_has_permissions')
                    ->where('role_id', $id)
                    ->select('permission_id')
                    ->get()
                    ->pluck('permission_id')
                    ->toArray();
        return view('admin.decentralization.roles.edit', compact('role','permissions'));
    }

    // api delete

    public function destroy($id) {
  
      $role = Role::findById($id);
    
      if($role) {
          $deleteRole = $role->delete();
          if (!$deleteRole) {
              return response()->json(['message' => 'internal server error', 'status' => 500]);
          }
          return response()->json(['message' => 'OK', 'status' => 200]);
      }else {
          return response()->json(['message' => '404 Not found', 'status' => 404]);
      }
    }

    // 

}
