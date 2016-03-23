<?php

use ExpoHub\AccessControllers\SponsorAccessController;
use ExpoHub\Helpers\Files\Contracts\FileManager;
use ExpoHub\Repositories\Contracts\SponsorRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
	public function it_returns_not_found_if_sponsor_does_not_exists()
	{
		$this->mock(SponsorRepository::class)
			->shouldReceive('find')
			->andThrow(ModelNotFoundException::class);

		$this->get('api/v1/sponsors/1');

		$this->assertResponseStatus(404);
		$this->seeJson();
		$this->seeJsonContains(['title' => 'not_found']);
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

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canCreateSponsorForFair')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->mock(FileManager::class)->shouldReceive('uploadFile')
			->with('uploads/', $uploadedFile)
			->once();

		$this->call('POST', 'api/v1/sponsors', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(201);
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_create_sponsor()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz',
			'fair_id' => 1,
			'sponsor_rank_id' => 1
		];

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canCreateSponsorForFair')
			->with(1)
			->once()
			->andReturn(false);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/sponsors', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_create_sponsor_for_not_logged_users()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz',
			'fair_id' => 1,
			'sponsor_rank_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('POST', 'api/v1/sponsors', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_create_sponsor_for_users_with_expired_session()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz',
			'fair_id' => 1,
			'sponsor_rank_id' => 1
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->loginForApiWithExpiredToken();

		$this->call('POST', 'api/v1/sponsors', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(401);
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

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canCreateSponsorForFair')
			->with(1)
			->once()
			->andReturn(true);

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

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canCreateSponsorForFair')
			->with(1)
			->once()
			->andReturn(true);

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

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canUpdateSponsor')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateStubUploadedFile();
		$fileManager = $this->mock(FileManager::class);

		$fileManager->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$fileManager->shouldReceive('uploadFile')
			->with('uploads/', $uploadedFile)
			->once();

		$this->call('PUT', 'api/v1/sponsors/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_update_sponsor()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canUpdateSponsor')
			->with(1)
			->once()
			->andReturn(false);

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('PUT', 'api/v1/sponsors/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_update_sponsor_if_user_is_not_logged_in()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->call('PUT', 'api/v1/sponsors/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_update_sponsor_if_user_has_expired_session()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$uploadedFile = $this->generateStubUploadedFile();

		$this->loginForApiWithExpiredToken();

		$this->call('PUT', 'api/v1/sponsors/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(401);
	}

	/** @test */
	public function it_updates_sponsor_without_image()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canUpdateSponsor')
			->with(1)
			->once()
			->andReturn(true);

		$this->call('PUT', 'api/v1/sponsors/1', $parameters);

		$this->assertResponseOk();
		$this->seeJson();
		$this->seeJsonContains(['type' => 'sponsor']);
	}

	/** @test */
	public function it_fails_updating_sponsor_with_invalid_image()
	{
		$parameters = [
			'name' => 'foo',
			'slogan' => 'bar',
			'website' => 'baz'
		];

		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canUpdateSponsor')
			->with(1)
			->once()
			->andReturn(true);

		$uploadedFile = $this->generateInvalidStubUploadedFile();

		$this->call('PUT', 'api/v1/sponsors/1', $parameters, [], ['image' => $uploadedFile]);

		$this->assertResponseStatus(422);
	}

	/** @test */
	public function it_deletes_sponsor()
	{
		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canDeleteSponsorRank')
			->with(1)
			->once()
			->andReturn(true);

		$this->mock(FileManager::class)->shouldReceive('deleteFile')
			->withAnyArgs()
			->once();

		$this->delete('api/v1/sponsors/1');

		$this->assertResponseStatus(204);
	}

	/** @test */
	public function it_returns_unauthorized_if_user_cannot_delete_sponsor()
	{
		$this->loginForApi();

		$this->mock(SponsorAccessController::class)
			->shouldReceive('canDeleteSponsorRank')
			->with(1)
			->once()
			->andReturn(false);

		$this->delete('api/v1/sponsors/1');

		$this->assertResponseStatus(403);
	}

	/** @test */
	public function it_wont_delete_sponsor_if_user_is_not_logged_in()
	{
		$this->delete('api/v1/sponsors/1');

		$this->assertResponseStatus(400);
	}

	/** @test */
	public function it_wont_delete_sponsor_if_user_has_expired_session()
	{
		$this->loginForApiWithExpiredToken();

		$this->delete('api/v1/sponsors/1');

		$this->assertResponseStatus(401);
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