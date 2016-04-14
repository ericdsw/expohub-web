<?php

namespace ExpoHub\Http\Middleware;

use Closure;
use ExpoHub\AccessControllers\ApiAccessController;
use ExpoHub\Exceptions\MalformedApiAccessTokenException;
use ExpoHub\Exceptions\NoApiAccessTokenException;

class CheckApiToken
{
	/** @var ApiAccessController */
	private $apiAccessController;

	/**
	 * CheckApiToken constructor.
	 * @param ApiAccessController $apiAccessController
	 */
	public function __construct(ApiAccessController $apiAccessController)
	{
		$this->apiAccessController = $apiAccessController;
	}

	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		try {
			if($this->apiAccessController->canUseApi($request->headers->all())) {
				return $next($request);
			}
			else {
				return response()->json([
					'errors' => [[
						'title' 	=> 'invalid_api_token',
						'message' 	=> 'Provided api token is not valid for this request',
						'status' 	=> 403
					]]
				], 403, ['Content-Type' => 'application/vnd.api+json']);
			}
		}
		catch(NoApiAccessTokenException $e) {
			return response()->json([
				'errors' => [[
					'title' 	=> 'no_api_access_token_provided',
					'message' 	=> 'Missing api token',
					'status' 	=> 400
				]]
			], 400, ['Content-Type' => 'application/vnd.api+json']);
		}
		catch(MalformedApiAccessTokenException $e) {
			return response()->json([
				'errors' => [[
					'title' 	=> 'malformed_api_token',
					'message' 	=> 'Malformed api token',
					'status' 	=> 400
				]]
			], 400, ['Content-Type' => 'application/vnd.api+json']);
		}
    }
}
