<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\User\AssignRoleRequest;
use App\Http\Requests\User\GetIdUserRequest;
use App\Http\Requests\User\RevokeRoleRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * EmployeeController Constructor
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->middleware(['permission:User@index'], ['only' => ['index']]);
        $this->middleware(['permission:User@show'], ['only' => ['show']]);
        $this->middleware(['permission:User@store'], ['only' => ['store']]);
        $this->middleware(['permission:User@update'], ['only' => ['update']]);
        $this->middleware(['permission:User@destroy'], ['only' => ['destroy']]);
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  RequestPaginate  $requestPaginate
     * @return JsonResponse
     */
    public function index(RequestPaginate $requestPaginate): JsonResponse
    {
        return response()->json($this->userService->getPagination($requestPaginate));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  GetIdUserRequest  $request
     * @return JsonResponse
     */
    public function show(GetIdUserRequest $request): JsonResponse
    {
        return response()->json($this->userService->show($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return response()->json($this->userService->store($request));
    }

    /**
     * Update existing resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        return response()->json($this->userService->update($request));
    }

    /**
     * Delete a listing of the resource.
     *
     * @param  GetIdUserRequest  $request
     * @return JsonResponse
     */
    public function destroy(GetIdUserRequest $request): JsonResponse
    {
        return response()->json($this->userService->delete($request));
    }

    public function assign(AssignRoleRequest $assignPermissionRequest): JsonResponse
    {
        return response()->json($this->userService->assignRole($assignPermissionRequest));
    }

    public function revoke(RevokeRoleRequest $revokeRoleRequest): JsonResponse
    {
        return response()->json($this->userService->revokeRole($revokeRoleRequest));
    }
}
