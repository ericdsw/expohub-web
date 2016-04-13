<?php

use ExpoHub\Category;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class StubCategoryRepository implements CategoryRepository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Category
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createCategory();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Category
	 */
	public function create(array $parameters)
	{
		return $this->createCategory();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Category
	 */
	public function update($id, array $parameters)
	{
		return $this->createCategory();
	}

	/**
	 * Returns categories registered in specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return collect([$this->createCategory()]);
	}

	/**
	 * Returns categories registered for all the user's fairs
	 *
	 * @param $userId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getByUser($userId)
	{
		return collect([$this->createCategory()]);
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createCategory()]);
	}

	/**
	 * Deletes specified resource
	 *
	 * @param  int $id
	 * @return int
	 */
	public function delete($id)
	{
		return collect([$this->createCategory()]);
	}

	/**
	 * Creates category
	 *
	 * @return Category
	 */
	private function createCategory()
	{
		$category = new Category;

		// Overwrite date format
		$category->setDateFormat('Y');

		// Parameters
		$category->id = 1;
		$category->name = "foo";

		// Relationships
		$category->setRelation('fair', new Fair);
		$category->setRelation('fairEvents', collect([new FairEvent]));

		return $category;
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
		// TODO: Implement prepareLimit() method.
	}
}