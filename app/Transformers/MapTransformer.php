<?php
namespace ExpoHub\Transformers;

use ExpoHub\Map;
use League\Fractal\Resource\Item;

class MapTransformer extends BaseTransformer
{
	protected $availableIncludes = ['fair'];

	/**
	 * Converts map to valid json
	 *
	 * @param Map $map
	 * @return array
	 */
	public function transform(Map $map)
	{
		return [
			'id' 	=> $map->id,
			'name' 	=> $map->name,
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

	/**
	 * Includes related Fair
	 *
	 * @param Map $map
	 * @return Item
	 */
	public function includeFair(Map $map)
	{
		$fair = $map->fair;
		$fairTransformer = app()->make(FairTransformer::class);
		return $this->item($fair, $fairTransformer, $fairTransformer->getType());
	}
}