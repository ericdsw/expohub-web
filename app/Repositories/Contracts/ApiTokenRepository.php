<?php
namespace ExpoHub\Repositories\Contracts;

use ExpoHub\ApiToken;

interface ApiTokenRepository extends Repository
{
	/**
	 * @param $appId
	 * @param $secret
	 * @return ApiToken
	 */
	public function getByTokenAndSecret($appId, $secret);
}