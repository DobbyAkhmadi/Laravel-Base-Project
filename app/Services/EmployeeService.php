<?php
namespace App\Services;

use App\Http\Controllers\API\Exceptions\ApiBadRequestException;
use App\Http\Controllers\API\Exceptions\ApiSystemException;
use App\Http\Requests\Employee\GetIdEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Requests\RequestPaginate;
use App\Repositories\Employee\EmployeeInterface;
use Symfony\Component\HttpFoundation\Response;

class EmployeeService
{
    /**
     * @var EmployeeInterface
     */
    protected EmployeeInterface $employee;

    /**
     * @param  EmployeeInterface  $employee
     */
    public function __construct(EmployeeInterface $employee)
    {
        $this->employee = $employee;
    }

    /**
     * @param  RequestPaginate  $request
     * @return mixed
     */
    public function getPagination(RequestPaginate $request): array
    {
        try {
            return $this->employee->getPagination($request);
        } catch (\Exception) {
            throw new ApiBadRequestException();
        }
    }

    public function show(GetIdEmployeeRequest $request): array
    {
        try {
            $check = $this->employee->getByColumns('id', $request->id);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully retrieved data',
                    'data' => $this->employee->getById($request->id),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'employee not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function store(StoreEmployeeRequest $request): array
    {
        try {
            $check = $this->employee->getByColumns('identity_number', $request->identity_number);
            if (empty($check)) {
                return [
                    'status' => Response::HTTP_CREATED,
                    'message' => 'successfully store data',
                    'data' => $this->employee->save($request),
                ];
            } else {
                return [
                    'status' => Response::HTTP_FOUND,
                    'message' => 'employee is exists !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function update(UpdateEmployeeRequest $request): array
    {
        try {
            $check = $this->employee->getByColumns('id', $request->id);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully updated data',
                    'data' => $this->employee->update($request),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'employee not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }

    public function delete(GetIdEmployeeRequest $request): array
    {
        try {
            $check = $this->employee->getByColumns('id', $request->id);
            if (! empty($check)) {
                return [
                    'status' => Response::HTTP_OK,
                    'message' => 'successfully delete data',
                    'data' => $this->employee->deleteById($request->id),
                ];
            } else {
                return [
                    'status' => Response::HTTP_NO_CONTENT,
                    'message' => 'employee not found !',
                ];
            }
        } catch (\Exception) {
            throw new ApiSystemException();
        }
    }
}
