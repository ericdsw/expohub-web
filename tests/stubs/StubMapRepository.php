<?php

use ExpoHub\Fair;
use ExpoHub\Map;
use ExpoHub\Repositories\Contracts\MapRepository;

class StubMapRepository implements MapRepository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \ExpoHub\Map
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createMap();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\Map
	 */
	public function create(array $parameters)
	{
		return $this->createMap();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\Map
	 */
	public function update($id, array $parameters)
	{
		return $this->createMap();
	}

	/**
	 * Returns all maps registered on the specified fair
	 *
	 * @param $fairId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getByFair($fairId)
	{
		return collect([$this->createMap()]);
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createMap()]);
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
	 * @return Map
	 */
	private function createMap()
	{
		$map = new Map();

		// Properties
		$map->id = 1;
		$map->name = "foo";
		$map->image = "bar.jpg";

		// Relations
		$map->setRelation('fair', new Fair);

		return $map;
	}
}