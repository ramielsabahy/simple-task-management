<?php

namespace App\Exceptions;
use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

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
     * @param Exception $exception
     * @return void
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->isJson() || $request->wantsJson()) {
            $this->jsonHandler($exception);
        }


        return parent::render($request, $exception);
    }

    public function jsonHandler($exception)
    {
        $debug = env('APP_DEBUG', false);
        if ($exception instanceof AuthenticationException) {

            throw new HttpResponseException(response()->json([
                'data'  => null,
                'message'  => $exception->getMessage(),
            ], 403));
        }

        if ($exception instanceof ModelNotFoundException) {
            $title = 'resource_not_found';
            $detail = trans('app.Resource not found');


            if ($debug) {
                $title = $exception->getMessage() ?? '';
                $detail = $exception->getTrace();
            }

            throw new HttpResponseException(response()->json([
                'data'  => null,
                'message'  => $exception->getMessage(),
            ], 404));
        }

        if ($exception instanceof AuthorizationException) {

            throw new HttpResponseException(response()->json([
                'data'  => null,
                'message'  => $exception->getMessage(),
            ], 403));
        }
        if ($exception instanceof HttpException  && $exception->getStatusCode() == 403) {

            throw new HttpResponseException(response()->json([
                'data'  => null,
                'message'  => $exception->getMessage(),
            ], 403));
        }
        if ($exception instanceof ValidationException) {
            $errorArray = [];
            $errors = $exception->errors();
            $index = array_keys($errors)[0];
            throw new HttpResponseException(
                response()->json([
                    'data'  => null,
                    'message'  => $errors[$index][0],
                ], 422)
            );
        }


        if ($exception instanceof CustomErrorException) {


            if ($exception->getCode() == 422) {
                $errors = [

                    [
                        'title' => trans('general.Validation Error'),
                        'detail' => $exception->getMessage(),
                        'status' => $exception->getCode(),
                    ]
                ];
                throw new HttpResponseException(response()->json([
                    'errors' => $errors], 422));
            }
            $title = 'oops_something_is_broken';
            $detail = trans('app.Oopps Something is broken');

            $errors = [
                [
                    'status' => 500,
                    'title' => $title,
                    'detail' => $detail
                ]];
            if (env('APP_DEBUG') == true) {
                $line = $exception->getLine();
                $title = $exception->getMessage();
                $detail = $exception->getTrace();
                $file = $exception->getFile();


                $errors = [
                    [
                        'status' => 500,
                        'title' => $file,
                        'detail' => $file
                    ],
                    [
                        'status' => 500,
                        'title' => $title,
                        'detail' => $detail
                    ],
                    [
                        'status' => 500,
                        'title' => $line,
                        'detail' => $file
                    ]
                ];
            }

            throw new HttpResponseException(response()->json([
                'data'  => null,
                'message'  => $exception->getMessage(),
                'status_code' => StatusCodesEnum::FAILED
            ], 500));
        }
    }
}
