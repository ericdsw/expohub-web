<?php
namespace ExpoHub\AccessControllers;

use ExpoHub\Exceptions\MalformedApiAccessTokenException;
use ExpoHub\Exceptions\NoApiAccessTokenException;
use ExpoHub\Repositories\Contracts\ApiTokenRepository;

class ApiAccessController
{
	/** @var ApiTokenRepository */
	private $apiTokenRepository;

	/**
	 * ApiAccessController constructor
	 *
	 * @param ApiTokenRepository $apiTokenRepository
	 */
	public function __construct(ApiTokenRepository $apiTokenRepository)
	{
		$this->apiTokenRepository = $apiTokenRepository;
	}

	/**
	 * Checks whether the request contains API authorization
	 *
	 * @param array $requestHeaders
	 * @return bool
	 * @throws MalformedApiAccessTokenException
	 * @throws NoApiAccessTokenException
	 */
	public function canUseApi(array $requestHeaders)
	{
		if (array_key_exists('x-api-authorization', $requestHeaders)) {

			$authArray = explode('.', $requestHeaders['x-api-authorization'][0]);

			if (count($authArray) != 2) {
				throw new MalformedApiAccessTokenException;
			}

			$appId 		= $authArray[0];
			$appSecret 	= $authArray[1];

			return ($this->apiTokenRepository->getByTokenAndSecret($appId, $appSecret) != null);
		} else {
			throw new NoApiAccessTokenException;
		}
	}
}
