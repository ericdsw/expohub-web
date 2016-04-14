<?php
namespace ExpoHub\Transformers;

use ExpoHub\ApiToken;

class ApiTokenTransformer extends BaseTransformer
{
	/**
	 * Transforms ApiToken
	 *
	 * @param ApiToken $apiToken
	 * @return array
	 */
	public function transform(ApiToken $apiToken)
	{
		return [
			'id' => (int) $apiToken->id,
			'name' => $apiToken->name,
			'app_id' => $apiToken->app_id,
			'app_secret' => $apiToken->app_secret
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'apiTokens';
	}
}