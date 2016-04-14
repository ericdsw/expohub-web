<?php
namespace ExpoHub\Repositories\Eloquent;

use ExpoHub\ApiToken;
use ExpoHub\Repositories\Contracts\ApiTokenRepository as ApiTokenRepositoryContract;

class ApiTokenRepository extends Repository implements ApiTokenRepositoryContract
{
	/**
	 * ApiTokenRepository constructor.
	 * @param ApiToken $model
	 */
	public function __construct(ApiToken $model)
	{
		parent::__construct($model);
	}

	/**
	 * @param $appId
	 * @param $secret
	 * @return ApiToken
	 */
	public function getByTokenAndSecret($appId, $secret)
	{
		return $this->prepareQuery()->where('app_id', $appId)
			->where('app_secret', $secret)->first();
	}
}