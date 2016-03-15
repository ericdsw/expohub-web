<?php


namespace ExpoHub\Repositories\Contracts;


use ExpoHub\News;
use Illuminate\Database\Eloquent\Collection;

interface NewsRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return News
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return News
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return News
	 */
	public function update($id, array $parameters);

	/**
	 * Returns all news posted to the specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);
}