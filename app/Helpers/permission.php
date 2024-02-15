<?php

use App\Models\Permission\RolePermission;

if(!function_exists('hasPermission')) {
    function hasPermission(...$permission): bool
    {
        $user = auth()->user();
        if($user->role == \App\Models\User::ROLE_SUPERUSER) {
            return true;
        }
        $permissions = session('session_permissions');

        if(empty($permissions)) {
           return false;
        }

        return count(array_intersect($permission, $permissions)) > 0;

        /*$check = RolePermission::where('role_id', $user->role_id)
            ->whereIn('permission', $permission)
            ->first();
        return !empty($check);*/
    }
}

if (!function_exists('isEmployee')) {
    function isEmployee(): bool
    {
        return (auth()->user()->role == \App\Models\User::ROLE_EMPLOYEE);
    }
}
