<?php

use ExpoHub\Stand;
use ExpoHub\Transformers\StandTransformer;

class StandTransformerTest extends TestCase
{
	/** @var StandTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new StandTransformer;
	}

	/** @test */
	public function it_transforms_stand()
	{
		$stand = $this->makeStand();

		$transformedArray = $this->transformer->transform($stand);

		$this->assertEquals([
			'id' => 1,
			'name' => 'stand-name',
			'description' => 'stand-description',
			'image' => 'stand-image'
		], $transformedArray);
	}

	/**
	 * @return Stand
	 */
	private function makeStand()
	{
		$stand = new Stand;
		$stand->id = 1;
		$stand->name = 'stand-name';
		$stand->description = 'stand-description';
		$stand->image = 'stand-image';

		return $stand;
	}
}