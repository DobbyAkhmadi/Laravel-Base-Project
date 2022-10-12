<?php

namespace App\Services;

use App\Http\Controllers\API\Exceptions\ApiBadRequestException;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\Role\AssignPermissionRequest;
use App\Http\Requests\Role\RevokePermissionRequest;
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
     * @return mixed
     */
    public function getPagination(RequestPaginate $request): mixed
    {
        try {
            return $this->role->getPaginationWithRelationship($request, 'permissions');
        } catch (Exception) {
            throw new ApiBadRequestException();
        }
    }

    /**
     * @param  AssignPermissionRequest  $assignPermissionRequest
     * @return mixed
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
