<?php

namespace App\Services;

use App\Http\Controllers\API\Exceptions\ApiBadRequestException;
use App\Http\Controllers\API\Exceptions\ApiSystemException;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\Role\AssignPermissionRequest;
use App\Http\Requests\Role\GetIdRoleRequest;
use App\Http\Requests\Role\RevokePermissionRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Role\RoleInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class RoleService
{
    /**
     * @var RoleInterface
     */
    protected RoleInterface $role;

    /**
     * @param  RoleInterface  $role
     */
    public function __construct(RoleInterface $role)
    {
        $this->role = $role;
    }

    /**
     * @param  RequestPaginate  $request
     * @return array
     */
    public function getPagination(RequestPaginate $request): array
    {
        try {
            return $this->role->getPaginationWithRelationship($request, 'permissions');
        } catch (Exception) {
            throw new ApiBadRequestException();
        }
    }

    /**
     * @param  GetIdRoleRequest  $request
     * @return array
     */
    public function show(GetIdRoleRequest $request): array
    {
        try {
            $check = $this->role->getByColumns('id', $request->id);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully retrieved data',
                    'data' => $this->role->getByIdWithRelationship($request->id, 'permissions'),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'role not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    /**
     * @param  StoreRoleRequest  $request
     * @return array
     */
    public function store(StoreRoleRequest $request): array
    {
        try {
            $check = $this->role->getByColumns('name', $request->name);
            if (empty($check)) {
                return [
                    'status' => Response::HTTP_CREATED,
                    'message' => 'successfully store data',
                    'data' => $this->role->save($request),
                ];
            } else {
                return [
                    'status' => Response::HTTP_FOUND,
                    'message' => 'role is exists !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    /**
     * @param  UpdateRoleRequest  $request
     * @return array
     */
    public function update(UpdateRoleRequest $request): array
    {
        try {
            $check = $this->role->getByColumns('name', $request->name);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully updated data',
                    'data' => $this->role->update($request),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'role not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    /**
     * @param  GetIdRoleRequest  $request
     * @return array
     */
    public function delete(GetIdRoleRequest $request): array
    {
        try {
            $check = $this->role->getByColumns('id', $request->id);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully delete data',
                    'data' => $this->role->deleteById($request->id),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'role not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    /**
     * @param  AssignPermissionRequest  $assignPermissionRequest
     * @return array
     */
    public function assignPermission(AssignPermissionRequest $assignPermissionRequest): array
    {
        try {
            $check = $this->role->getByColumns('name', $assignPermissionRequest->role_name);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully assign data',
                    'data' => $this->role->assignPermission($assignPermissionRequest),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'roles not found !',
                ];
            }
        } catch (Exception) {
            throw new ApiBadRequestException();
        }
    }

    /**
     * @param  RevokePermissionRequest  $revokePermissionRequest
     * @return array
     */
    public function revokePermissions(RevokePermissionRequest $revokePermissionRequest): array
    {
        try {
            $check = $this->role->getByColumns('name', $revokePermissionRequest->role_name);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully revoked data',
                    'data' => $this->role->revokePermission($revokePermissionRequest),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'roles not found !',
                ];
            }
        } catch (Exception) {
            throw new ApiBadRequestException();
        }
    }
}
