<?php

namespace App\Http\Controllers\API\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiBadRequestException extends ApiException
{
    /**
     * The error message
     *
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="Request Invalid!"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(self::BAD_REQUEST, $message ?: Response::$statusTexts[self::BAD_REQUEST]);
    }
}
