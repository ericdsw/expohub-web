<?php

namespace ExpoHub\Transformers;

use ExpoHub\EventType;

class EventTypeTransformer extends BaseTransformer
{
	/**
	 * Converts EventType to valid json representation
	 *
	 * @param EventType $eventType
	 * @return array
	 */
	public function transform(EventType $eventType)
	{
		return [
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
}