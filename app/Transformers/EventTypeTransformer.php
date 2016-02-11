<?php

namespace ExpoHub\Transformers;

use ExpoHub\EventType;
use League\Fractal\Resource\Collection;

class EventTypeTransformer extends BaseTransformer
{
	protected $availableIncludes = ['events'];

	/**
	 * Converts EventType to valid json representation
	 *
	 * @param EventType $eventType
	 * @return array
	 */
	public function transform(EventType $eventType)
	{
		return [
			'id' => (int) $eventType->id,
			'name' => $eventType->name
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "event-type";
	}

	/**
	 * Include related EventTypes
	 *
	 * @param EventType $eventType
	 * @return Collection
	 */
	public function includeEvents(EventType $eventType)
	{
		$events = $eventType->events;
		$eventTransformer = app()->make(EventTransformer::class);
		return $this->collection($events, $eventTransformer, $eventTransformer->getType());
	}
}