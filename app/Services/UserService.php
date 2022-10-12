<?php

namespace App\Services;

use App\Http\Controllers\API\Exceptions\ApiSystemException;
use App\Http\Requests\Auth\RequestLogin;
use App\Http\Requests\RequestPaginate;
use App\Http\Requests\User\GetIdUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    /**
     * @var UserInterface
     */
    protected UserInterface $user;

    /**
     * @param  UserInterface  $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function Login(RequestLogin $request): mixed
    {
        try {
            return $this->user->login($request);
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function Logout(): mixed
    {
        try {
            return $this->user->logout();
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function getPagination(RequestPaginate $request):array
    {
        try {
            return $this->user->getPaginationWithRelationship($request,'roles');
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function show(GetIdUserRequest $request):array
    {
        try {
            $check = $this->user->getByColumns('id',$request->id);
            if (!empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully retrieved data',
                    'data' => $this->user->getByIdWithRelationship($request->id,'roles'),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'user not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function store(StoreUserRequest $request): array
    {
        try {
            $check = $this->user->getByColumns("email",$request->email);
            if (empty($check)) {
                return [
                    'status' => Response::HTTP_CREATED,
                    'message' => 'successfully store data',
                    'data' => $this->user->save($request),
                ];
            } else {
                return [
                    'status' => Response::HTTP_FOUND,
                    'message' => 'credentials is exists !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function update(UpdateUserRequest $request): array
    {
        try {
            $check = $this->user->getByColumns("id",$request->id);
            if (!empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully updated data',
                    'data' => $this->user->update($request),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'user not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function delete(GetIdUserRequest $request):array
    {
        try {
            $check = $this->user->getByColumns('id',$request->id);
            if (!empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully delete data',
                    'data' => $this->user->delete($request),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'user not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }
}
