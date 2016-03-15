<?php

use ExpoHub\EventType;
use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\EventTypeRepository;

class StubEventTypeRepository implements EventTypeRepository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return \ExpoHub\EventType
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createEventType();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return \ExpoHub\EventType
	 */
	public function create(array $parameters)
	{
		return $this->createEventType();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return \ExpoHub\EventType
	 */
	public function update($id, array $parameters)
	{
		return $this->createEventType();
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createEventType()]);
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
	 * @return EventType
	 */
	private function createEventType()
	{
		$eventType = new EventType;

		// Overwrite date format
		$eventType->setDateFormat('Y');

		// Parameters
		$eventType->id = 1;
		$eventType->name = "foo";

		// Relationships
		$eventType->setRelation('events', collect([new FairEvent]));

		return $eventType;
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