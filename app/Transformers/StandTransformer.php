<?php

namespace ExpoHub\Transformers;


use ExpoHub\Stand;
use League\Fractal\Resource\Item;

class StandTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fair'];

	/**
	 * Converts Stand to json
	 *
	 * @param Stand $stand
	 * @return array
	 */
	public function transform(Stand $stand)
	{
		return [
			'id' 			=> (int) $stand->id,
			'name' 			=> $stand->name,
			'description' 	=> $stand->description,
			'image' 		=> $stand->image
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return "stand";
	}

	/**
	 * Includes related Fair
	 *
	 * @param Stand $stand
	 * @return Item
	 */
	public function includeFair(Stand $stand)
	{
		$fair = $stand->fair;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->item($fair, $fairTransformer, $fairTransformer->getType());
	}
}