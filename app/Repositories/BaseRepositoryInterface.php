<?php

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param  RequestPaginate  $request
     * @return mixed
     */
    public function getPagination(RequestPaginate $request): array;

    /**
     * @param  RequestPaginate  $request
     * @param $relationship
     * @return mixed
     */
    public function getPaginationWithRelationship(RequestPaginate $request, $relationship): array;

    /**
     * @param $columns
     * @param $value
     * @return mixed
     */
    public function getByColumns($columns, $value): array;

    /**
     * @param $columns
     * @param $value
     * @param $relationship
     * @return mixed
     */
    public function getByColumnsWithRelationship($columns, $value, $relationship): array;

    /**
     * @param $value
     * @return array
     */
    public function getById($value): array;

    /**
     * @param $value
     * @param $relationship
     * @return array
     */
    public function getByIdWithRelationship($value, $relationship): array;
}
