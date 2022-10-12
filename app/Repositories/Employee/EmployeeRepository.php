<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Repositories\BaseRepository;

class EmployeeRepository extends BaseRepository implements EmployeeInterface
{
    /**
     * EmployeeRepository constructor.
     *
     * @param  Employee  $employee
     */
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
    }
}
