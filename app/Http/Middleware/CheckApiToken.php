<?php
namespace ExpoHub\Http\Middleware;

use Closure;
use ExpoHub\JsonError;
use ExpoHub\AccessControllers\ApiAccessController;
use ExpoHub\Exceptions\MalformedApiAccessTokenException;
use ExpoHub\Exceptions\NoApiAccessTokenException;
use ExpoHub\Helpers\Generators\Contracts\JsonErrorGenerator;

class CheckApiToken
{
	/** @var ApiAccessController */
	private $apiAccessController;

	/** @var JsonErrorGenerator */
	private $jsonErrorGenerator;

	/**
	 * CheckApiToken constructor.
	 * @param ApiAccessController $apiAccessController
	 * @param JsonErrorGenerator $jsonErrorGenerator
	 */
	public function __construct(ApiAccessController $apiAccessController, JsonErrorGenerator $jsonErrorGenerator)
	{
		$this->apiAccessController 	= $apiAccessController;
		$this->jsonErrorGenerator 	= $jsonErrorGenerator;
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
			if ($this->apiAccessController->canUseApi($request->headers->all())) {
				return $next($request);
			} else {
				return $this->jsonErrorGenerator->setStatus(403)
					->appendError(
						new JsonError("invalid_api_token", "Provided api token is not valid for this request", "403", "")
					)->generateErrorResponse();
			}
		} catch(NoApiAccessTokenException $e) {
			return $this->jsonErrorGenerator->setStatus(400)
				->appendError(
					new JsonError("no_api_access_token_provided", "Missing api token", "400", "")
				)->generateErrorResponse();

		} catch(MalformedApiAccessTokenException $e) {
			return $this->jsonErrorGenerator->setStatus(400)
				->appendError(
					new JsonError("malformed_api_token", "Malformed api token", "400", "")
				)->generateErrorResponse();
		}
    }
}
