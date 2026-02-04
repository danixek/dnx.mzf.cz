<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Http\Controllers\ErrorController;
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
    public function render($request, Throwable $exception)
    {
        // Zjistíme status code
        $status = 500;
        if ($exception instanceof HttpExceptionInterface) {
            $status = $exception->getStatusCode();
        }

        return app(ErrorController::class)->show($request, $status);
    }
}
