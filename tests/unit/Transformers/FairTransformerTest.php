<?php

use Carbon\Carbon;
use ExpoHub\Fair;
use ExpoHub\Transformers\FairTransformer;

class FairTransformerTest extends TestCase
{
	/** @var FairTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new FairTransformer;
	}

	/** @test */
	public function it_transforms_fair()
	{
		$fair = $this->makeFair();

		$transformedArray = $this->transformer->transform($fair);

		$this->assertEquals([
			'id' => 1,
			'name' => 'fair-name',
			'image' => asset('fair-image'),
			'description' => 'fair-description',
			'website' => 'fair-website',
			'starting_date' => Carbon::now()->subDay(),
			'ending_date' => Carbon::now()->addDay(),
			'address' => 'fair-address',
			'latitude' => 9.9,
			'longitude' => 8.8
		], $transformedArray);
	}

	/**
	 * @return Fair
	 */
	private function makeFair()
	{
		$fair = new Fair;
		$fair->id = 1;
		$fair->name = 'fair-name';
		$fair->image = 'fair-image';
		$fair->description = 'fair-description';
		$fair->website = 'fair-website';
		$fair->starting_date = Carbon::now()->subDay();
		$fair->ending_date = Carbon::now()->addDay();
		$fair->address = 'fair-address';
		$fair->latitude = 9.9;
		$fair->longitude = 8.8;

		return $fair;
	}
}