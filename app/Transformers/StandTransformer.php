<?php

namespace ExpoHub\Transformers;


use ExpoHub\Stand;

class StandTransformer extends BaseTransformer
{
	/**
	 * Converts Stand to json
	 *
	 * @param Stand $stand
	 * @return array
	 */
	public function transform(Stand $stand)
	{
		return [
			'id' => (int) $stand->id,
			'name' => $stand->name,
			'description' => $stand->description,
			'image' => $stand->image
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "stand";
	}
}