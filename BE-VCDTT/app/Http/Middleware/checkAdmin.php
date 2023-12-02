<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check() && Auth::user()->is_admin == 1 || Auth::check() && Auth::user()->is_admin == 3) {
            if(Auth::user()->is_admin == 1) {

                $check_record_role = Role::where('name', '=', 'Admin')->exists();

                if(!$check_record_role) {
                    $data_insert_role = [
                        'name' => 'Admin',
                        'guard_name' => 'web',
                        'desc_role' => 'Quyền tối cao',
                        'created_at' => now(),
                        'updated_at' => now()
                      ];
            
                      $role = Role::create($data_insert_role);
                      $check_record_role_has_permission = DB::table('role_has_permissions')->where('permission_id', 31)->where('role_id', $role->id)->exists();
                      if(!$check_record_role_has_permission) {
                        $record_role_has_permission = DB::table('role_has_permissions')->insert(['permission_id' => 31, 'role_id' => $role->id]);
                      }
                      $check_record_model_has_roles = DB::table('model_has_roles')->where('role_id', $role->id)->where('model_id', Auth::user()->id)->exists();
                      if(!$check_record_model_has_roles) {
                        $record_model_has_roles = DB::table('model_has_roles')->insert(['role_id' => $role->id, 'model_type' => 'App\Models\User', 'model_id' => Auth::user()->id]);
                      }
                      $check_record_model_has_permissions = DB::table('model_has_permissions')->where('permission_id', 31)->where('model_id', Auth::user()->id)->exists();
                      if(!$check_record_model_has_permissions){
                        $record_model_has_permissions = DB::table('model_has_permissions')->insert(['permission_id' => 31, 'model_type' => 'App\Models\User', 'model_id' => Auth::user()->id]);
                      }

                }     

            }
            return $next($request);
        }
        Auth::logout();
        return back()->with('fail', 'Tên đăng nhập hoặc mật khẩu chưa đúng hoặc bạn không có quyền truy cập vào phần này!');
    }
}
