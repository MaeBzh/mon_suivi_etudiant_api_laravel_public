<?php

namespace App\Exceptions;

use App\Helpers\HttpResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $e)
    {
        /** @var Request $request */
        if ($request->expectsJson()) {
            if ($e instanceof ValidationException) {
                return response()->json($e->errors(), $e->status);
            }

            $errorCode = $e instanceof AuthorizationException ? 403 : $e->getCode();
            $errorCode = HttpResponse::isValidHttpStatusCode($errorCode) ? $errorCode : 500;
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e,
            ], $errorCode);
        }

        return parent::render($request, $e);
    }
}
