<?php

namespace ExpoHub\Transformers;


use ExpoHub\Speaker;

class SpeakerTransformer extends BaseTransformer
{
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
}