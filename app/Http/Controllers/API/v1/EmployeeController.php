<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\GetIdEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Requests\RequestPaginate;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{

    /**
     * @var EmployeeService
     */
    protected EmployeeService $employeeService;

    /**
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->middleware(['permission:Employee@index'], ['only' => ['index']]);
        $this->middleware(['permission:Employee@show'], ['only' => ['show']]);
        $this->middleware(['permission:Employee@store'], ['only' => ['store']]);
        $this->middleware(['permission:Employee@update'], ['only' => ['update']]);
        $this->middleware(['permission:Employee@destroy'], ['only' => ['destroy']]);
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  RequestPaginate  $requestPaginate
     * @return JsonResponse
     */
    public function index(RequestPaginate $requestPaginate): JsonResponse
    {
        return response()->json($this->employeeService->getPagination($requestPaginate));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  GetIdEmployeeRequest  $request
     * @return JsonResponse
     */
    public function show(GetIdEmployeeRequest $request): JsonResponse
    {
        return response()->json($this->employeeService->show($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEmployeeRequest  $request
     * @return JsonResponse
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        return response()->json($this->employeeService->store($request));
    }

    /**
     * Update existing resource in storage.
     *
     * @param  UpdateEmployeeRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateEmployeeRequest $request): JsonResponse
    {
        return response()->json($this->employeeService->update($request));
    }

    /**
     * Delete a listing of the resource.
     *
     * @param  GetIdEmployeeRequest  $request
     * @return JsonResponse
     */
    public function destroy(GetIdEmployeeRequest $request): JsonResponse
    {
        return response()->json($this->employeeService->delete($request));
    }
}
