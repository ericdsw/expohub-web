<?php

use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\StandRepository;

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
	public function it_creates_stand()
	{
		$parameters = [
			'name' => 'foo',
			'description' => 'bar',
			'fair_id' => 1
		];

		$stubUploadedFile = $this->generateStubUploadedFile();

		$this->mock(FileManager::class)->shouldReceive('uploadFile')
			->with('/uploads', $stubUploadedFile)
			->once();

		$this->call('POST', 'api/v1/stands', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_fails_creating_stand_with_invalid_parameters()
	{
		$parameters = [
			// No name parameter
			'description' => 'bar',
			'fair_id' => 1
		];

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

		$this->call('PUT', 'api/v1/stands/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'stand']);
	}

	/** @test */
	public function it_wont_update_stand_with_invalid_parameters()
	{
		$parameters = [
			// No name
			'description' => 'bar'
		];

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

		$stubUploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/stands/1', $parameters, [], ['image' => $stubUploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_stand()
	{
		$this->mock(FileManager::class)->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/stands/1');

		$this->assertResponseStatus(204);
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