<?php

use ExpoHub\AccessControllers\MapAccessController;
use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\MapRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MapControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(MapRepository::class, new StubMapRepository);
	}

	/** @test */
	public function it_displays_all_maps()
	{
		$this->get('api/v1/maps');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}

	/** @test */
	public function it_displays_specific_map()
	{
		$this->get('api/v1/maps/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}

	/** @test */
	public function it_displays_specific_map_with_includes()
	{
		$includeString = 'fair';

		$this->get('api/v1/maps/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_returns_not_found_if_map_does_not_exists()
	{
		$this->mock(MapRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/maps/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
	}

	/** @test */
	public function it_creates_map()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canCreateMapForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();
		$this->mock(FileManager::class)
			->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile);

		$this->call('POST', 'api/v1/maps', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}

	/** @test */
	public function it_returns_unauthorized_on_create_map_if_user_cannot_create_map()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canCreateMapForFair')
			->with(1)
			->once()
			->andReturn(false);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/maps', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_map_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/maps', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_map_if_user_has_expired_session()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->loginForApiWithExpiredToken();

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/maps', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_creating_map_with_invalid_parameters()
	{
		$parameters = [
			// Missing name parameter
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canCreateMapForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/maps', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_creating_map_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canCreateMapForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateInvalidStubUploadedFile();
		$this->mock(FileManager::class)
			->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile);

		$this->call('POST', 'api/v1/maps', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_existing_map_with_image()
	{
		$parameters = [
			'name' => 'foo',
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canUpdateMap')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();
		$fileManager = $this->mock(FileManager::class);

		$fileManager->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile);

		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->call('PUT', 'api/v1/maps/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}

	/** @test */
	public function it_updates_existing_map_without_image()
	{
		$parameters = [
			'name' => 'foo',
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canUpdateMap')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/maps/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_update_map()
	{
		$parameters = [
			'name' => 'foo',
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canUpdateMap')
			->with(1)
			->once()
			->andReturn(false);

		$this->call('PUT', 'api/v1/maps/1', $parameters);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_map_for_not_logged_in_users()
	{
		$parameters = [
			'name' => 'foo',
		];

		$this->call('PUT', 'api/v1/maps/1', $parameters);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_map_for_users_with_expired_session()
	{
		$parameters = [
			'name' => 'foo',
		];

		$this->loginForApiWithExpiredToken();

		$this->call('PUT', 'api/v1/maps/1', $parameters);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_fails_updating_map_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
		];

		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canUpdateMap')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/maps/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_map()
	{
		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canDeleteMap')
			->with(1)
			->once()
			->andReturn(true);

		$this->mock(FileManager::class)
			->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/maps/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_map()
	{
		$this->loginForApi();

		$this->mock(MapAccessController::class)
			->shouldReceive('canDeleteMap')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/maps/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_map_for_not_logged_users()
	{
		$this->delete('api/v1/maps/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_map_for_users_with_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/maps/1');

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_displays_maps_by_fair()
	{
		$this->get('api/v1/fairs/1/maps');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}
}