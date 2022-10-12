<?php

namespace App\Repositories\Employee;

use App\Http\Requests\GetIdEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

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

    public function save(StoreEmployeeRequest $request): Model
    {
        $model = $this->model;
        $model->fill($request->validated());
        $model->save();

        return $model;
    }

    public function update(UpdateEmployeeRequest $request): Model
    {
        $model = $this->model;
        $model->fill($request->validated());
        $model->save();

        return $model;
    }

    public function delete(GetIdEmployeeRequest $request): Model|array
    {
        try {
            $arrayResult = explode(',', $request->id);
            $count = count($arrayResult);
            for ($i = 0; $i < $count; $i++) {
                $delete = $this->model->findOrFail($arrayResult[$i]);
                $delete->delete();
            }
        } catch (ModelNotFoundException) {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => 'content not found',
            ];
        }

        return [
            'status' => Response::HTTP_OK,
            'message' => 'delete successfully with id : '.$request->id,
        ];
    }
}
