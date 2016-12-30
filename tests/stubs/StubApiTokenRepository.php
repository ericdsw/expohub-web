<?php

use ExpoHub\ApiToken;
use ExpoHub\Repositories\Contracts\ApiTokenRepository;

class StubApiTokenRepository implements ApiTokenRepository
{
	/**
	 * @param $appId
	 * @param $secret
	 * @return ApiToken
	 */
	public function getByTokenAndSecret($appId, $secret)
	{
		return $this->createApiToken();
	}

	/**
	 * Returns the app corresponding to the specified token
	 * @param  String $appToken The app token
	 * @return ApiToken         The specified api token
	 */
	public function getByToken($appToken) {
		return $this->createApiToken();
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createApiToken()]);
	}

	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createApiToken();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function create(array $parameters)
	{
		return $this->createApiToken();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function update($id, array $parameters)
	{
		return $this->createApiToken();
	}

	/**
	 * Deletes specified resource
	 *
	 * @param  int $id
	 * @return int
	 */
	public function delete($id)
	{
		return 1;
	}

	/**
	 * Prepares eager loading for consulting queries
	 *
	 * @param array $eagerLoading
	 */
	public function prepareEagerLoading(array $eagerLoading)
	{
		//
	}

	/**
	 * Prepares result order for consulting queries
	 *
	 * @param $parameter
	 * @param $order
	 */
	public function prepareOrderBy($parameter, $order)
	{
		//
	}

	/**
	 * Prepares result limit and offset for effective pagination
	 *
	 * @param $limit
	 * @param int $offset
	 */
	public function prepareLimit($limit, $offset = 0)
	{
		//
	}

	/**
	 * @return ApiToken
	 */
	private function createApiToken()
	{
		$apiToken = new ApiToken;

		$apiToken->id = 1;
		$apiToken->name = 'foo';
		$apiToken->app_id = 'bar';
		$apiToken->app_secret = 'baz';

		return $apiToken;
	}
}
