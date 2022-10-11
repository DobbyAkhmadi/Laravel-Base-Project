<?php

namespace App\Http\Controllers\API\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Schema()
 */
class ApiSystemException extends ApiException
{
    /**
     * The error message
     *
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="System Internal Error!"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(self::SYS_ERROR, $message ?? Response::$statusTexts[self::SYS_ERROR]);
    }
}
