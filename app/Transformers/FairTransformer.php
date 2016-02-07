<?php

namespace ExpoHub\Transformers;


use ExpoHub\Fair;

class FairTransformer extends BaseTransformer
{
	/**
	 * Converts Fair to valid json
	 *
	 * @param Fair $fair
	 * @return array
	 */
	public function transform(Fair $fair)
	{
		return [
			'id' => (int) $fair->id,
			'name' => $fair->name,
			'image' => $fair->image,
			'description' => $fair->description,
			'website' => $fair->website,
			'starting_date' => $fair->starting_date,
			'ending_date' => $fair->ending_date,
			'address' => $fair->address,
			'latitude' => $fair->latitude,
			'longitude' => $fair->longitude,
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "fair";
	}
}