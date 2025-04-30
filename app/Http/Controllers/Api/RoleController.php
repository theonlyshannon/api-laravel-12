<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Helpers\HashidsHelper;
use App\Helpers\ResponseHelper;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Interfaces\RoleRepositoryInterface;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;

        $this->middleware('permission:roles-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:roles-create', ['only' => ['store']]);
        $this->middleware('permission:roles-edit', ['only' => ['update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->roleRepository->getAll();

        return ResponseHelper::jsonResponse(true, 'Role berhasil dimuat', RoleResource::collection($roles), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $role = $this->roleRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Role berhasil disimpan', new RoleResource($role), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Role gagal disimpan', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = $this->roleRepository->getById(HashidsHelper::decodeId($id));

        if (! $role) {
            return ResponseHelper::jsonResponse(false, 'Role tidak tersedia.', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'Role berhasil dimuat', new RoleResource($role), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $role = $this->roleRepository->getById(HashidsHelper::decodeId($id));
        if ($role->name == UserRoleEnum::ADMIN->value) {
            return ResponseHelper::jsonResponse(false, 'Role Admin tidak dapat diperbarui', null, 422);
        }

        try {
            $role = $this->roleRepository->update($data, HashidsHelper::decodeId($id));

            return ResponseHelper::jsonResponse(true, 'Role berhasil diperbarui', new RoleResource($role), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Role gagal diperbarui', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = $this->roleRepository->getById(HashidsHelper::decodeId($id));
            if ($role->name == UserRoleEnum::ADMIN->value) {
                return ResponseHelper::jsonResponse(false, 'Role Admin tidak dapat dihapus', null, 422);
            }

            $this->roleRepository->delete($role->id);

            return ResponseHelper::jsonResponse(true, 'Role berhasil dihapus', null, 204);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Role gagal dihapus', $e->getMessage(), 500);
        }
    }
}