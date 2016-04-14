<?php

use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\SpeakerRepository;
use ExpoHub\Speaker;

class StubSpeakerRepository implements SpeakerRepository
{
	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createSpeaker()]);
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
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \ExpoHub\Speaker
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createSpeaker();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\Speaker
	 */
	public function create(array $parameters)
	{
		return $this->createSpeaker();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\Speaker
	 */
	public function update($id, array $parameters)
	{
		return $this->createSpeaker();
	}

	/**
	 * Returns speaker for specified fair event
	 *
	 * @param $fairEventId
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getByFairEvents($fairEventId)
	{
		return collect([$this->createSpeaker()]);
	}

	/**
	 * @return Speaker
	 */
	private function createSpeaker()
	{
		$speaker = new Speaker;

		// Parameters
		$speaker->id = 1;
		$speaker->name = 'foo';
		$speaker->picture = 'bar';
		$speaker->description = 'baz';

		// Relations
		$speaker->setRelation('fairEvent', new FairEvent);

		return $speaker;
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