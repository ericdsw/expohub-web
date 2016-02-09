<?php

namespace ExpoHub\Transformers;


use ExpoHub\Speaker;
use League\Fractal\Resource\Item;

class SpeakerTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fairEvent'];

	/**
	 * Converts Speaker to json
	 *
	 * @param Speaker $speaker
	 * @return array
	 */
	public function transform(Speaker $speaker)
	{
		return [
			'id' => (int) $speaker->id,
			'name' => $speaker->name,
			'picture' => $speaker->picture,
			'description' => $speaker->description
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "speaker";
	}

	/**
	 * Includes related FairEvent
	 *
	 * @param Speaker $speaker
	 * @return Item
	 */
	public function includeFairEvent(Speaker $speaker)
	{
		$fairEvent = $speaker->fairEvent;
		$fairEventTransformer = app()->make(FairEventTransformer::class);
		return $this->item($fairEvent, $fairEventTransformer, $fairEventTransformer->getType());
	}
}