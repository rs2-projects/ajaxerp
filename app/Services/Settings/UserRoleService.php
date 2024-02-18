<?php

namespace App\Services\Settings;

use App\Models\Permission\Role;
use Illuminate\Support\Str;

class UserRoleService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function indexFilteredData()
    {
        $data['roles'] = Role::where('deleted', Role::DELETED_NO)
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);
        return $data;
    }

    public function store($request)
    {

        $slug = Str::slug($request->title);
        $check_role = Role::where('slug', $slug)
                ->where('deleted', Role::DELETED_NO)
                ->first();
        if (!empty($check_role)) {
            throw new \Exception("Role already exists");
        }

        if ($request->is_default) {
            Role::where('is_default', 1)->update(['is_default' => 0]);
        }

        $role = new Role();
        $role->title = $request->title;
        $role->slug = $slug;
        $role->description = $request->description;
        $role->is_default = $request->is_default ? 1 : 0;
        $role->created_by = auth()->user()->id;
        $role->created_at = now();
        $role->updated_by = auth()->user()->id;
        $role->updated_at = now();
        $role->save();
    }


    public function editData($id)
    {
        $data['item'] = Role::where('id', $id)
            ->where('deleted', Role::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Role not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $role = Role::where('id', $id)
            ->where('deleted', Role::DELETED_NO)
            ->first();
        if (!$role) {
            throw new \Exception('Role not found');
        }
        $slug = Str::slug($request->title);
        $checkRole = Role::where('slug', $slug)
            ->where('id', '!=', $role->id)
            ->where('deleted', Role::DELETED_NO)
            ->first();
        if (!empty($checkRole)) {
            throw new \Exception("Role already exists");
        }
        if ($request->is_default && !$role->is_default) {
            Role::where('is_default', 1)->update(['is_default' => 0]);
        }
        $role->title = $request->title;
        $role->slug = $slug;
        $role->description = $request->description;
        $role->is_default = $request->is_default ? 1 : 0;
        $role->updated_by = auth()->user()->id;
        $role->updated_at = now();
        $role->save();
    }

    public function delete($id)
    {
        $category = Role::where('id', $id)
            ->where('deleted', Role::DELETED_NO)
            ->first();
        if (!$category) {
            throw new \Exception('Asset Product Category not found');
        }
        $category->deleted = Role::DELETED_YES;
        $category->deleted_by = auth()->user()->id;
        $category->deleted_at = now();
        $category->save();
    }

    public function statusUpdateData($id, $status)
    {
        try {
            $role = Role::where('id', $id)
                ->where('deleted', Role::DELETED_NO)
                ->first();
            if (!$role) {
                throw new \Exception('Role not found');
            }
            if ($status) {
                Role::where('is_default', 1)->update(['is_default' => 0]);
            }
            $role->is_default = $status;
            $role->updated_by = auth()->user()->id;
            $role->updated_at = now();
            $role->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
