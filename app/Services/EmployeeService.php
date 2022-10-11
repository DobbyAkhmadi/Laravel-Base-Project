<?php

use App\Http\Controllers\API\Exceptions\ApiBadRequestException;

class EmployeeService
{
    /**
     * @var EmployeeInterface
     */
    protected EmployeeInterface $employee;

    /**
     * @param EmployeeInterface $employee
     */
    public function __construct(EmployeeInterface $employee)
    {
        $this->employee = $employee;
    }

    /**
     * @param  RequestPaginate  $request
     * @return mixed
     */
    public function getPagination(RequestPaginate $request): mixed
    {
        try {
            return $this->employee->getPagination($request);
        } catch (\Exception) {
            throw new ApiBadRequestException();
        }
    }
}
