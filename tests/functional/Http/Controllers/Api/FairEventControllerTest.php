<?php

use ExpoHub\AccessControllers\FairEventAccessController;
use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\FairEventRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FairEventControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(FairEventRepository::class, new StubFairEventRepository);
	}

	/** @test */
	public function it_displays_all_fair_events()
	{
		$this->get('api/v1/fairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_displays_specific_fair_event()
	{
		$this->get('api/v1/fairEvents/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_displays_specific_fair_event_with_includes()
	{
		$includeString = 'fair,eventType,speakers,attendingUsers,categories';

		$this->get('api/v1/fairEvents/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
		$this->seeJsonContains(['type' => 'fairs']);
		$this->seeJsonContains(['type' => 'eventTypes']);
		$this->seeJsonContains(['type' => 'speakers']);
		$this->seeJsonContains(['type' => 'users']);
		$this->seeJsonContains(['type' => 'categories']);
	}

	/** @test */
	public function it_returns_not_found_if_fair_event_does_not_exists()
	{
		$this->mock(FairEventRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/fairEvents/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_fair_event()
	{
		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canCreateFairEventForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();
		$fileManager = $this->mock(FileManager::class);
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $uploadedFile)
			->once()
			->andReturn('foo');

		$this->call('POST', '/api/v1/fairEvents', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_create_fair_event()
	{
		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canCreateFairEventForFair')
			->with(1)
			->once()
			->andReturn(false);

		$uploadedFile = $this->generateStubUploadedFile();
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('POST', '/api/v1/fairEvents', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_fair_event_for_not_logged_in_users()
	{
		$uploadedFile = $this->generateStubUploadedFile();
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('POST', '/api/v1/fairEvents', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_fair_event_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$uploadedFile = $this->generateStubUploadedFile();
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('POST', '/api/v1/fairEvents', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_fair_event_creation_with_invalid_parameters()
	{
		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canCreateFairEventForFair')
			->with(1)
			->once()
			->andReturn(true);


		$uploadedFile = $this->generateStubUploadedFile();
		$parameters = [
			// No title parameter
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('POST', '/api/v1/fairEvents', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_fair_event_creation_with_invalid_image()
	{
		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canCreateFairEventForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateInvalidStubUploadedFile();
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('POST', '/api/v1/fairEvents', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_fair_event_with_image()
	{
		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canUpdateFairEvent')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();
		$fileManager = $this->mock(FileManager::class);
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $uploadedFile)
			->once()
			->andReturn('foo');

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_updates_fair_event_without_image()
	{
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canUpdateFairEvent')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_returns_unauthorized_on_update_fair_event_if_user_cannot_update()
	{
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canUpdateFairEvent')
			->with(1)
			->once()
			->andReturn(false);

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_fair_event_if_user_is_not_logged_in()
	{
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_fair_event_if_user_has_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_update_with_incorrect_image()
	{
		$uploadedFile = $this->generateInvalidStubUploadedFile();
		$parameters = [
			'title' => 'foo',
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canUpdateFairEvent')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_fair_event()
	{
		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canDeleteFairEvent')
			->with(1)
			->once()
			->andReturn(true);

		$fileManager = $this->mock(FileManager::class);
		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/fairEvents/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_fair_event()
	{
		$this->loginForApi();

		$this->mock(FairEventAccessController::class)
			->shouldReceive('canDeleteFairEvent')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/fairEvents/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_fair_event_for_not_logged_in_users()
	{
		$this->delete('api/v1/fairEvents/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_fair_event_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/fairEvents/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_fair_events_by_fair()
	{
		$this->get('api/v1/fairs/1/fairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_displays_fair_events_by_event_type()
	{
		$this->get('api/v1/eventTypes/1/fairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_displays_fair_events_by_attending_user()
	{
		$this->get('api/v1/users/1/attendingFairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fairEvents']);
	}

	/** @test */
	public function it_attends_fair_event()
	{
		$this->loginForApi();

		$this->post('api/v1/fairEvents/1/attend');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_wont_attend_fair_event_if_user_is_not_logged_in()
	{
		$this->post('api/v1/fairEvents/1/attend');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_attend_fair_event_if_user_has_expired_token()
	{
		$this->loginForApiWithExpiredToken();

		$this->post('api/v1/fairEvents/1/attend');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_un_attends_fair_event()
	{
		$this->loginForApi();

		$this->post('api/v1/fairEvents/1/unAttend');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_wont_un_attend_fair_event_if_user_is_not_logged_in()
	{
		$this->post('api/v1/fairEvents/1/unAttend');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_un_attend_fair_event_if_user_has_expired_token()
	{
		$this->loginForApiWithExpiredToken();

		$this->post('api/v1/fairEvents/1/unAttend');

		$this->assertResponseStatus(401);
	}
}