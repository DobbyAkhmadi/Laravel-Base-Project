<?php

namespace App\Http\Controllers\API\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ApiUnauthenticatedException extends ApiException
{
    /**
     * The error message
     *
     * @var string
     *
     * @OA\Property(
     *   property="message",
     *   type="string",
     *   example="unauthorized !"
     * )
     */
    public function __construct(string $message = null)
    {
        parent::__construct(self::UNAUTHORIZED, $message ?? Response::$statusTexts[self::UNAUTHORIZED]);
    }
}
