<?php

namespace ExpoHub\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use ExpoHub\Repositories\Contracts\Repository as RepositoryContract;

abstract class Repository implements RepositoryContract
{
	protected $model;
	protected $eagerLoading;

	protected $orderParameters = [];

	protected $offset;
	protected $limit;

	/**
	 * @param Model $model
	 */
	public function __construct(Model $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Returns a list of the specified array
	 * 
	 * @param  array $eagerLoading
	 * @return Collection
	 */
	public function all(array $eagerLoading = []) 
	{
		return $this->prepareQuery()->get();
	}

	/**
	 * Returns resource with specified id
	 * 
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Model
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->prepareQuery()->findOrFail($id);
	}

	/**
	 * Creates resource with specified parameters
	 * 
	 * @param  array $parameters
	 * @return Model
	 */
	public function create(array $parameters)
	{
		return $this->model->create($parameters);
	}

	/**
	 * Updates specified resource with supplied parameters
	 * 
	 * @param  int $id
	 * @param  array $parameters
	 * @return Model
	 */
	public function update($id, array $parameters)
	{
		$model = $this->model->find($id);
		$model->update($parameters);
		return $model;
	}

	/**
	 * Deletes specified resource
	 * 
	 * @param  int $id
	 * @return int
	 */
	public function delete($id)
	{
		return $this->model->delete($id);
	}

	/**
	 * Prepares eager loading for consulting queries
	 *
	 * @param array $eagerLoading
	 */
	public function prepareEagerLoading(array $eagerLoading)
	{
		$this->eagerLoading = $eagerLoading;
	}

	/**
	 * Prepares result order for consulting queries
	 *
	 * @param $parameter
	 * @param $order
	 */
	public function prepareOrderBy($parameter, $order)
	{
		$this->orderParameters[$parameter] = $order;
	}

	/**
	 * Prepares result limit and offset for effective pagination
	 *
	 * @param $limit
	 * @param int $offset
	 */
	public function prepareLimit($limit, $offset = 0)
	{
		$this->limit 	= $limit;
		$this->offset 	= $offset;
	}

	/**
	 * Creates the query
	 *
	 * @param null $modelQuery
	 * @return Builder
	 */
	protected function prepareQuery($modelQuery = null)
	{
		$query = $this->model->query();
		if($modelQuery != null) {
			$query = $modelQuery->query();
		}

		foreach($this->orderParameters as $parameter => $order) {
			$query = $query->orderBy($parameter, $order);
		}

		if($this->eagerLoading != null) {
			$query = $query->with($this->eagerLoading);
		}

		if($this->offset !== null && $this->limit !== null) {
			$query->skip($this->offset)->take($this->limit);
		}

		return $query;
	}
}