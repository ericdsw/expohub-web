<?php


namespace ExpoHub\Repositories\Contracts;


use ExpoHub\Speaker;
use Illuminate\Database\Eloquent\Collection;

interface SpeakerRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return Speaker
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return Speaker
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return Speaker
	 */
	public function update($id, array $parameters);

	/**
	 * Returns speaker for specified fair event
	 *
	 * @param $fairEventId
	 * @return Collection
	 */
	public function getByFairEvents($fairEventId);
}