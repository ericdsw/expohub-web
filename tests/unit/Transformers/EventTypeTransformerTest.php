<?php

use ExpoHub\EventType;
use ExpoHub\Transformers\EventTypeTransformer;

class EventTypeTransformerTest extends TestCase
{
	/** @var EventTypeTransformer */
	private $transformer;

	public function setUp()
	{
		parent::setUp();
		$this->transformer = new EventTypeTransformer;
	}

	/** @test */
	public function it_transforms_event_type()
	{
		$eventType = $this->makeEventType();

		$transformedArray = $this->transformer->transform($eventType);

		$this->assertEquals([
			'id' => 1,
			'name' => 'event-type-name'
		], $transformedArray);
	}

	private function makeEventType()
	{
		$eventType = new EventType;
		$eventType->id = 1;
		$eventType->name = 'event-type-name';

		return $eventType;
	}
}