<?php

namespace ExpoHub\Repositories\Contracts;


use ExpoHub\Stand;

interface StandRepository extends Repository
{
	/**
	 * Returns stands on specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);

	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Stand
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Stand
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Stand
	 */
	public function update($id, array $parameters);
}