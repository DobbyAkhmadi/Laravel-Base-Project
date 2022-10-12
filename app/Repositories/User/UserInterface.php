<?php

namespace App\Repositories\User;

use App\Http\Requests\Auth\RequestLogin;
use App\Http\Requests\User\AssignRoleRequest;
use App\Http\Requests\User\RevokeRoleRequest;
use App\Repositories\BaseRepositoryInterface;

interface UserInterface extends BaseRepositoryInterface
{
    public function login(RequestLogin $request);

    public function logout();

    public function assignRole(AssignRoleRequest $assignPermissionRequest);

    public function revokeRole(RevokeRoleRequest $revokeRoleRequest);
}
