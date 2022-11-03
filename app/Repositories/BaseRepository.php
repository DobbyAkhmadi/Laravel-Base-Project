<?php

namespace App\Repositories;

use App\Http\Requests\RequestPaginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @param  Model  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param  RequestPaginate  $request
     * @return array
     */
    public function getPagination(RequestPaginate $request): array
    {
        $query = $this->model->query();

        // search by column name
        $searchByColumn = $request->searchBy;
        if (! empty($searchByColumn) && $searchByColumn != '') {
            $searchResult = explode(',', $searchByColumn);
            if (count($searchResult) > 0) {
                $query->where(DB::raw("lower($searchResult[0])"), 'like', '%'.strtolower($searchResult[1]).'%');
            }
        }

        // filter by column
        $filterByColumn = $request->filterByColumn;
        if (! empty($filterByColumn) && $filterByColumn != '') {
            $selectResult = explode(',', $filterByColumn);
            if (count($selectResult) > 0) {
                $query->select($selectResult);
            }
        }

        // sorting by column name
        $sortByColumn = $request->sortBy;
        if (! empty($sortByColumn) && $sortByColumn != '') {
            $sortResult = explode(',', $sortByColumn);
            if (count($sortResult) > 0) {
                $query->orderBy($sortResult[0], $sortResult[1]);
            }
        }

        // pagination filter
        $pageIndex = $request->input('pageIndex', 1);
        $pageSize = $request->input('pageSize', 5);
        $total = $query->count();

        $result = $query->offset(($pageIndex - 1) * $pageSize)
                ->limit($pageSize)
                ->get();

        if ($result->isEmpty()) {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => 'content not found',
            ];
        }

        return [
            'status' => Response::HTTP_OK,
            'message' => 'successfully retrieved data',
            'data' => $result,
            'total' => $total,
            'pageIndex' => $pageIndex,
            'pageSize' => $pageSize,
            'totalPage' => ceil($total / $pageSize),
        ];
    }

    /**
     * @param  RequestPaginate  $request
     * @param $relationship
     * @return mixed
     */
    public function getPaginationWithRelationship(RequestPaginate $request, $relationship): array
    {
        $query = $this->model->query()->with($relationship);

        // search by column name
        $searchByColumn = $request->searchBy;
        if (! empty($searchByColumn) && $searchByColumn != '') {
            $searchResult = explode(',', $searchByColumn);
            if (count($searchResult) > 0) {
                $query->where(DB::raw("lower($searchResult[0])"), 'like', '%'.strtolower($searchResult[1]).'%');
            }
        }

        // filter by column
        $filterByColumn = $request->filterByColumn;
        if (! empty($filterByColumn) && $filterByColumn != '') {
            $selectResult = explode(',', $filterByColumn);
            if (count($selectResult) > 0) {
                $query->select($selectResult);
            }
        }

        // sorting by column name
        $sortByColumn = $request->sortBy;
        if (! empty($sortByColumn) && $sortByColumn != '') {
            $sortResult = explode(',', $sortByColumn);
            if (count($sortResult) > 0) {
                $query->orderBy($sortResult[0], $sortResult[1]);
            }
        }

        // pagination filter
        $pageIndex = $request->input('pageIndex', 1);
        $pageSize = $request->input('pageSize', 5);
        $total = $query->count();

        $result = $query->offset(($pageIndex - 1) * $pageSize)
            ->limit($pageSize)
            ->get();

        if ($result->isEmpty()) {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => 'content not found',
            ];
        }

        return [
            'status' => Response::HTTP_OK,
            'message' => 'successfully retrieved data',
            'data' => $result,
            'total' => $total,
            'pageIndex' => $pageIndex,
            'pageSize' => $pageSize,
            'totalPage' => ceil($total / $pageSize),
        ];
    }

    /**
     * @param $columns
     * @param $value
     * @return mixed
     */
    public function getByColumns($columns, $value): mixed
    {
        return $this->model->where($columns, $value)->first();
    }

    /**
     * @param $columns
     * @param $value
     * @param $relationship
     * @return array
     */
    public function getByColumnsWithRelationship($columns, $value, $relationship): mixed
    {
        return $this->model->where($columns, $value)->with($relationship)->first();
    }

    /**
     * @param $value
     * @return Model
     */
    public function getById($value): Model
    {
        return $this->model->find($value)->first();
    }

    /**
     * @param $value
     * @param $relationship
     * @return Model
     */
    public function getByIdWithRelationship($value, $relationship): Model
    {
        return $this->model->find($value)->with($relationship)->first();
    }

    public function save(FormRequest $request): Model
    {
        $model = new $this->model;
        $model->fill($request->validated());
        $model->save();

        return $model;
    }

    public function update(FormRequest $request): Model
    {
        $model = $this->model->find($request->id);
        $model->fill($request->validated());
        $model->update();

        return $model;
    }

    public function deleteById(string $id): Model
    {
        $model = $this->model->find($id);
        $model->delete();

        return $model;
    }
}
