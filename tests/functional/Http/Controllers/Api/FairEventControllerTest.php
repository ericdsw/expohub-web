<?php

use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\FairEventRepository;

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
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_displays_specific_fair_event()
	{
		$this->get('api/v1/fairEvents/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_displays_specific_fair_event_with_includes()
	{
		$includeString = 'fair,eventType,speakers,attendingUsers,categories';

		$this->get('api/v1/fairEvents/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
		$this->seeJsonContains(['type' => 'fair']);
		$this->seeJsonContains(['type' => 'event-type']);
		$this->seeJsonContains(['type' => 'speaker']);
		$this->seeJsonContains(['type' => 'user']);
		$this->seeJsonContains(['type' => 'category']);
	}

	/** @test */
	public function it_creates_fair_event()
	{
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
			->with('/uploads', $uploadedFile)
			->once()
			->andReturn('foo');

		$this->call('POST', '/api/v1/fairEvents', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_fails_fair_event_creation_with_invalid_parameters()
	{
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
			->with('/uploads', $uploadedFile)
			->once()
			->andReturn('foo');

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
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

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_fails_update_with_incorrect_parameters()
	{
		$parameters = [
			// No title parameter
			'description' => 'baz',
			'date' => 'qux',
			'location' => 'foo-bar',
			'fair_id' => 1,
			'event_type_id' => 1
		];

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters);

		$this->assertResponseStatus(422);
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

		$this->call('PUT', 'api/v1/fairEvents/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_fair_event()
	{
		$fileManager = $this->mock(FileManager::class);
		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/fairEvents/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_displays_fair_events_by_fair()
	{
		$this->get('api/v1/fairs/1/fairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_displays_fair_events_by_event_type()
	{
		$this->get('api/v1/eventTypes/1/fairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
	}

	/** @test */
	public function it_displays_fair_events_by_attending_user()
	{
		$this->get('api/v1/users/1/attendingFairEvents');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair-event']);
	}
}