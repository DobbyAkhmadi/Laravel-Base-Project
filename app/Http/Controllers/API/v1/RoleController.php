<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\Role\AssignPermissionRequest;
use App\Http\Requests\Role\GetIdRoleRequest;
use App\Http\Requests\Role\RevokePermissionRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
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

    /**
     * @param  GetIdRoleRequest  $request
     * @return JsonResponse
     */
    public function show(GetIdRoleRequest $request): JsonResponse
    {
        return response()->json($this->roleService->show($request));
    }

    /**
     * @param  StoreRoleRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        return response()->json($this->roleService->store($request));
    }

    /**
     * @param  UpdateRoleRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request): JsonResponse
    {
        return response()->json($this->roleService->update($request));
    }

    /**
     * @param  GetIdRoleRequest  $request
     * @return JsonResponse
     */
    public function destroy(GetIdRoleRequest $request): JsonResponse
    {
        return response()->json($this->roleService->delete($request));
    }

    /**
     * @param  AssignPermissionRequest  $assignPermissionRequest
     * @return JsonResponse
     */
    public function assign(AssignPermissionRequest $assignPermissionRequest): JsonResponse
    {
        return response()->json($this->roleService->assignPermission($assignPermissionRequest));
    }

    /**
     * @param  RevokePermissionRequest  $revokePermissionRequest
     * @return JsonResponse
     */
    public function revoke(RevokePermissionRequest $revokePermissionRequest): JsonResponse
    {
        return response()->json($this->roleService->revokePermissions($revokePermissionRequest));
    }
}
