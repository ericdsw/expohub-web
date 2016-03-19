<?php

use ExpoHub\AccessControllers\EventTypeAccessController;
use ExpoHub\Repositories\Contracts\EventTypeRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
	public function it_returns_not_found_if_event_type_does_not_exists()
	{
		$this->mock(EventTypeRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/eventTypes/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_stores_new_event_type()
	{
		$request = ['name' => 'foo'];

		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canCreateEventType')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->post('api/v1/eventTypes', $request);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'event-type']);
	}

	/** @test */
	public function it_returns_unauthorized_on_create_event_type_for_non_admin_users()
	{
		$request = ['name' => 'foo'];

		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canCreateEventType')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->post('api/v1/eventTypes', $request);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_event_type_if_user_is_not_logged_in()
	{
		$request = ['name' => 'foo'];

		$this->post('api/v1/eventTypes', $request);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_event_type_if_user_has_expired_session()
	{
		$request = ['name' => 'foo'];

		$this->loginForApiWithExpiredToken();

		$this->post('api/v1/eventTypes', $request);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_to_store_new_event_with_incorrect_parameters()
	{
		$request = [];

		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canCreateEventType')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->post('api/v1/eventTypes', $request);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_existing_event_type()
	{
		$request = ['name' => 'foo'];

		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canUpdateEventType')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->put('api/v1/eventTypes/1', $request);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'event-type']);
	}

	/** @test */
	public function it_returns_unauthorized_on_update_event_type_for_non_admin_users()
	{
		$request = ['name' => 'foo'];

		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canUpdateEventType')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->put('api/v1/eventTypes/1', $request);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_existing_event_type_for_not_logged_users()
	{
		$request = ['name' => 'foo'];

		$this->put('api/v1/eventTypes/1', $request);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_existing_event_type_for_users_with_expired_session()
	{
		$request = ['name' => 'foo'];

		$this->loginForApiWithExpiredToken();

		$this->put('api/v1/eventTypes/1', $request);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_update_existing_event_type_with_incorrect_parameters()
	{
		$request = [];

		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canUpdateEventType')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->put('api/v1/eventTypes/1', $request);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_specified_event_type()
	{
		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canDeleteEventType')
			->withNoArgs()
			->once()
			->andReturn(true);

		$this->delete('api/v1/eventTypes/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_on_delete_event_type_for_non_admin_users()
	{
		$this->loginForApi();

		$this->mock(EventTypeAccessController::class)
			->shouldReceive('canDeleteEventType')
			->withNoArgs()
			->once()
			->andReturn(false);

		$this->delete('api/v1/eventTypes/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_event_type_for_not_logged_users()
	{
		$this->delete('api/v1/eventTypes/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_event_type_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/eventTypes/1');

		$this->assertResponseStatus(401);
	}
}