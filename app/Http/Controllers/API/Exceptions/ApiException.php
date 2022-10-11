<?php

namespace App\Http\Controllers\API\Exceptions;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    const PERMISSION_ERROR = FoundationResponse::HTTP_FORBIDDEN;

    const NO_FOUND_ERROR = FoundationResponse::HTTP_NOT_FOUND;

    const SYS_ERROR = FoundationResponse::HTTP_INTERNAL_SERVER_ERROR;

    const BAD_REQUEST = FoundationResponse::HTTP_BAD_REQUEST;

    const UNAUTHORIZED = FoundationResponse::HTTP_UNAUTHORIZED;

    /**
     * ApiException constructor.
     *
     * @param  int  $statusCode
     * @param  string|null  $message
     */
    public function __construct(int $statusCode, string $message = null)
    {
        parent::__construct($statusCode, $message);
    }
}
