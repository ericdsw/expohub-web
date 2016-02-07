<?php

use ExpoHub\Map;
use ExpoHub\Transformers\MapTransformer;

class MapTransformerTest extends TestCase
{
	/** @var MapTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new MapTransformer;
	}

	/** @test */
	public function it_transforms_map()
	{
		$map = $this->makeMap();

		$transformedArray = $this->transformer->transform($map);

		$this->assertEquals([
			'id' => 1,
			'name' => 'map-name',
			'image' => 'map-image'
		], $transformedArray);
	}

	/**
	 * @return Map
	 */
	private function makeMap()
	{
		$map = new Map;
		$map->id = 1;
		$map->name = 'map-name';
		$map->image = 'map-image';

		return $map;
	}
}