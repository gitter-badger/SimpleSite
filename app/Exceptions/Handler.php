<?php

namespace App\Exceptions;

use App\Http\RestApiResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    use ValidatesRequests;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return $this->buildFailedValidationResponse(
                $request,
                $e->validator->errors()->toArray()
            );
        }

        if ((($request->ajax() && ! $request->pjax()) || $request->wantsJson()) or ($e instanceof RestApiControllerException)) {
            return RestApiResponse::createFromException($request, $e);
        }

        if ($e instanceof ModelNotFoundException) {
            $model = $e->getModel();

            if (method_exists($model, 'getNotFoundMessage')) {
                $message = app()->make($model)->getNotFoundMessage();
            } else {
                $message = trans('core.message.model_not_found');
            }

            abort(404, $message);
        }

        if ($e instanceof QueryException) {
            abort(500, trans('core.message.something_went_wrong'));
        }

        return parent::render($request, $e);
    }
}
