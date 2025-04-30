<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll()
    {
        return Role::all();
    }

    public function getById(string $id)
    {
        return Role::find($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $role = new Role();
            $role->name = $data['name'];
            $role->guard_name = 'sanctum';
            $role->save();

            $role->syncPermissions($data['permissions']);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function update(array $data, string $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::find($id);
            $role->name = $data['name'];
            $role->guard_name = 'sanctum';
            $role->save();

            $role->syncPermissions($data['permissions']);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::find($id);

            $role->delete();

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}