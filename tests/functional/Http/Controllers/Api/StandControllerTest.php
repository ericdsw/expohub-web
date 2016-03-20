<?php

use ExpoHub\AccessControllers\StandAccessController;
use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\StandRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StandControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(StandRepository::class, new StubStandRepository);
	}

	/** @test */
	public function it_displays_all_stands()
	{
		$this->get('api/v1/stands');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_displays_specific_stand()
	{
		$this->get('api/v1/stands/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_displays_specific_stand_with_include_parameters()
	{
		$includeString = 'fair';
		$this->get('api/v1/stands/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_returns_not_found_if_stand_does_not_exists()
	{
		$this->mock(StandRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/stands/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_stand()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canCreateStandForFair')
			->with(1)
			->once()
			->andReturn(true);

		$stubUploadedFile = $this->generateStubUploadedFile();

		$this->mock(FileManager::class)->shouldReceive('uploadFile')
			->with('/uploads', $stubUploadedFile)
			->once();

		$this->call('POST', 'api/v1/stands', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_create_stand()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canCreateStandForFair')
			->with(1)
			->once()
			->andReturn(false);

		$stubUploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/stands', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_stand_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_id' => 1
		];

		$stubUploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/stands', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_stand_if_user_has_expired_token()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_id' => 1
		];

		$stubUploadedFile = $this->generateStubUploadedFile();

		$this->loginForApiWithExpiredToken();

		$this->call('POST', 'api/v1/stands', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_creating_stand_with_invalid_parameters()
	{
		$parameters = [
			// No name parameter
			'description' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canCreateStandForFair')
			->with(1)
			->once()
			->andReturn(true);

		$stubUploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/stands', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_creating_stand_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canCreateStandForFair')
			->with(1)
			->once()
			->andReturn(true);

		$stubUploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('POST', 'api/v1/stands', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_stand_with_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canUpdateStand')
			->with(1)
			->once()
			->andReturn(true);

		$stubUploadedFile = $this->generateStubUploadedFile();
		$fileManager = $this->mock(FileManager::class);

		$fileManager->shouldReceive('uploadFile')
			->with('/uploads', $stubUploadedFile)
			->once();

		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->call('PUT', 'api/v1/stands/1', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_updates_stand_without_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canUpdateStand')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/stands/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_update_stand()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canUpdateStand')
			->with(1)
			->once()
			->andReturn(false);

		$this->call('PUT', 'api/v1/stands/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_stand_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->call('PUT', 'api/v1/stands/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_stand_if_user_has_expired_session()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApiWithExpiredToken();

		$this->call('PUT', 'api/v1/stands/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_wont_update_stand_with_invalid_parameters()
	{
		$parameters = [
			// No name
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canUpdateStand')
			->with(1)
			->once()
			->andReturn(true);

		$stubUploadedFile = $this->generateStubUploadedFile();

		$this->call('PUT', 'api/v1/stands/1', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_wont_update_stand_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar'
		];

		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canUpdateStand')
			->with(1)
			->once()
			->andReturn(true);

		$stubUploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/stands/1', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_stand()
	{
		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canDeleteStand')
			->with(1)
			->once()
			->andReturn(true);

		$this->mock(FileManager::class)->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/stands/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_stand()
	{
		$this->loginForApi();

		$this->mock(StandAccessController::class)
			->shouldReceive('canDeleteStand')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/stands/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_stand_if_user_is_not_logged_in()
	{
		$this->delete('api/v1/stands/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_stand_if_user_has_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/stands/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_stand_by_fair()
	{
		$this->get('api/v1/fairs/1/stands');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}
}