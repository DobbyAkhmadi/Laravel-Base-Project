<?php

namespace App\Repositories;

use App\Http\Requests\RequestPaginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

interface BaseRepositoryInterface
{
    /**
     * @param  FormRequest  $request
     * @return mixed
     */
    public function save(FormRequest $request): Model;

    /**
     * @param  FormRequest  $request
     * @return mixed
     */
    public function update(FormRequest $request): Model;

    /**
     * @param  string  $id
     * @return mixed
     */
    public function deleteById(string $id): Model;

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
    public function getByColumns($columns, $value): mixed;

    /**
     * @param $columns
     * @param $value
     * @param $relationship
     * @return mixed
     */
    public function getByColumnsWithRelationship($columns, $value, $relationship): mixed;

    /**
     * @param $value
     * @return Model
     */
    public function getById($value): Model;

    /**
     * @param $value
     * @param $relationship
     * @return Model
     */
    public function getByIdWithRelationship($value, $relationship): Model;
}
