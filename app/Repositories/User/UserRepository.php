<?php

namespace App\Repositories\User;

use App\Http\Requests\Auth\RequestLogin;
use App\Http\Requests\User\AssignRoleRequest;
use App\Http\Requests\User\RevokeRoleRequest;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * UserRepository constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function login(RequestLogin $request): array
    {
        if (Auth::attempt(['identity_number' => $request->identity_number, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('auth_token')->plainTextToken;
            $success['identity_number'] = $user->identity_number;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['token_type'] = 'Bearer';
            $success['roles'] = $user->roles;
            $success['permission'] = $user->getPermissionsViaRoles();

            return [
                'data' => $success,
                'status' => Response::HTTP_OK,
                'message' => 'User login successfully.',
            ];
        } else {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'error' => 'credentials is not found',
            ];
        }
    }

    public function logout(): array
    {
        try {
            $is_deleted = auth()->user()->tokens()->delete();
            if (! $is_deleted) {
                return [
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'error' => 'request time out!',
                ];
            }
        } catch (\Exception) {
        }

        return [
            'status' => Response::HTTP_OK,
            'message' => 'Logged out',
        ];
    }

    public function assignRole(AssignRoleRequest $assignPermissionRequest)
    {
        $getCurrentUser = $this->model->where('identity_number', $assignPermissionRequest->identity_number)->first();

        $getCurrentUser->assignRole($assignPermissionRequest->role_name);

        return $getCurrentUser->attributesToArray();
    }

    public function revokeRole(RevokeRoleRequest $revokeRoleRequest)
    {
        $getCurrentUser = $this->model->where('identity_number', $revokeRoleRequest->identity_number)->first();

        $getCurrentUser->roles()->detach();

        return $getCurrentUser->attributesToArray();
    }
}
