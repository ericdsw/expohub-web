<?php

namespace ExpoHub\Transformers;


use ExpoHub\FairEvent;

class FairEventTransformer extends BaseTransformer
{
	/**
	 * Converts FairEvent to valid json
	 *
	 * @param FairEvent $fairEvent
	 * @return array
	 */
	public function transform(FairEvent $fairEvent)
	{
		return [
			'id' => (int) $fairEvent->id,
			'title' => $fairEvent->title,
			'image' => $fairEvent->image,
			'description' => $fairEvent->description,
			'date' => $fairEvent->date,
			'location' => $fairEvent->location
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "fair-event";
	}
}