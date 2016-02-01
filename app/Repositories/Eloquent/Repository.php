<?php

namespace ExpoHub\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use ExpoHub\Repositories\Contracts\Repository as RepositoryContract;

abstract class Repository implements RepositoryContract
{
	protected $model;

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
		return $this->model->with($eagerLoading)->get();
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
		return $this->model->with($eagerLoading)->findOrFail($id);
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
		return $this->model->update($id, $parameters);
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
}