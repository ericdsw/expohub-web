<?php

use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\SponsorRepository;

class SponsorControllerTest extends BaseControllerTestCase
{
	public function setUp()
	{
		parent::setUp();
		app()->instance(SponsorRepository::class, new StubSponsorRepository);
	}

	/** @test */
	public function it_displays_all_sponsors()
	{
		$this->get('api/v1/sponsors');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_displays_specific_sponsor()
	{
		$this->get('api/v1/sponsors/1');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_displays_specific_sponsor_with_includes()
	{
		$includeString = 'fair,sponsorRank';
		$this->get('api/v1/sponsors/1?include=' . $includeString);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
		$this->seeJsonContains(['type' => 'fair']);
		$this->seeJsonContains(['type' => 'sponsor-rank']);
	}

	/** @test */
	public function it_creates_sponsor()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz',
			'fair_id' => 1,
			'sponsor_rank_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->mock(FileManager::class)->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile)
			->once();

		$this->call('POST', 'api/v1/sponsors', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_fails_creating_sponsor_with_invalid_parameters()
	{
		$parameters = [
			// Missing name parameter
			'slogan' => 'bar',
			'website' => 'baz',
			'fair_id' => 1,
			'sponsor_rank_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/sponsors', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_creating_sponsor_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz',
			'fair_id' => 1,
			'sponsor_rank_id' => 1
		];

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('POST', 'api/v1/sponsors', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_updates_sponsor_with_image()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$uploadedFile = $this->generateStubUploadedFile();
		$fileManager = $this->mock(FileManager::class);

		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$fileManager->shouldReceive('uploadFile')
			->with('/uploads', $uploadedFile)
			->once();

		$this->call('PUT', 'api/v1/sponsors/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_updates_sponsor_without_image()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$this->call('PUT', 'api/v1/sponsors/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_fails_updating_sponsor_with_invalid_parameters()
	{
		$parameters = [
			// No name
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$this->call('PUT', 'api/v1/sponsors/1', $parameters);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_fails_updating_sponsor_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/sponsors/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_sponsor()
	{
		$this->mock(FileManager::class)->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/sponsors/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_displays_sponsors_by_fair()
	{
		$this->get('api/v1/fairs/1/sponsors');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_displays_sponsors_by_sponsor_rank()
	{
		$this->get('api/v1/sponsorRanks/1/sponsors');

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}
}