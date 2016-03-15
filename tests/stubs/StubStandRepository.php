<?php

use ExpoHub\Fair;
use ExpoHub\Repositories\Contracts\StandRepository;
use ExpoHub\Stand;

class StubStandRepository implements StandRepository
{
	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \ExpoHub\Repositories\Contracts\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createStand()]);
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
	 * Returns stands on specified fair
	 *
	 * @param $fairId
	 * @return \ExpoHub\Repositories\Contracts\Collection
	 */
	public function getByFair($fairId)
	{
		return collect([$this->createStand()]);
	}

	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \ExpoHub\Stand
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createStand();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\Stand
	 */
	public function create(array $parameters)
	{
		return $this->createStand();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\Stand
	 */
	public function update($id, array $parameters)
	{
		return $this->createStand();
	}

	private function createStand()
	{
		$stand = new Stand;
		$stand->id = 1;
		$stand->name = "foo";
		$stand->description = "bar";
		$stand->image = "baz";

		$stand->setRelation('fair', new Fair);

		return $stand;
	}
}