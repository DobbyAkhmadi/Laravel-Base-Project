<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RequestLogin;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Login api
     *
     * @param  RequestLogin  $request
     * @return array|JsonResponse
     */
    public function login(RequestLogin $request): JsonResponse|array
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
            Log::alert('user with identity number : '.$request->identity_number.' failed to request to login with ip address: '.request()->ip());

            return [
                'status' => Response::HTTP_NO_CONTENT,
                'error' => 'credentials is not found',
            ];
        }
    }

    /**
     * Logout api
     *
     * @return array|JsonResponse
     */
    public function logout(): array|JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();

            return [
                'message' => 'Logged out',
            ];
        } catch (Exception) {
        }

        return [
            'message' => 'request time out!',
        ];
    }
}
