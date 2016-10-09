<?php
namespace ExpoHub\Repositories\Contracts;

use ExpoHub\FairEvent;
use Illuminate\Database\Eloquent\Collection;

interface FairEventRepository extends Repository
{
	/**
	 * Returns resource with specified id
	 *
	 * @param  int $id
	 * @param  array $eagerLoading
	 * @return FairEvent
	 */
	public function find($id, array $eagerLoading = []);

	/**
	 * Creates resource with specified parameters
	 *
	 * @param  array $parameters
	 * @return FairEvent
	 */
	public function create(array $parameters);

	/**
	 * Updates specified resource with supplied parameters
	 *
	 * @param  int $id
	 * @param  array $parameters
	 * @return FairEvent
	 */
	public function update($id, array $parameters);

	/**
	 * Returns the FairEvents registered under a Fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId);

	/**
	 * Returns the FairEvents registered under specified EventType
	 *
	 * @param $eventType
	 * @return Collection
	 */
	public function getByEventType($eventType);

	/**
	 * Returns all events the user is attending to
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByAttendingUser($userId);

	/**
	 * Returns all events registered under specified categories
	 *
	 * @param array $categories
	 * @return Collection
	 */
	public function getByCategories($categories = []);

	/**
	 * Adds user to event's attending list
	 *
	 * @param $userId
	 * @param $eventId
	 */
	public function attendEvent($userId, $eventId);

	/**
	 * Removes user from event's attending list
	 *
	 * @param $userId
	 * @param $eventId
	 */
	public function unAttendEvent($userId, $eventId);
}
