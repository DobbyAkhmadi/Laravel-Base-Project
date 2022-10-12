<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\Role\AssignPermissionRequest;
use App\Http\Requests\Role\RevokePermissionRequest;
use App\Services\RoleService;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    protected RoleService $roleService;

    /**
     * @param  RoleService  $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  RequestPaginate  $requestPaginate
     * @return JsonResponse
     */
    public function index(RequestPaginate $requestPaginate): JsonResponse
    {
        return response()->json($this->roleService->getPagination($requestPaginate));
    }

    public function assign(AssignPermissionRequest $assignPermissionRequest): JsonResponse
    {
        return response()->json($this->roleService->assignPermission($assignPermissionRequest));
    }

    public function revoke(RevokePermissionRequest $revokePermissionRequest): JsonResponse
    {
        return response()->json($this->roleService->revokePermissions($revokePermissionRequest));
    }
}
