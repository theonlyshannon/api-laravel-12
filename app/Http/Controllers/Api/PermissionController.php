<?php

namespace App\Http\Controllers\Api;

use App\Helpers\HashidsHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;

        $this->middleware('permission:permissions-list', ['only' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $request->merge([
            'search' => $request->has('search') ? $request->search : null,
        ]);

        $request = $request->validate([
            'search' => 'nullable|string',
        ]);

        try {
            $permissions = $this->permissionRepository->getAll(
                search: $request['search']
            );

            return ResponseHelper::jsonResponse(true, 'Success', PermissionResource::collection($permissions), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $permission = $this->permissionRepository->getById(
                id: HashidsHelper::decodeId($id)
            );

            if (! $permission) {
                return ResponseHelper::jsonResponse(false, 'Permission tidak tersedia.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Success', new PermissionResource($permission), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}