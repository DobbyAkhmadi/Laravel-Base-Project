<?php

use App\Http\Requests\GetIdEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

/**
 * Interface EmployeeInterface
 */
interface EmployeeInterface extends BaseRepositoryInterface
{
    public function save(StoreEmployeeRequest $request);

    public function update(UpdateEmployeeRequest $request);

    public function delete(GetIdEmployeeRequest $request);
}
