<?php

use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\MapRepository;

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
	public function it_creates_map()
	{
		$parameters = [
			'name' => 'foo',
			'fair_id' => 1
		];
		$uploadedFile = $this->generateStubUploadedFile();
		$this->mock(FileManager::class)
			->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile);

		$this->call('POST', 'api/v1/maps', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}

	/** @test */
	public function it_fails_creating_map_with_invalid_parameters()
	{
		$parameters = [
			// Missing name parameter
			'fair_id' => 1
		];
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

		$this->call('PUT', 'api/v1/maps/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'map']);
	}

	/** @test */
	public function it_fails_updating_map_with_invalid_parameters()
	{
		$parameters = [
			// Name parameter missing
		];
		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('PUT', 'api/v1/maps/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_updating_map_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
		];
		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/maps/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_map()
	{
		$this->mock(FileManager::class)
			->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/maps/1');

		$this->assertResponseStatus(204);
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