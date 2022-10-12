<?php

namespace App\Repositories\Role;

use App\Http\Requests\Role\AssignPermissionRequest;
use App\Http\Requests\Role\RevokePermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleInterface
{
    /**
     * UserRepository constructor.
     *
     * @param  Role  $role
     */
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function assignPermission(AssignPermissionRequest $assignPermissionRequest): array
    {
        $getCurrentRole = $this->model->where('name', $assignPermissionRequest->role_name)->first();

        $permissionResult = explode(',', $assignPermissionRequest->permissions);
        $totalPermission = count($permissionResult);

        for ($i = 0; $i < $totalPermission; $i++) {
            $getCurrentRole->givePermissionTo($permissionResult[$i]);
        }

        return $getCurrentRole->attributesToArray();
    }

    public function revokePermission(RevokePermissionRequest $revokePermissionRequest): array
    {
        $getCurrentRole = $this->model->where('name', $revokePermissionRequest->role_name)->first();
        $getCurrentRole->revokePermissionTo(Permission::all());

        return $getCurrentRole->attributesToArray();
    }
}
