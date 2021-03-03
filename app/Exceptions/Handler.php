<?php

namespace App\Exceptions;

use App\Services\Payment\Exceptions\PaymentException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        if ($exception instanceof PaymentException) {
            Log::channel('payment')->error($exception->getMessage());
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Throwable $exception
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof PaymentException) {
           return \response('Payment unavailable, Please try again to pay your order later', 503);
        }

        if ($exception instanceof ValidationException) {
            //return response($exception->getMessage());
        }

        return parent::render($request, $exception);
    }
}
