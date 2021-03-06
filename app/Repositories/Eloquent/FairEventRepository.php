<?php
namespace ExpoHub\Repositories\Eloquent;

use ExpoHub\FairEvent;
use ExpoHub\Repositories\Contracts\FairEventRepository as FairEventRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class FairEventRepository extends Repository implements FairEventRepositoryContract
{
	/**
	 * FairEventRepository constructor.
	 * @param FairEvent $model
	 */
	public function __construct(FairEvent $model)
	{
		parent::__construct($model);
	}

	/**
	 * Returns the FairEvents registered under a Fair
	 *
	 * @param $fairId
	 * @return Collection
	 */
	public function getByFair($fairId)
	{
		return $this->prepareQuery()->where('fair_id', $fairId)->get();
	}

	/**
	 * Returns the FairEvents registered under specified EventType
	 *
	 * @param $eventType
	 * @return Collection
	 */
	public function getByEventType($eventType)
	{
		return $this->prepareQuery()->where('event_type_id', $eventType)->get();
	}

	/**
	 * Returns all events the user is attending to
	 *
	 * @param $userId
	 * @return Collection
	 */
	public function getByAttendingUser($userId)
	{
		return $this->prepareQuery()->whereHas('attendingUsers', function($query) use ($userId) {
			$query->where('users.id', '=', $userId);
		})->get();
	}

	/**
	 * Returns all events registered under specified categories
	 *
	 * @param array $categories
	 * @return Collection
	 */
	public function getByCategories($categories = [])
	{
		return $this->prepareQuery()->whereHas('categories', function ($query) use ($categories) {
			$query->whereIn('categories.id', $categories);
		})->get();
	}

	/**
	 * Adds user to event's attending list
	 *
	 * @param $userId
	 * @param $eventId
	 */
	public function attendEvent($userId, $eventId)
	{
		$event = $this->model->findOrFail($eventId);
		$event->attendingUsers()->attach($userId);
		$event->attendance += 1;
		$event->save();
	}

	/**
	 * Removes user from event's attending list
	 *
	 * @param $userId
	 * @param $eventId
	 */
	public function unAttendEvent($userId, $eventId)
	{
		$event = $this->model->findOrFail($eventId);
		$event->attendingUsers()->detach($userId);
		$event->attendance -= 1;
		$event->save();
	}
}
