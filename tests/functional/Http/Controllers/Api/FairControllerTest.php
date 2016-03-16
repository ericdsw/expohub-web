<?php

use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\FairRepository;

class FairControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(FairRepository::class, new StubFairRepository);
	}

	/** @test */
	public function it_displays_all_fairs()
	{
		$this->get('api/v1/fairs');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_displays_specified_fair()
	{
		$this->get('api/v1/fairs/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_displays_specific_fair_with_includes()
	{
		$includes = 'user,bannedUsers,helperUsers,sponsors,maps,categories,fairEvents,news,stands';

		$this->get('api/v1/fairs/1?include=' . $includes);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
		$this->seeJsonContains(['type' => 'user']);
		$this->seeJsonContains(['type' => 'sponsor']);
		$this->seeJsonContains(['type' => 'map']);
		$this->seeJsonContains(['type' => 'category']);
		$this->seeJsonContains(['type' => 'fair-event']);
		$this->seeJsonContains(['type' => 'news']);
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_creates_fair()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$file = $this->generateStubUploadedFile();

		$fileManager = $this->mock(FileManager::class);
		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $file)
			->once();

		$this->call('POST', 'api/v1/fairs', $parameters, [], ['image' => $file]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_fails_creating_fair_with_invalid_parameters()
	{
		$parameters = [
			// Missing the 'name' parameter, which is required
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$file = $this->generateStubUploadedFile();
		$this->call('POST', 'api/v1/fairs', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_creating_fair_with_invalid_image()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
			'user_id' => 1,
		];

		$this->call('POST', 'api/v1/fairs', $parameters, [], []);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_existing_fair_with_image()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$file = $this->generateStubUploadedFile();

		$fileManager = $this->mock(FileManager::class);
		$fileManager->shouldReceive('deleteFile');
		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $file)
			->once();

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_updates_existing_fair_without_image()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$this->mock(FileManager::class);

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], []);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_fails_update_existing_fair_with_invalid_parameters()
	{
		$parameters = [
			// Missing name parameters
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$file = $this->generateStubUploadedFile();
		$this->mock(FileManager::class);

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_update_existing_fair_with_invalid_images()
	{
		$parameters = [
			'name' => 'name',
			'description' => 'desc',
			'website' => 'wbs',
			'starting_date' => 'date',
			'ending_date' => 'date',
			'address' => 'address',
			'latitude' => 10,
			'longitude' => 22,
		];

		$file = $this->generateInvalidStubUploadedFile();
		$this->mock(FileManager::class);

		$this->call('PUT', 'api/v1/fairs/1', $parameters, [], ['image' => $file]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_existing_fair()
	{
		$this->mock(FileManager::class)->shouldReceive('deleteFile');
		$this->delete('api/v1/fairs/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_displays_all_active_fairs()
	{
		$this->get('api/v1/fairs/active');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
	}

	/** @test */
	public function it_displays_all_fairs_by_users()
	{
		$this->geT('api/v1/users/1/fairs');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'fair']);
	}
}