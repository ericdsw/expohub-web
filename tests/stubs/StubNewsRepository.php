<?php

use ExpoHub\Comment;
use ExpoHub\Fair;
use ExpoHub\News;
use ExpoHub\Repositories\Contracts\NewsRepository;
use Illuminate\Database\Eloquent\Collection;

class StubNewsRepository implements NewsRepository
{
	/**
	 * Returns all news posted to the specified fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return collect([$this->createNews()]);
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createNews()]);
	}

	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return News
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createNews();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return News
	 */
	public function create(array $parameters)
	{
		return $this->createNews();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return News
	 */
	public function update($id, array $parameters)
	{
		return $this->createNews();
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
	 * @return News
	 */
	private function createNews()
	{
		$news = new News;

		// Properties
		$news->id = 1;
		$news->title = "foo";
		$news->content = "bar";
		$news->image = "baz.jpg";

		// Relations
		$news->setRelation('fair', new Fair);
		$news->setRelation('comments', collect([new Comment]));

		return $news;
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
}