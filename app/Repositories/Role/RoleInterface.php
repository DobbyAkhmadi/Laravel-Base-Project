<?php

namespace App\Repositories\Role;

use App\Http\Requests\Role\AssignPermissionRequest;
use App\Http\Requests\Role\RevokePermissionRequest;
use App\Repositories\BaseRepositoryInterface;

interface RoleInterface extends BaseRepositoryInterface
{
    public function assignPermission(AssignPermissionRequest $assignPermissionRequest);

    public function revokePermission(RevokePermissionRequest $revokePermissionRequest);
}
