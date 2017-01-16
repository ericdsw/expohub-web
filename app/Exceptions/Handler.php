<?php
namespace ExpoHub\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use ExpoHub\Helpers\Generators\Contracts\JsonErrorGenerator;
use ExpoHub\JsonError;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $jsonErrorGenerator = app()->make(JsonErrorGenerator::class);

		if ($e instanceof NotFoundHttpException) {
            return $jsonErrorGenerator->setStatus(404)
                ->appendError(
                    new JsonError("not_found_url", "Request url not found", "400", "")
                )->generateErrorResponse();
		}

        if ($e instanceof ModelNotFoundException) {
            return $jsonErrorGenerator->setStatus(404)
                ->appendError(
                    new JsonError("not_found_url", "Request data not found", "400", "")
                )->generateErrorResponse();
        }

		if ($e instanceof MethodNotAllowedException) {
            return $jsonErrorGenerator->setStatus(Response::HTTP_METHOD_NOT_ALLOWED)
                ->appendError(
                    new JsonError(
                        "method_not_allowed", 
                        "Method not allowed, allowed HTTP verbs include " . implode(', ', $e->getAllowedMethods()), 
                        (string) Response::HTTP_METHOD_NOT_ALLOWED, 
                        "")
                )->generateErrorResponse();
		}

        return parent::render($request, $e);
    }
}
