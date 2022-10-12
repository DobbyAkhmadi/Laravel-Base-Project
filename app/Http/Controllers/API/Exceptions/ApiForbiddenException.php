<?php

namespace App\Http\Controllers\API\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiForbiddenException extends ApiException
{
    /**
     * The error message
     *
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="Request forbidden permission error!"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(self::PERMISSION_ERROR, $message ?: Response::$statusTexts[self::PERMISSION_ERROR]);
    }
}
