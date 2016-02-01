<?php

namespace ExpoHub\Repositories\Contracts;


use ExpoHub\Fair;
use Illuminate\Database\Eloquent\Collection;

interface FairRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Fair
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Fair
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Fair
	 */
	public function update($id, array $parameters);

	/**
	 * Returns fairs created by the user
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByUser($userId);

	/**
	 * Returns fairs the user can manage without owning
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getHelpingFairsByUser($userId);

	/**
	 * Returns fairs the user was banned
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getBannedFairsByUser($userId);

	/**
	 * Returns current active fairs
	 *
	 * @return Collection
	 */
	public function getActiveFairs();
}