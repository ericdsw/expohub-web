<?php

use Carbon\Carbon;
use ExpoHub\Category;
use ExpoHub\EventType;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\FairEventRepository;
use ExpoHub\Speaker;
use ExpoHub\User;
use Illuminate\Database\Eloquent\Collection;

class StubFairEventRepository implements FairEventRepository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return FairEvent
	 */
	public function find($id, array $eagerLoading = [])
	{
		return $this->createFairEvent();
	}

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return FairEvent
	 */
	public function create(array $parameters)
	{
		return $this->createFairEvent();
	}

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return FairEvent
	 */
	public function update($id, array $parameters)
	{
		return $this->createFairEvent();
	}

	/**
	 * Returns the FairEvents registered under a Fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return collect([$this->createFairEvent()]);
	}

	/**
	 * Returns the FairEvents registered under specified EventType
	 *
	 * @param $eventType
	 * @return Collection
	 */
	public function getByEventType($eventType)
	{
		return collect([$this->createFairEvent()]);
	}

	/**
	 * Returns all events the user is attending to
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByAttendingUser($userId)
	{
		return collect([$this->createFairEvent()]);
	}

	/**
	 * Returns all events registered under specified categories
	 *
	 * @param array $categories
	 * @return Collection
	 */
	public function getByCategories($categories = [])
	{
		return collect([$this->createFairEvent()]);
	}

	/**
	 * Returns a list of the specified array
	 *
	 * @param  array $eagerLoading
	 * @return Collection
	 */
	public function all(array $eagerLoading = [])
	{
		return collect([$this->createFairEvent()]);
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
	 * @return FairEvent
	 */
	private function createFairEvent()
	{
		$fairEvent = new FairEvent;

		// Overwrite date format
		$fairEvent->setDateFormat('Y');

		// Parameters
		$fairEvent->id = 1;
		$fairEvent->image = 'foo.jpg';
		$fairEvent->description = 'bar';
		$fairEvent->date = Carbon::now();
		$fairEvent->location = 'baz';

		// Relationships
		$fairEvent->setRelation('fair', new Fair);
		$fairEvent->setRelation('eventType', new EventType);
		$fairEvent->setRelation('speakers', collect([new Speaker]));
		$fairEvent->setRelation('attendingUsers', collect([new User]));
		$fairEvent->setRelation('categories', collect([new Category]));

		return $fairEvent;
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
	 * Adds user to event's attending list
	 *
	 * @param $userId
	 * @param $eventId
	 */
	public function attendEvent($userId, $eventId)
	{
		//
	}

	/**
	 * Removes user from event's attending list
	 *
	 * @param $userId
	 * @param $eventId
	 */
	public function unAttendEvent($userId, $eventId)
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