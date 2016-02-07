<?php
namespace ExpoHub\Transformers;

use ExpoHub\Map;

class MapTransformer extends BaseTransformer
{
	/**
	 * Converts map to valid json
	 *
	 * @param Map $map
	 * @return array
	 */
	public function transform(Map $map)
	{
		return [
			'id' => $map->id,
			'name' => $map->name,
			'image' => $map->image
		];
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return 'map';
	}
}