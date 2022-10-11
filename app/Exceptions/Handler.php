<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use PDOException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): JsonResponse|\Illuminate\Http\Response|Response
    {
        if ($e instanceof HttpException && $e->getStatusCode() == Response::HTTP_FORBIDDEN) {
            abort(response()->json(
                [
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_FORBIDDEN
            ));
        } elseif ($e instanceof HttpException && $e->getStatusCode() == Response::HTTP_UNAUTHORIZED) {
            abort(response()->json(
                [
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_UNAUTHORIZED
            ));
        } elseif ($e instanceof HttpException && $e->getStatusCode() == Response::HTTP_NOT_FOUND) {
            abort(response()->json(
                [
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => 'The requested API does not exist | please check the parameters or endpoint',
                ],
                Response::HTTP_NOT_FOUND
            ));
        } elseif ($e instanceof HttpException && $e->getStatusCode() == Response::HTTP_INTERNAL_SERVER_ERROR) {
            abort(response()->json(
                [
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            ));
        } elseif ($e instanceof HttpException && $e->getStatusCode() == Response::HTTP_BAD_REQUEST) {
            abort(response()->json(
                [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => $e->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST
            ));
        } elseif ($e instanceof PDOException) {
            abort(response()->json(
                [
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => 'Database Error or Not Connected with message : '.$e->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            ));
        } elseif ($e instanceof PostTooLargeException) {
            abort(response()->json(
                [
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => 'File too large!',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            ));
        }

        return parent::render($request, $e);
    }
}
