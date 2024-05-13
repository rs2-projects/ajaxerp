<?php

namespace App\Traits;

use App\Models\Permission\RolePermission;
use App\Models\User;

trait HasPermission
{
    public function hasPermissionTo($permission): bool
    {
        if ($this->role == self::ROLE_SUPERUSER) {
            return true;
        }
        if($this->role_id == null) {
            return false;
        }
        $check = RolePermission::where('role_id', $this->role_id)
            ->where('permission', $permission)
            ->first();
        return !empty($check);
    }

    public function resetPermissionSession()
    {
        if($this->role != self::ROLE_SUPERUSER) {
            $role_id = $this->role_id;
            if($role_id == null) {
                return false;
            }

            $permissions = \App\Models\Permission\RolePermission::where('role_id', $role_id)->pluck('permission')->toArray();
            session(['session_permissions' => $permissions]);
        }
    }
}
