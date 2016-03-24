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
		if($e instanceof NotFoundHttpException) {
			return response()->json([
				'errors' => [[
					'title' 	=> 'not_found_url',
					'message' 	=> 'Requested url not found',
					'status' 	=> 404
				]]
			], 404, ['Content-Type' => 'application/vnd.api+json']);
		}

        if ($e instanceof ModelNotFoundException) {
			return response()->json([
				'errors' => [[
					'title' 	=> 'not_found',
					'message' 	=> 'Requested data not found',
					'status' 	=> 404
				]]
			], 404, ['Content-Type' => 'application/vnd.api+json']);
        }

		if($e instanceof MethodNotAllowedException) {
			return response()->json([
				'errors' => [[
					'title' 	=> 'method_not_allowed',
					'message' 	=> 'Method not allowed, allowed HTTP verbs include ' . implode(', ', $e->getAllowedMethods()),
					'status' 	=> 405
				]]
			], Response::HTTP_METHOD_NOT_ALLOWED, ['Content-Type' => 'application/vnd.api+json']);
		}

        return parent::render($request, $e);
    }
}
