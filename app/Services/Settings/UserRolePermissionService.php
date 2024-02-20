<?php

namespace App\Services\Settings;

use App\Models\Permission\Role;
use App\Models\Permission\RolePermission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRolePermissionService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexData($id)
    {
        $data['role_id'] = $id;
        $data['role_name'] = Role::find($id)->title;
        $data['permissions'] = RolePermission::where('deleted', RolePermission::DELETED_NO)
            ->where('role_id', $id)
            ->pluck('permission')
            ->toArray();
        return $data;
    }

    public function store($request, $id)
    {
        DB::beginTransaction();
        try {
            $check_role = Role::where('id', $id)
                    ->where('deleted', Role::DELETED_NO)
                    ->first();
            if (empty($check_role)) {
                throw new \Exception("Role permission not found");
            }

            if (isset($request->permissions) && is_array($request->permissions) && (count($request->permissions) > 0)) {
                $permissions = $request->permissions??[];
                $delete_permissions = RolePermission::where('role_id', $id)
                    ->whereNotIn('permission', $permissions)
                    ->delete();

                foreach ($request->permissions as $key=>$val) {
                    if (isset($request->permissions[$key]) &&  $request->permissions[$key] != null){
                        $role_permit = RolePermission::where('permission', $request->permissions[$key])
                            ->where('role_id', $id)
                            ->first();
                        if ($role_permit){
                            continue;
                        }else{
                            $role_permit = new RolePermission();
                            $role_permit->role_id = $id;
                            $role_permit->permission = $val;
                            $role_permit->save();
                        }
                    }
                }
                User::where('role_id', $id)->update(['reset_permission' => 1]);

            }
        }catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();
    }
}
