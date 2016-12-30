<?php
namespace ExpoHub\Repositories\Contracts;

use ExpoHub\ApiToken;

interface ApiTokenRepository extends Repository
{
	/**
	 * @param String $appId
	 * @param String $secret
	 * @return ApiToken
	 */
	public function getByTokenAndSecret($appId, $secret);

	/**
	 * Returns the app corresponding to the specified token
	 * @param  String $appToken The app token
	 * @return ApiToken         The specified api token
	 */
	public function getByToken($appToken);
}
