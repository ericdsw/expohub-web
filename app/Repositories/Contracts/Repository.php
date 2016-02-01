<?php

namespace ExpoHub\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface Repository
{
	/**
	 * Returns a list of the specified array
	 * 
	 * @param  array $eagerLoading
	 * @return Collection
	 */
	public function all(array $eagerLoading = []);

	/**
	 * Returns resource with specified id
	 * 
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Model
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 * 
	 * @param  array $parameters
	 * @return Model
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 * 
	 * @param  int $id
	 * @param  array $parameters
	 * @return Model
	 */
	public function update($id, array $parameters);

	/**
	 * Deletes specified resource
	 * 
	 * @param  int $id
	 * @return int
	 */
	public function delete($id);
}