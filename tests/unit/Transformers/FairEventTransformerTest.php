<?php

use Carbon\Carbon;
use ExpoHub\FairEvent;
use ExpoHub\Transformers\FairEventTransformer;

class FairEventTransformerTest extends TestCase
{
	/** @var FairEventTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new FairEventTransformer;
	}

	/** @test */
	public function it_transforms_fair_event()
	{
		$fairEvent = $this->makeFairEvent();

		$transformedArray = $this->transformer->transform($fairEvent);

		$this->assertEquals([
			'id' => 1,
			'title' => 'fair-event-title',
			'image' => asset('fair-event-image'),
			'description' => 'fair-event-description',
			'date' => Carbon::now(),
			'location' => 'fair-event-location',
			'attendance' => 10
		], $transformedArray);
	}

	/**
	 * @return FairEvent
	 */
	private function makeFairEvent()
	{
		$fairEvent = new FairEvent;
		$fairEvent->id = 1;
		$fairEvent->title = 'fair-event-title';
		$fairEvent->image = 'fair-event-image';
		$fairEvent->description = 'fair-event-description';
		$fairEvent->date = Carbon::now();
		$fairEvent->location = 'fair-event-location';
		$fairEvent->attendance = 10;

		return $fairEvent;
	}
}
