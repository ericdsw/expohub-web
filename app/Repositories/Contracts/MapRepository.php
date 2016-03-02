<?php


namespace ExpoHub\Repositories\Contracts;


use ExpoHub\Map;
use Illuminate\Database\Eloquent\Collection;

interface MapRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Map
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Map
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Map
	 */
	public function update($id, array $parameters);

	/**
	 * Returns all maps registered on the specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);
}