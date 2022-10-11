<?php

use Illuminate\Database\Eloquent\Model;
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
        $searchByColumn = $request->input('searchBy');
        if (! empty($searchByColumn) && $searchByColumn != '') {
            $searchResult = explode(',', $searchByColumn);
            if (count($searchResult) > 0) {
                $query->where(DB::raw("lower($searchResult[0])"), 'like', '%'.strtolower($searchResult[1]).'%');
            }
        }

        // filter by column
        $filterByColumn = $request->input('filterByColumn');
        if (! empty($filterByColumn) && $filterByColumn != '') {
            $selectResult = explode(',', $filterByColumn);
            if (count($selectResult) > 0) {
                $query->select($selectResult);
            }
        }

        // sorting by column name
        $sortByColumn = $request->input('sortBy');
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
        $searchByColumn = $request->input('searchBy');
        if (! empty($searchByColumn) && $searchByColumn != '') {
            $searchResult = explode(',', $searchByColumn);
            if (count($searchResult) > 0) {
                $query->where(DB::raw("lower($searchResult[0])"), 'like', '%'.strtolower($searchResult[1]).'%');
            }
        }

        // filter by column
        $filterByColumn = $request->input('filterByColumn');
        if (! empty($filterByColumn) && $filterByColumn != '') {
            $selectResult = explode(',', $filterByColumn);
            if (count($selectResult) > 0) {
                $query->select($selectResult);
            }
        }

        // sorting by column name
        $sortByColumn = $request->input('sortBy');
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
    public function getByColumns($columns, $value): array
    {
        $data = $this->model->where($columns, $value)->first();
        if (! empty($data)) {
            return [
                'status' => Response::HTTP_OK,
                'message' => 'successfully retrieved data',
                'data' => $data,
            ];
        } else {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => 'Content not found',
            ];
        }
    }

    /**
     * @param $columns
     * @param $value
     * @param $relationship
     * @return array
     */
    public function getByColumnsWithRelationship($columns, $value, $relationship): array
    {
        $data = $this->model->where($columns, $value)->with($relationship)->first();
        if (! empty($data)) {
            return [
                'status' => Response::HTTP_OK,
                'message' => 'successfully retrieved data',
                'data' => $data,
            ];
        } else {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => 'Content not found',
            ];
        }
    }

    /**
     * @param $value
     * @return array
     */
    public function getById($value): array
    {
        $data = $this->model->find($value)->first();
        if (! empty($data)) {
            return [
                'status' => Response::HTTP_OK,
                'message' => 'successfully retrieved data',
                'data' => $data,
            ];
        } else {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => 'Content not found',
            ];
        }
    }

    /**
     * @param $value
     * @param $relationship
     * @return array
     */
    public function getByIdWithRelationship($value, $relationship): array
    {
        $data = $this->model->find($value)->with($relationship)->first();
        if (! empty($data)) {
            return [
                'status' => Response::HTTP_OK,
                'message' => 'successfully retrieved data',
                'data' => $data,
            ];
        } else {
            return [
                'status' => Response::HTTP_NO_CONTENT,
                'message' => 'Content not found',
            ];
        }
    }
}
