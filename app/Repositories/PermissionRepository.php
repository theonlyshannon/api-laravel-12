<?php

namespace App\Repositories;

use App\Interfaces\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function getAll(?string $search)
    {
        if ($search) {
            return Permission::where('name', 'like', '%' . $search . '%')->get();
        }
        return Permission::all();
    }

    public function getById(int $id)
    {
        return Permission::find($id);
    }
}