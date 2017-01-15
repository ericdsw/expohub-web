<?php
namespace ExpoHub\Transformers;

use ExpoHub\FairEvent;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class FairEventTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fair', 'eventType',
									'speakers', 'attendingUsers', 'categories'];

	/**
	 * Converts FairEvent to valid json
	 *
	 * @param FairEvent $fairEvent
	 * @return array
	 */
	public function transform(FairEvent $fairEvent)
	{
		return [
			'id' 			=> (int) $fairEvent->id,
			'title' 		=> $fairEvent->title,
			'image' 		=> $fairEvent->imageUrl(),
			'description' 	=> $fairEvent->description,
			'date' 			=> ($fairEvent->date != null) ? $fairEvent->date->toDateTimeString() : "",
			'location' 		=> $fairEvent->location,
			'attendance'	=> $fairEvent->attendance
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "fairEvents";
	}

	/**
	 * Includes related Fair
	 *
	 * @param FairEvent $fairEvent
	 * @return Item
	 */
	public function includeFair(FairEvent $fairEvent)
	{
		$fair = $fairEvent->fair;
		$fairEventTransformer = app()->make(FairTransformer::class);
		return $this->item($fair, $fairEventTransformer, $fairEventTransformer->getType());
	}

	/**
	 * Includes related EventType
	 *
	 * @param FairEvent $fairEvent
	 * @return Item
	 */
	public function includeEventType(FairEvent $fairEvent)
	{
		$eventType = $fairEvent->eventType;
		$eventTypeTransformer = app()->make(EventTypeTransformer::class);
		return $this->item($eventType, $eventTypeTransformer, $eventTypeTransformer->getType());
	}

	/**
	 * Include related FairEvents
	 *
	 * @param FairEvent $fairEvent
	 * @return Collection
	 */
	public function includeSpeakers(FairEvent $fairEvent)
	{
		$speakers = $fairEvent->speakers;
		$speakerTransformer = app()->make(SpeakerTransformer::class);
		return $this->collection($speakers, $speakerTransformer, $speakerTransformer->getType());
	}

	/**
	 * Include related AttendingUsers
	 *
	 * @param FairEvent $fairEvent
	 * @return Collection
	 */
	public function includeAttendingUsers(FairEvent $fairEvent)
	{
		$attendingUsers = $fairEvent->attendingUsers;
		$userTransformer = app()->make(UserTransformer::class);
		return $this->collection($attendingUsers, $userTransformer, $userTransformer->getType());
	}

	/**
	 * Include related
	 *
	 * @param FairEvent $fairEvent
	 * @return Collection
	 */
	public function includeCategories(FairEvent $fairEvent)
	{
		$categories = $fairEvent->categories;
		$categoryTransformer = app()->make(CategoryTransformer::class);
		return $this->collection($categories, $categoryTransformer, $categoryTransformer->getType());
	}
}
