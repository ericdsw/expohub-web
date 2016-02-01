<?php


namespace ExpoHub\Repositories\Contracts;


use Illuminate\Database\Eloquent\Collection;

interface FairEventRepository extends Repository
{
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
}