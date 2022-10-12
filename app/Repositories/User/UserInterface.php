<?php

namespace App\Repositories\User;

use App\Http\Requests\Auth\RequestLogin;


use App\Http\Requests\User\GetIdUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\BaseRepositoryInterface;

interface UserInterface extends BaseRepositoryInterface
{
    public function save(StoreUserRequest $request);

    public function update(UpdateUserRequest $request);

    public function delete(GetIdUserRequest $request);

    public function login(RequestLogin $request);

    public function logout();
}
