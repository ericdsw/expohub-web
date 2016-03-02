<?php

use ExpoHub\Repositories\Contracts\EventTypeRepository;

class EventTypeControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(EventTypeRepository::class, new StubEventTypeRepository);
	}

	/** @test */
	public function it_displays_all_event_types()
	{
		$this->get('api/v1/eventTypes');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'event-type']);
	}

	/** @test */
	public function it_displays_specific_event_type()
	{
		$this->get('api/v1/eventTypes/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'event-type']);
	}

	/** @test */
	public function it_displays_specific_event_type_with_includes()
	{
		$includes = 'events';

		$this->get('api/v1/eventTypes/1?include=' . $includes);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'event-type']);
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_stores_new_event_type()
	{
		$request = ['name' => 'foo'];

		$this->post('api/v1/eventTypes', $request);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'event-type']);
	}

	/** @test */
	public function it_fails_to_store_new_event_with_incorrect_parameters()
	{
		$request = [];

		$this->post('api/v1/eventTypes', $request);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_existing_event_type()
	{
		$request = ['name' => 'foo'];

		$this->put('api/v1/eventTypes/1', $request);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'event-type']);
	}

	/** @test */
	public function it_fails_update_existing_event_type_with_incorrect_parameters()
	{
		$request = [];

		$this->put('api/v1/eventTypes/1', $request);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_specified_event_type()
	{
		$this->delete('api/v1/eventTypes/1');

		$this->assertResponseStatus(204);
	}
}