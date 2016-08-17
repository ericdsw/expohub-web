<?php
namespace ExpoHub\Repositories\Contracts;

use ExpoHub\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Category
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Category
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Category
	 */
	public function update($id, array $parameters);

	/**
	 * Returns categories registered in specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);

	/**
	 * Returns categories registered for all the user's fairs
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByUser($userId);
}
